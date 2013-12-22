<?php
namespace Mk\Vote\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "Mk.Vote".                    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Ranking list
 *
 * @Flow\Entity
 */
class RankingList {
	
	/**
	 * The overview
	 * @var \Mk\Vote\Domain\Model\Overview
	 * @ORM\ManyToOne(inversedBy="rankingLists")
	 */
	protected $overview;

	/**
	 * The supervisory board
	 * @var \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\SupervisoryBoard>
	 * @ORM\OneToMany(mappedBy="rankingList")
	 * @ORM\OrderBy({"name" = "ASC"})
	 */
	protected $supervisoryBoards;

	/**
	 * The name
	 * @var string
	 */
	protected $name;

	/**
	 * The description
	 * @var string
	 */
	protected $description;
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $area = array('regional', 'international');
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $allConnectedSB = array('regional' => array('votes'=>0, 'seats'=>0,'seatsToCorrect'=>0),
									'international' => array('votes'=>0, 'seats'=>0,'seatsToCorrect'=>0));
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $listOfVotesFilteredInBothAreas;

	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $listOfVoteDifferences;
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $filteredListOfVoteDifferences;
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $parties = array();
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $votes = array();
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $votesAfterChangedData = array();
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $basicData;
	
	/**
	 * @var array $arguments
	 * @Flow\Transient
	 */
	protected $arguments;
	
