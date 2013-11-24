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
	protected $votesPerPartyForAllConnectedSB;
	
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
	 * Get the votes per party for all connected supervisory boards
	 *
	 * @return array The votes per party for all connected supervisory boards
	 */
	public function getVotesPerPartyForAllConnectedSB() {
		return $this->votesPerPartyForAllConnectedSB;
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
		
//	$startData = $this->addBasicsToStartData();
	$this->addBasicsToStartData();
			//print_r('<pre>' . $startArray . '</pre>');
			//print_r($startArray);
			//$votesPerPartyForAllConnectedSB = $main->votesPerPartyForAllConnectedSB($startArray);
			//print_r('<br>$votesPerPartyForAllConnectedSB: ');
			//print_r($votesPerPartyForAllConnectedSB);
//	$sbList = $this->beforeListCompare($startData);
	$this->beforeListCompare();
$x=1;
//			//print_r('<br>$main->votesPerPartyForAllConnectedSB: ');
//			//print_r($main->votesPerPartyForAllConnectedSB);
//print_r('<br>$sbList: ');
//print_r($sbList);
//	$this->beforeListCompare2($sbList);
//			//print_r($main->votesPerPartyForAllConnectedSB);
//			//print_r('<br>$main->allConnectedSB: ');
//			//print_r($main->allConnectedSB);
//	$this->tooManyOrTooLessSeats();
//print_r('<br>$this->allConnectedSB: ');
//print_r($this->allConnectedSB);
//print_r('<br>after tooManyOrTooLessSeats(), $this->votesPerPartyForAllConnectedSB: ');
//print_r($this->votesPerPartyForAllConnectedSB);
//	$listOfVoteDifferences = $this->setListOfVoteDifferences($sbList);
//			//print_r('<br>$listOfVoteDifferences: ');			
//			//print_r($listOfVoteDifferences);
//	$filteredVoteDifferences = $this->setFilteredListOfVoteDifferences($listOfVoteDifferences, $sbList);
//print_r('<br>$filteredVoteDifferences: ');			
//print_r($filteredVoteDifferences);
//print_r('<br>$this->listOfVotesFilteredInBothAreas: ');			
//print_r($this->listOfVotesFilteredInBothAreas);
			//$changeSeats = $main->correctionOfSeatDistribution($filteredVoteDifferences, $sbList);
			//print_r('<br>$correctionOfSeatDistribution: ');			
			//print_r($correctionOfSeatDistribution);
		
	}
	
	/**
	 * adds votes per list
	 *
	 * @return void
	 */
	protected function addBasicsToStartData(){
		
		foreach($this->supervisoryBoards as $sb => $value){

			$listsOfCandidates = $this->supervisoryBoards[$sb]->getListsOfCandidates();
			foreach($listsOfCandidates as $list => $lvalue){
				$listsOfCandidates[$list]->setVotes();

			}
		}
		
	}
	
	/**
	 * adds seats for a list in a SB (before correction)
	 * counts all votes of a single party/list for all connected SB (stored in $this->votesPerPartyForAllConnectedSB)
	 * counts the votes and seats for all connected SBs together ($this->allConnectedSB)
	 *
	 * @return void
	 */
	protected function beforeListCompare(){
		
		$allVotesOfParty = array();

		foreach($this->supervisoryBoards as $sb => $value){
			$votesPerSBInternational = 0;
			$votesPerSBRegional = 0;
			$listsOfCandidates = $this->supervisoryBoards[$sb]->getListsOfCandidates();
			foreach($listsOfCandidates as $list => $lvalue){
				$votesOfAListOfCandidates = $lvalue->getVotes();
				$nameOfAListOfCandidates = $lvalue->getName();
				for($i=0;$i<count($this->area);$i++){
					if(isset($allVotesOfParty[$this->area[$i]][$list])){
						$allVotesOfParty[$this->area[$i]][$nameOfAListOfCandidates]['votes'] += $votesOfAListOfCandidates[$this->area[$i]];
					} else {
						$allVotesOfParty[$this->area[$i]][$nameOfAListOfCandidates]['votes'] = $votesOfAListOfCandidates[$this->area[$i]];
					}
//					if(isset($allVotesOfParty[$this->area[$i]][$list])){
//						$allVotesOfParty[$this->area[$i]][$list]['votes'] += $votesOfAListOfCandidates[$this->area[$i]];
//					} else {
//						$allVotesOfParty[$this->area[$i]][$list]['votes'] = $votesOfAListOfCandidates[$this->area[$i]];
//					}
				}

				$votesPerSBInternational += $votesOfAListOfCandidates['international'];
				$votesPerSBRegional += $votesOfAListOfCandidates['regional'];
				
			}

			$this->supervisoryBoards[$sb]->setVotesPerSB($votesPerSBInternational);
			
			$this->allConnectedSB['international']['votes'] += $votesPerSBInternational;
			$this->allConnectedSB['regional']['votes'] += $votesPerSBRegional;

			$seatsOfSB = $value->getSeats();
			$regionalSeats = floor($seatsOfSB / 2);
			$internationalSeats = ceil($seatsOfSB / 2);
			$this->allConnectedSB['regional']['seats'] += $regionalSeats;
			$this->allConnectedSB['international']['seats'] += $internationalSeats;
			
			for($i=0;$i<count($this->area);$i++){
				if($this->area[$i] == 'regional'){
					$votesPerSB = $votesPerSBRegional;
					$areaSeats = $regionalSeats;
				} else {
					$votesPerSB = $votesPerSBInternational;
					$areaSeats = $internationalSeats;
				}
//print_r('<br>in beforeListCompare(), $areaSeats: ');
//print_r($areaSeats);
				$sainteLague = \Mk\Vote\Service\MethodesOfSeatsDistribution::voteBySainteLague($listsOfCandidates, $votesPerSB, $areaSeats, $this->area[$i], '');
//print_r('<br>$sainteLague:');	
//print_r($sainteLague);
				foreach($sainteLague as $list => $seats){
					foreach($listsOfCandidates as $list2 => $value2){
						if($list == $list2){
							$listsOfCandidates[$list2]->setSeats($seats, $this->area[$i], 'first');
							break;
						}
					}
				}
			}
		}
		
		$this->votesPerPartyForAllConnectedSB = $allVotesOfParty;
	}
	
	/**
	 * counts the seats of a party for all connected SBs together (before correction)
	 *
	 * @param array $sbList The Ranking list
	 * @return void
	 */
	protected function beforeListCompare2($sbList){
		
	}
	
	/**
	 * add in $this->votesPerPartyForAllConnectedSB: seatsCorrected, seatsDifference, seatsDifference
	 *
	 * @return void
	 */
	protected function tooManyOrTooLessSeats(){
		
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
	 * @param string $xxxx The Ranking list's name
	 * @return void
	 */
	protected function setListOfVoteDifferences($xxxx) {
//		$this->name = $name;
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
	 * @param string $xxxx The Ranking list's name
	 * @return void
	 */
	protected function setFilteredListOfVoteDifferences($xxxx) {
//		$this->name = $name;
	}
	
	/**
	 * Transfers first seats to corrected seats in all lists of a supervisory board
	 *
	 * @param array $sbList The Ranking list
	 * @return void
	 */
	protected function transferFirstSeatsToCorrectedSeats($rankingList){
		
	}
}
	
/**
 * Get sorted list of vote differences
 *
 * @return array Sorted list of vote differences
 */
function compareForListOfVoteDifferences($valueA, $valueB){

	$a = $valueA['difference'];
	$b = $valueB['difference'];

	if ($a == $b) {
		return 0;
	}

	return ($a > $b) ? +1 : -1;
}

?>