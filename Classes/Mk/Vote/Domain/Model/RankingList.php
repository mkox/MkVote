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
	
//	/**
//	 * @var \Mk\Vote\Domain\Repository\PartyRepository
//	 * @Flow\Transient
//	 */
//	protected $parties;
	
//	/**
//	 * @Flow\Inject
//	 * @var \Mk\Vote\Domain\Repository\PartyRepository
//	 */
//	protected $parties;
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $parties = array();
	
	/**
	 * Constructs this ranking list
	 */
	public function __construct() {
		$this->supervisoryBoards = new \Doctrine\Common\Collections\ArrayCollection();
//		$this->parties = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
//	public function injectParties(\MyCompany\MyPackage\PartyInterface $parties) {
//			$this->parties = $parties;
//	}

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
	 * @param string $xxxx The Ranking list's name
	 * @return void
	 */
	public function calculateSeatsDistribution(){
		
	$this->beforeListCompare();
	$this->tooManyOrTooLessSeats();
	$this->setListOfVoteDifferences();
	$this->setFilteredListOfVoteDifferences();
	$this->addVoteDifferencesToSBs();
$x=1;
	}
	
	/**
	 * Do some calculations before comparing lists of supervisory bords.
	 *
	 * @return void
	 */
	protected function beforeListCompare(){
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
		
//print_r('<br>in tooManyOrTooLessSeats, before $sainteLague: ');	
		for($i=0;$i<count($this->area);$i++){
			$sainteLague = \Mk\Vote\Service\MethodesOfSeatsDistribution::voteBySainteLague($this->parties, $this->allConnectedSB[$this->area[$i]]['votes'], $this->allConnectedSB[$this->area[$i]]['seats'], $this->area[$i], 'tooManyOrTooLessSeats');
//print_r('<br><br>in tooManyOrTooLessSeats, $sainteLague: ');
//print_r($sainteLague);

			foreach($this->parties as $party){

				$seatsCorrected = $sainteLague[$party->getPersistenceObjectIdentifier()];
				$party->setSeats($seatsCorrected, $this->area[$i], 'corrected');

				$seats = $party->getSeats();
				$seatsDifference = $seatsCorrected - $seats[$this->area[$i]]['first'];
//print_r('<br>$seatsDifference: ');
//print_r($seatsDifference);
				$party->setSeats($seatsDifference, $this->area[$i], 'differenceCounter');
				if($seatsDifference > 0){
					$this->setAllConnectedSB('seatsToCorrect', $seatsDifference, $this->area[$i]);
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
//			foreach($sbList['supervisoryBoards'] as $sb => $value){
			foreach($this->supervisoryBoards as $sb){
				$lists = $sb->getListsOfCandidates();
//				foreach($sb['votesPerList'] as $list => $lvalue){
				foreach($lists as $listKey => $list){
					$listParties = $list->getParties();
					$listVotes = $list->getVotes();
					$listSeats = $list->getSeats();
					foreach($listParties as $listParty){ //2013-12-01: At the moment there is only 1 party per list but later it will change.

						if(in_array($listParty->getPersistenceObjectIdentifier(), $partiesWithTooFewSeats)){

//							$votesToGetASeat = $sb['votesPerList'][$listKey]['votes'][$this->area[$i]];
							$votesOfAListRaw = $list->getVotes();
							$votesToGetASeat = $votesOfAListRaw[$this->area[$i]];
							
//							$seatsOfAList = $sb['votesPerList'][$listKey]['seats']['regional']['first'] + $sb['votesPerList'][$listKey]['seats']['international']['first'];
							$seatsOfAListRaw = $list->getSeats();
							$seatsOfAList = $seatsOfAListRaw['regional']['first'] + $seatsOfAListRaw['international']['first'];

							//if($sbe['votesPerList'][$listKey]['seats'] > 0){  //!!!
							if($seatsOfAList > 0){

//								$votesToGetASeat = $sb['votesPerList'][$listKey]['votes'][$this->area[$i]] / ($sb['votesPerList'][$listKey]['seats'][$this->area[$i]]['first'] + 1);
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
								//if($sb['votesPerList'][$listKey]['seats'] < 1){  //really make this? The big party C in startArray1() does not the seat more it deserves
																					//because it has already a seat in every SB.
								//if($mParty == $listParty->getPersistenceObjectIdentifier()){  //KANN ICH SO WOHL NICHT MACHEN!
								foreach($lists as $listForTooMuch){
									$listPartiesForTooMuch = $listForTooMuch->getParties();
									$listSeatsForTooMuch = $listForTooMuch->getSeats();
									$listVotesForTooMuch = $listForTooMuch->getVotes();
									foreach($listPartiesForTooMuch as $listPartyForTooMuch){
										if($mParty == $listPartyForTooMuch->getPersistenceObjectIdentifier()){
		//									$usedVotesOfMParty = $sb['votesPerList'][$mParty]['votes'][$this->area[$i]];
//											$usedVotesOfMParty = $listVotes[$this->area[$i]];
											
//											$usedVotesOfMPartyRaw = $listPartyForTooMuch->getVotes();
//											$usedVotesOfMParty = $usedVotesOfMPartyRaw[$this->area[$i]];
											$usedVotesOfMParty = $listVotesForTooMuch[$this->area[$i]];


		//									if($sb['votesPerList'][$mParty]['seats'][$this->area[$i]]['first'] > 1){
											if($listSeats[$this->area[$i]]['first'] > 1){

												$usedVotesOfMParty = $usedVotesOfMParty / $listSeatsForTooMuch[$this->area[$i]]['first'];
											}

											$listOfVoteDifferences[$this->area[$i]][$j]['sbid'] = $sb->getPersistenceObjectIdentifier();
											$listOfVoteDifferences[$this->area[$i]][$j]['supervisoryBoard'] = $sb;
//											$listOfVoteDifferences[$this->area[$i]][$j]['partyWithTooFewSeats'] = $listParty;
//											$listOfVoteDifferences[$this->area[$i]][$j]['partyWithTooMuchSeats'] = $this->parties[$mParty]; 
											$listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['party'] = $listParty;
											$listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['listOfCandidates'] = $list;
											$listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['party'] = $this->parties[$mParty]; 
												// instead of $this->parties[$mParty]:  $listPartyForTooMuch could be used with the same result
											$listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['listOfCandidates'] = $listForTooMuch;
											$listOfVoteDifferences[$this->area[$i]][$j]['difference'] = ($usedVotesOfMParty - $votesToGetASeat) * 100 / $usedVotesOfMParty;


		//     - Stimmen im betreffenden SB jeweis für beide Parteien
		//     - vorläufige Sitze in diesem SB der partyWithTooMuchSeats
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
//print_r('<br>$listOfVoteDifferences: ');
//print_r($listOfVoteDifferences);
//			usort($listOfVoteDifferences[$this->area[$i]], 'compareForListOfVoteDifferences');
			usort($listOfVoteDifferences[$this->area[$i]], function($valueA, $valueB){
				$a = $valueA['difference'];
				$b = $valueB['difference'];
				if ($a == $b) {
					return 0;
				}
				return ($a > $b) ? +1 : -1;
			});
		}
//print_r('<br>$listOfVoteDifferences 2: ');
//print_r($listOfVoteDifferences);
		$this->listOfVoteDifferences = $listOfVoteDifferences;
		
	}
	
		/**
	 * Get the filtered list of vote differences
	 *
	 * @return string The filtered list of vote differences
	 */
	public function getFilteredListOfVoteDifferences() {
		return $this->listOfVoteDifferences;
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
//			if($this->area[$i] == 'international'){
//				$seatsToCorrect[$this->area[$i]] += $this->allConnectedSB['regional']['seatsToCorrect']; // needed for later changes, when same item remains in both areas.
//			}

			for($j=0;$j<count($this->listOfVoteDifferences[$this->area[$i]]);$j++){

				if($seatsToCorrect[$this->area[$i]] > 0){

					$partyWithTooFewSeats = $this->listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['party'];
					$partyWithTooMuchSeats = $this->listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['party'];
					$sbid = $this->listOfVoteDifferences[$this->area[$i]][$j]['sbid'];
					
					$seatsOfListWithTooMuchSeats = $this->listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['listOfCandidates']->getSeats();
					if($seatsOfListWithTooMuchSeats[$this->area[$i]]['corrected'] > 0){
						$seatsOfPartyWithTooFewSeats = $partyWithTooFewSeats->getSeats();
						if($seatsOfPartyWithTooFewSeats[$this->area[$i]]['differenceCounter'] > 0){
							$seatsOfPartyWithTooMuchSeats = $partyWithTooMuchSeats->getSeats();
							if($seatsOfPartyWithTooMuchSeats[$this->area[$i]]['differenceCounter'] < 0){
							
								$internationalIsInRegional = 0;
								if($this->area[$i] == 'international'){

									for($k=0;$k<count($filteredListOfVoteDifferences['regional']);$k++){
										$regionalFilteredItem = $filteredListOfVoteDifferences['regional'][$k];

										if(($regionalFilteredItem['sbid'] == $sbid)
											&& ($regionalFilteredItem['tooFewSeats']['party'] == $partyWithTooFewSeats)
											&& ($regionalFilteredItem['tooMuchSeats']['party'] == $partyWithTooMuchSeats)
											){
											$this->listOfVotesFilteredInBothAreas[] = $this->listOfVoteDifferences[$this->area[$i]][$j];
											$internationalIsInRegional = 1;
											break;
										} else {
											continue;
										}

									}
									
								}
							
								if($internationalIsInRegional == 0){
									
									$this->listOfVoteDifferences[$this->area[$i]][$j]['filterStatus'] = 1;
									$filteredListOfVoteDifferences[$this->area[$i]][] = $this->listOfVoteDifferences[$this->area[$i]][$j];

									$seatsToCorrect[$this->area[$i]] -= 1;
									$this->listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['listOfCandidates']->setSeats(-1, $this->area[$i], 'corrected');
									$this->listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['listOfCandidates']->setSeats(1, $this->area[$i], 'corrected');
									$this->listOfVoteDifferences[$this->area[$i]][$j]['tooMuchSeats']['party']->setSeats(1, $this->area[$i], 'differenceCounter');
									$this->listOfVoteDifferences[$this->area[$i]][$j]['tooFewSeats']['party']->setSeats(-1, $this->area[$i], 'differenceCounter');
								}
							} else {
								// If partyWithTooMuchSeats has NOT more seats than it should have any more; it has already given the seats that where too much.
								$this->listOfVoteDifferences[$this->area[$i]][$j]['filterStatus'] = 4;
							}
						} else {							
							// If partyWithTooFewSeats has NOT too few seats now; it already got additional seats.
							$this->listOfVoteDifferences[$this->area[$i]][$j]['filterStatus'] = 3;
						}
					} else {
						// If partyWithTooMuchSeats has NOT at least 1 seat in this SB for this area
						$this->listOfVoteDifferences[$this->area[$i]][$j]['filterStatus'] = 2;
					}

				} else {
					$this->listOfVoteDifferences[$this->area[$i]] = array_slice($this->listOfVoteDifferences[$this->area[$i]], 0, $j);
					break;
				}

			}

		}
		$this->filteredListOfVoteDifferences = $filteredListOfVoteDifferences;

	}
	
	/**
	 * Transfers first seats to corrected seats in all lists of a supervisory board
	 *
	 * @param array $sbList The Ranking list
	 * @return void
	 */
	protected function transferFirstSeatsToCorrectedSeats(){
		
		foreach($this->supervisoryBoards as $sb){
			$lists = $sb->getListsOfCandidates();
			foreach($lists as $list){
				$seats = $list->getSeats();
				for($i=0;$i<count($this->area);$i++){
//					[$this->area[$i]]['corrected'] = $rankingList['supervisoryBoards'][$sb]['votesPerList'][$list]['seats'][$this->area[$i]]['first'];
					$list->setSeats($seats[$this->area[$i]]['first'], $this->area[$i], 'corrected');
				}
			}
		}
//		return $rankingList;
		
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
//		return $rankingList;
		
	}
	
//	/**
//	 * Get the list of the parties connected with this ranking list
//	 *
//	 * @return array The list of cloned parties connected with this ranking list
//	 */
//	public function cloneParties() {
//		$clonedParties = array();
//		foreach($this->parties as $partyKey => $party){
//			$clonedParties[$partyKey] = $party;
//		}
//		return $clonedParties;
//	}
	
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
		$sbParties = $supervisoryBoard->getParties();
		$this->parties = array_merge($this->parties, $supervisoryBoard->getParties());
//		for($i=0; $i<$sbParties; $i++){
//			$this->parties[] = $sbParties[$i];
//		}
//		array_unique($this->parties);
	}
	
//	/**
//	 * Set Persistence_Object_Identifier of each SupervisoryBoard as array key.
//	 *
//	 */
//	public function setIdAsKeyForSupervisoryBoards() {
//		$supervisoryBoards = array();
//		for($i=0;$i<count($this->supervisoryBoards);$i++){
//			$supervisoryBoards[$this->supervisoryBoards[$i]->getPersistenceObjectIdentifier()] = $this->supervisoryBoards[$i];
//		}
//		$this->supervisoryBoards = $supervisoryBoards;
//	}
	
}

?>