	/**
	 * Constructs this ranking list
	 */
	public function __construct() {
		$this->supervisoryBoards = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the Ranking list's supervisory board
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\SupervisoryBoards> The Ranking list's supervisory board
	 */
	public function getSupervisoryBoards() {
		return $this->supervisoryBoards;
	}

	/**
	 * Get the Ranking list's name
	 *
	 * @return string The Ranking list's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Ranking list's name
	 *
	 * @param string $name The Ranking list's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Ranking list's description
	 *
	 * @return string The Ranking list's description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets this Ranking list's description
	 *
	 * @param string $description The Ranking list's description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * Get list of votes filtered in both areas
	 *
	 * @return array The list of votes filtered in both areas
	 */
	public function getListOfVotesFilteredInBothAreas() {
		return $this->listOfVotesFilteredInBothAreas;
	}
	
	/**
	 * Calculates the distribution of seats
	 *
	 * @param array $arguments The arguments
	 * @return void
	 */
	public function calculateSeatsDistribution($arguments){
		
	$this->setArguments($arguments);
		
	$this->beforeListCompare();
	$this->tooManyOrTooLessSeats();
	$this->setListOfVoteDifferences();
	$this->setFilteredListOfVoteDifferences();
	$this->addVoteDifferencesToSBs();

	}
	
	/**
	 * Do some calculations before comparing lists of supervisory bords.
	 *
	 * @return void
	 */
	protected function beforeListCompare(){
		$this->setStartData();
//		$this->setIdAsKeyForSupervisoryBoards();
		foreach($this->supervisoryBoards as $sb){
			
			$sb->basicCalculations();
			$this->setParties($sb);
		}
		
		$this->setAllConnectedSBstart();
	}
	
	/**
	 * Get all connected supervisory boards
	 *
	 * @return array All connected supervisory boards
	 */
	public function getAllConnectedSB() {
		return $this->allConnectedSB;
	}
	
	/**
	 * Sets start data together for all supervisory boards of this ranking list.
	 *
	 * @return void
	 */
	protected function setAllConnectedSBstart(){
		
		foreach($this->supervisoryBoards as $sb => $value){
			$votesOfSB = $this->supervisoryBoards[$sb]->getVotes();
			for($i=0;$i<count($this->area);$i++){
				$this->allConnectedSB[$this->area[$i]]['votes'] += $votesOfSB[$this->area[$i]];
			}
			$this->allConnectedSB['regional']['seats'] += $this->supervisoryBoards[$sb]->getRegionalSeats();
			$this->allConnectedSB['international']['seats'] += $this->supervisoryBoards[$sb]->getInternationalSeats();
		}
	}
	
	/**
	 * Sets data together for all supervisory boards of this ranking list.
	 * See also setAllConnectedSBstart()
	 *
	 * @param string $context The context
	 * @param int $value The value to the context
	 * @param string $area The area to which context and value belong
	 * @return void
	 */
	protected function setAllConnectedSB($context, $value, $area){
		$this->allConnectedSB[$area][$context] += $value;
	}
	
	/**
	 * add in the votes attribute of parties: corrected, difference
	 * add in $this->allConnectedSB: seatsToCorrect
	 *
	 * @return void
	 */
	protected function tooManyOrTooLessSeats(){
			
		for($i=0;$i<count($this->area);$i++){
			$sainteLague = \Mk\Vote\Service\MethodesOfSeatsDistribution::voteBySainteLague($this->parties, $this->allConnectedSB[$this->area[$i]]['votes'], $this->allConnectedSB[$this->area[$i]]['seats'], $this->area[$i], 'tooManyOrTooLessSeats');

			foreach($this->parties as $party){
					$partyId = $party->getPersistenceObjectIdentifier();
					if(isset($sainteLague[$partyId])){

						$seatsCorrected = $sainteLague[$partyId];
						$party->setSeats($seatsCorrected, $this->area[$i], 'corrected');

						$seats = $party->getSeats();
						$seatsDifference = $seatsCorrected - $seats[$this->area[$i]]['first'];

						$party->setSeats($seatsDifference, $this->area[$i], 'differenceCounter');
						if($seatsDifference > 0){
							$this->setAllConnectedSB('seatsToCorrect', $seatsDifference, $this->area[$i]);
						}
					}
			}
		}
		
	}
	
	/**
	 * Get the list of vote differences
	 *
	 * @return string The list of vote differences
	 */
	public function getListOfVoteDifferences() {
		return $this->listOfVoteDifferences;
	}

	/**
	 * Sets the list of vote differences
	 *
	 * @return void
	 */
	protected function setListOfVoteDifferences() {

		
		$listOfVoteDifferences = array();
		for($i=0;$i<count($this->area);$i++){
			$partiesWithTooFewSeats = array();
			$partiesWithTooMuchSeats = array();

			foreach($this->parties as $party){
				$seats = $party->getSeats();
				if($seats[$this->area[$i]]['differenceCounter'] > 0){
					$partiesWithTooFewSeats[] = $party->getPersistenceObjectIdentifier();
				} else if($seats[$this->area[$i]]['differenceCounter'] < 0){
					$partiesWithTooMuchSeats[] = $party->getPersistenceObjectIdentifier();
				}
			}
			unset($seats);

			$j = 0;

			foreach($this->supervisoryBoards as $sb){
				$lists = $sb->getListsOfCandidates();

				foreach($lists as $listKey => $list){
					$listParties = $list->getParties();
					$listVotes = $list->getVotes();
					$listSeats = $list->getSeats();
					foreach($listParties as $listParty){ //2013-12-01: At the moment there is only 1 party per list but later it will change.

						if(in_array($listParty->getPersistenceObjectIdentifier(), $partiesWithTooFewSeats)){

							$votesOfAListRaw = $list->getVotes();
							$votesToGetASeat = $votesOfAListRaw[$this->area[$i]];
							
							$seatsOfAListRaw = $list->getSeats();
							$seatsOfAList = $seatsOfAListRaw['regional']['first'] + $seatsOfAListRaw['international']['first'];

							if($seatsOfAList > 0){

								$votesToGetASeat = $votesOfAListRaw[$this->area[$i]] / ($seatsOfAListRaw[$this->area[$i]]['first'] + 1);
								//(2013-12-01) "+ 1": 
									// So that the division can not be by 0 
										// This is still possible when "$seatsOfAList > 0", because the code before "+ 1" only refers to 1 of 2 areas.
									// So that when there is already a seat, the division does not begin with "1", which would not change the number of votes to get a seat ($votesToGetASeat).
									// IS THIS PART OF C.1?
										// No! If a party has already a seat in a SB, it can not an additional seat there through correction of seat distribution.
										// But this code makes possible: If this list/party has already a seat in this SB, it can get an other one under harder conditions than if it had not.
										// Because it is not part of C.1: This should be OPTIONAL.
							}

							foreach($partiesWithTooMuchSeats as $mParty){
								
								foreach($lists as $listForTooMuch){
									$listPartiesForTooMuch = $listForTooMuch->getParties();
									$listSeatsForTooMuch = $listForTooMuch->getSeats();
									$listVotesForTooMuch = $listForTooMuch->getVotes();
									foreach($listPartiesForTooMuch as $listPartyForTooMuch){
										if($mParty == $listPartyForTooMuch->getPersistenceObjectIdentifier()){

											$usedVotesOfMParty = $listVotesForTooMuch[$this->area[$i]];

											if($listSeatsForTooMuch[$this->area[$i]]['first'] > 1){

												$usedVotesOfMParty = $usedVotesOfMParty / $listSeatsForTooMuch[$this->area[$i]]['first'];
											}

											$listOfVoteDifferences[$this->area[$i]][$j]['supervisoryBoard'] = $sb;
//											$listOfVoteDifferences[$this->area[$i]][$j]['partyWithTooFewSeats'] = $listParty;
//											$listOfVoteDifferences[$this->area[$i]][$j]['partyWithTooMuchSeats'] = $this->parties[$mParty]; 
											$listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['party'] = $listParty;
											$listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['listOfCandidates'] = $list;
											$listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['party'] = $this->parties[$mParty]; 
												// instead of $this->parties[$mParty]:  $listPartyForTooMuch could be used with the same result
											$listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['listOfCandidates'] = $listForTooMuch;
											$listOfVoteDifferences[$this->area[$i]][$j]['difference'] = ($usedVotesOfMParty - $votesToGetASeat) * 100 / $usedVotesOfMParty;

											$j++;
											break;
										}
									}
								}
							}

						}
					}

				}

			}

			usort($listOfVoteDifferences[$this->area[$i]], function($valueA, $valueB){
				$a = $valueA['difference'];
				$b = $valueB['difference'];
				if ($a == $b) {
					return 0;
				}
				return ($a > $b) ? +1 : -1;
			});
		}

		$this->listOfVoteDifferences = $listOfVoteDifferences;
		
	}
	
	/**
	 * Get the filtered list of vote differences
	 *
	 * @return string The filtered list of vote differences
	 */
	public function getFilteredListOfVoteDifferences() {
		return $this->filteredListOfVoteDifferences;
	}

	/**
	 * Sets the filtered list of vote differences
	 *
	 * @return void
	 */
	protected function setFilteredListOfVoteDifferences() {
		$filteredListOfVoteDifferences = array();
		$this->transferFirstSeatsToCorrectedSeats();
		
		for($i=0;$i<count($this->area);$i++){
			$seatsToCorrect[$this->area[$i]] = $this->allConnectedSB[$this->area[$i]]['seatsToCorrect'];

			for($j=0;$j<count($this->listOfVoteDifferences[$this->area[$i]]);$j++){

				if($seatsToCorrect[$this->area[$i]] == 0){
					$this->listOfVoteDifferences[$this->area[$i]] = array_slice($this->listOfVoteDifferences[$this->area[$i]], 0, $j);
					break;
				}

				$partyWithTooFewSeats = $this->listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['party'];
				$partyWithTooMuchSeats = $this->listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['party'];

				$seatsOfListWithTooMuchSeats = $this->listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['listOfCandidates']->getSeats();
				if($seatsOfListWithTooMuchSeats[$this->area[$i]]['corrected'] < 1){
					$this->listOfVoteDifferences[$this->area[$i]][$j]['filterStatus'] = 2;
						// If partyWithTooMuchSeats has NOT at least 1 seat in this SB for this area.
					continue;
				}
					
				$seatsOfPartyWithTooFewSeats = $partyWithTooFewSeats->getSeats();
				if($seatsOfPartyWithTooFewSeats[$this->area[$i]]['differenceCounter'] < 1){
					$this->listOfVoteDifferences[$this->area[$i]][$j]['filterStatus'] = 3;
						// If partyWithTooFewSeats has NOT too few seats now; it already got additional seats.
					continue;
				}

				$seatsOfPartyWithTooMuchSeats = $partyWithTooMuchSeats->getSeats();
				if($seatsOfPartyWithTooMuchSeats[$this->area[$i]]['differenceCounter'] > -1){
					$this->listOfVoteDifferences[$this->area[$i]][$j]['filterStatus'] = 4;
						// If partyWithTooMuchSeats has NOT more seats than it should have any more; it has already given the seats that where too much.
					continue;
				}

				$seatsOfListWithTooFewSeats = $this->listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['listOfCandidates']->getSeats();
				if($this->area[$i] == 'international'){
					$seatsOfListWithTooFewSeatsFirst = $seatsOfListWithTooFewSeats['regional']['first'] + $seatsOfListWithTooFewSeats['international']['first'];
					$seatsOfListWithTooFewSeatsCorrected = $seatsOfListWithTooFewSeats['regional']['corrected'] + $seatsOfListWithTooFewSeats['international']['corrected'];
				} else {
					$seatsOfListWithTooFewSeatsFirst = $seatsOfListWithTooFewSeats[$this->area[$i]]['first'];
					$seatsOfListWithTooFewSeatsCorrected = $seatsOfListWithTooFewSeats[$this->area[$i]]['corrected'];
				}
				if($seatsOfListWithTooFewSeatsCorrected > $seatsOfListWithTooFewSeatsFirst){
					$this->listOfVoteDifferences[$this->area[$i]][$j]['filterStatus'] = 5;
						// The party with too FEW seats already got a seat in this supervisory board through the vote-difference-procedure.
					continue;
				} 

				$this->listOfVoteDifferences[$this->area[$i]][$j]['filterStatus'] = 1;
				$filteredListOfVoteDifferences[$this->area[$i]][] = $this->listOfVoteDifferences[$this->area[$i]][$j];

				$seatsToCorrect[$this->area[$i]] -= 1;
				$this->listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['listOfCandidates']->setSeats(-1, $this->area[$i], 'corrected');
				$this->listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['listOfCandidates']->setSeats(1, $this->area[$i], 'corrected');
				$this->listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['party']->setSeats(1, $this->area[$i], 'differenceCounter');
				$this->listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['party']->setSeats(-1, $this->area[$i], 'differenceCounter');

			}

		}
		$this->filteredListOfVoteDifferences = $filteredListOfVoteDifferences;

	}
	
	/**
	 * Transfers first seats to corrected seats in all lists of a supervisory board
	 *
	 * @return void
	 */
	protected function transferFirstSeatsToCorrectedSeats(){
		
		foreach($this->supervisoryBoards as $sb){
			$lists = $sb->getListsOfCandidates();
			foreach($lists as $list){
				$seats = $list->getSeats();
				for($i=0;$i<count($this->area);$i++){

					$list->setSeats($seats[$this->area[$i]]['first'], $this->area[$i], 'corrected');
				}
			}
		}
		
	}
	
	/**
	 * Add vote differences to the supervisory boards of a rankinglist.
	 *
	 * @return void
	 */
	protected function addVoteDifferencesToSBs(){
		
		foreach($this->supervisoryBoards as $sb){
			for($i=0;$i<count($this->area);$i++){
				foreach($this->filteredListOfVoteDifferences[$this->area[$i]] as $voteDifference){
					if($sb == $voteDifference['supervisoryBoard']){
						$sb->setVoteDifference($voteDifference, $this->area[$i]);
					}
				}
			}
		}
	}
	
	/**
	 * Get the list of the parties connected with this ranking list
	 *
	 * @return array The list of the parties connected with this ranking list
	 */
	public function getParties() {
		return $this->parties;
	}
	
	/**
	 * Sets the parties of this ranking list
	 *
	 * @return void
	 */
	protected function setParties($supervisoryBoard) {
		if(empty($this->parties)){
			$this->parties = array_merge($this->parties, $supervisoryBoard->getParties());
		}
	}

	/**
	 * Set additional party.
	 * Is useful while creating a new transient ranking list from the data of a persisted rankinglist.
	 *
	 * @param object
	 * @return void 
	 */
	public function setParty($party) {
		$this->parties[$party->getPersistenceObjectIdentifier()] = $party;
	}
	
	/**
	 * Set new transient start data for the rankinglist from the data of a persisted rankinglist
	 *
	 * @return void
	 */
	protected function setStartData(){
		if(isset($this->arguments['startData'])){
			if($this->arguments['startData'] != 0){
				$adjustData = new \Mk\Vote\Service\adjustData;
				$changeData = $adjustData->chooseStartArray(1, $this->arguments['startData']);
				$this->createNewStartRankingListFromOld($changeData);
			}
		}
	}
	
	/**
	 * Create new transient ranking list from the data of a persisted rankinglist
	 *
	 * @return void
	 */
	protected function createNewStartRankingListFromOld($changeData){
		
		$this->setVotesOfRankingListAndParties();
		foreach($this->supervisoryBoards as $sb){
			foreach($sb->getListsOfCandidates() as $list){
				$sb->setParties($list);
			}
			$this->setParties($sb);
		}
		$this->originalPartyPercentageData();
		$this->decideIfListsOfCandidatesNeedsToBeCloned($changeData);
		$changeData = $this->addPercentagesForOldLists($changeData);
		
		foreach($this->supervisoryBoards as $sb){
							
			foreach($sb->getListsOfCandidates() as $list){
				
				for($i=0;$i<count($changeData);$i++){
					
					if($list->getName() == $changeData[$i][0]){
						
						$partiesOfList = $list->getParties();
						$votesOfParty = $partiesOfList[0]->getVotes();
						for($j=0;$j<count($this->area);$j++){
//							if($changeData[$i][2 + $j] != $originalListPercentage[$this->area[$j]][$changeData[$i][1]]){  
								//an "if" similar to this at the moment makes not much sense because of 2 digits behind the point for the original percentage

							foreach($list->getCandidatesInList() as $candidate){

								if($this->area[$j] == 'regional'){
									$oldVotesOfCandidate = $candidate->getVotesRegional();
									$partyPercentage = $changeData[$i][5];
								} else {
									$oldVotesOfCandidate = $candidate->getVotesInternational();
									$partyPercentage = $changeData[$i][4];
								}

								if($partyPercentage > 0){

									$votesOfCandidateForArea = round($oldVotesOfCandidate / $partyPercentage * $changeData[$i][2 + $j]);
								}
								if($this->area[$j] == 'regional'){
									$candidate->setVotesRegional($votesOfCandidateForArea);
									// About regional area ($this->area[0]) see also remarks in method originalListPercentageData($startArray).
								} else {
									$candidate->setVotesInternational($votesOfCandidateForArea);
								}
							}
//							}
						}
						break;
					}
				}
			}

		}
	}
	
	/**
	 * Decide if lists of candidates needs to be cloned.
	 *
	 * @param array $changeData
	 * @return void
	 */
	protected function decideIfListsOfCandidatesNeedsToBeCloned($changeData){
		
		for($i=0;$i<count($changeData);$i++){
			if($changeData[$i][0] != $changeData[$i][1]){
				$this->setClonedListsOfCandidatesForSBs($changeData); // This option can later not be used in cases, 
																	  // where in one listOfCandidates there are candidates from different parties
				$this->setVotesAfterChangedData();
				return 1;
			}
		}
	}
	
	/**
	 * Set cloned listes of candidates for supervisory boards.
	 *
	 * @return void
	 */
	protected function setClonedListsOfCandidatesForSBs($changeData){
		
		$namesOfParties = $this->getNamesOfParties();
		$hereAddedParties = array();
		foreach($this->supervisoryBoards as $sb){

			$lists = array();
			foreach($sb->getListsOfCandidates() as $list){
				$lists[$list->getName()] = $list;
			}
			$sb->removeAllListsOfCandidates();
			for($i=0;$i<count($changeData);$i++){
				$newList = clone $lists[$changeData[$i][1]];
				$sb->setListOfCandidates($newList);
				$newList->setName($changeData[$i][0]);
				$newList->removeAllParties();
				if(in_array($changeData[$i][0], $namesOfParties)){
					$oldParties = $lists[$changeData[$i][0]]->getParties();
					$newList->setParty($oldParties[0]);
				} else if(array_key_exists($changeData[$i][0], $hereAddedParties)){
					$newList->setParty($hereAddedParties[$changeData[$i][0]]);
				} else {
					$oldParties = $lists[$changeData[$i][1]]->getParties();
					$newParty = clone $oldParties[0];
					$newParty->setName($changeData[$i][0]);
					$newList->setParty($newParty);
					$this->setParty($newParty);
					$hereAddedParties[$changeData[$i][0]] = $newParty;
				}
				$oldCandidates = $newList->getCandidatesInList();
				$newList->removeAllCandidates();
				foreach($oldCandidates as $oldCandidate){
					$newList->setCandidateInList(clone $oldCandidate);
				}
			}
		}
	}
	
	/**
	 * Get names of parties
	 *
	 * @return $names
	 */
	protected function getNamesOfParties(){
		$names = array();
		foreach($this->parties as $party){
			$names[] = $party->getName();
		}
		return $names;
	}
	
	protected function originalPartyPercentageData(){
		
		foreach($this->parties as $party){
			$percentages = array();
			$votesOfParty = $party->getVotes();
			for($i=0;$i<count($this->area);$i++){
				$percentages[$this->area[$i]] = round($votesOfParty['original'][$this->area[$i]]['sum'] / $this->votes[$this->area[$i]] * 100, 2);
			}
			$party->setOriginalVotesForPercentages($percentages);
		}

		
		// For the regional area ($this->area[0]) these %-values have only limited meaning. If these %ages would be for lists/parties of a single supervisory board, the meaning would be bigger; but
		// here there is a ranking list with several supervisory boards, and each company can have its headquarters in a different country. So here the %ages for the ranking list
		// can only be used for a rough overview obout what is happening when a party has, in comparison to its international votes, expecially many or few votes.
		// (More useful is the ability to view and change the [%al] regional votes for a single supervisory board.)

	}
		
	/**
	 * Set $this->votesAfterChangedData
	 *
	 * @return void
	 */
	protected function setVotesAfterChangedData(){
		$votesAfterChangedData = array('regional' => 0, 'international' => 0);
		foreach($this->parties as $party){
			$votesOfParty = $party->getVotes();
			for($i=0;$i<count($this->area);$i++){
				$votesAfterChangedData[$this->area[$i]] += $votesOfParty['original'][$this->area[$i]]['sum'];
			}
		}
		$this->votesAfterChangedData = $votesAfterChangedData;
	}
	
	/**
	 * Add percentages for old lists
	 * In the 5th + 6th place of an array come percentages that refer to the 2nd place of an array.
	 *
	 * @return void
	 */
	protected function addPercentagesForOldLists($changeData){
		foreach($this->parties as $party){
			$partyVotes = $party->getVotes();
			for($i=0;$i<count($changeData);$i++){
				if($changeData[$i][1] == $party->getName()){
					$changeData[$i][4] = $partyVotes['original']['international']['percentage'];
					$changeData[$i][5] = $partyVotes['original']['regional']['percentage'];
				}
			}
		}
		return $changeData;
	}
	
	/**
	 * Sets votes per party
	 * Gets all votes of a ranking list.
	 *
	 * @return void
	 */
	protected function setVotesOfRankingListAndParties(){
		$allVotes = array('regional' => 0, 'international' => 0);

		foreach($this->supervisoryBoards as $sb){
			foreach($sb->getListsOfCandidates() as $list){
				$parties = $list->getParties();
			
				foreach($list->getCandidatesInList() as $candidate){

					$allVotes['regional'] += $candidate->getVotesRegional();
					$allVotes['international'] += $candidate->getVotesInternational();
					$parties[0]->setOriginalVotesForSum($candidate->getVotesRegional(), 'regional');
					$parties[0]->setOriginalVotesForSum($candidate->getVotesInternational(), 'international');
						// "$parties[0]": At the moment there can only be one list in a party.

				}
			}
		}
		$this->votes = $allVotes;
	}
	
	/**
	 * Sets array of basic data.
	 * This is the base from which a JSON file will be created.
	 *
	 * @return void
	 */
	public function setArrayOfBasicData(){
		
		$basicData = array();
		$basicData['formatVersion'] = '1.0';
		$basicData['name'] = $this->getName();
		$basicData['description'] = $this->getDescription();
		$basicData['supervisoryBoards'] = array();
		$i=0;
		foreach($this->supervisoryBoards as $sb){
			$basicData['supervisoryBoards'][$i]['name'] = $sb->getName();
			$basicData['supervisoryBoards'][$i]['seats'] = $sb->getSeats();
			$basicData['supervisoryBoards'][$i]['listsOfCandidates'] = array();
			$j=0;
			foreach($sb->getListsOfCandidates() as $list){
				$basicData['supervisoryBoards'][$i]['listsOfCandidates'][$j]['name'] = $list->getName();
				$k=0;
				foreach($list->getParties() as $party){ //At the moment: when later using this data, it must be changed from array to comma-separated string
					$basicData['supervisoryBoards'][$i]['listsOfCandidates'][$j]['parties'][$k]['name'] = $party->getName();
					$k++;
				}
				$k=0;
				foreach($list->getCandidatesInList() as $candidate){
					$basicData['supervisoryBoards'][$i]['listsOfCandidates'][$j]['candidate'][$k]['votes']['regional'] = $candidate->getVotesRegional();
					$basicData['supervisoryBoards'][$i]['listsOfCandidates'][$j]['candidate'][$k]['votes']['international'] = $candidate->getVotesInternational();
					$k++;
				}
				$j++;
			}
			$i++;
		}
		$this->basicData = $basicData;
	}
	
	/**
	* Get array of basic data.
	*
	* @return array basic data for ranking list
	*/
	public function getBasicData() {
		return $this->basicData;
	}
	
	/**
	* Get arguments
	*
	* @return array Arguments
	*/
	public function getArguments() {
		return $this->arguments;
	}
	
	/**
	* Set arguments
	*
	* @return void
	*/
	public function setArguments($arguments) {
		$this->arguments = $arguments;
	}
	
}
?>