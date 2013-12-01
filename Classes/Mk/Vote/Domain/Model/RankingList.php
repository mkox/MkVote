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
		
//	$startData = $this->addBasicsToStartData();
//	$this->addBasicsToStartData();
			//print_r('<pre>' . $startArray . '</pre>');
			//print_r($startArray);
			//$votesPerPartyForAllConnectedSB = $main->votesPerPartyForAllConnectedSB($startArray);
			//print_r('<br>$votesPerPartyForAllConnectedSB: ');
			//print_r($votesPerPartyForAllConnectedSB);
//	$sbList = $this->beforeListCompare($startData);
	$this->beforeListCompare();
//$myObjectInstance = $this->objectManager->get('Mk\Vote\Domain\Model\Party');

//print_r('<br><br>$this->parties in calculateSeatsDistribution():');
//\Doctrine\Common\Util\Debug::dump($this->parties);
//$theParties = $this->parties->findAll();
//print_r('<br><br>$this->parties->findAll() in calculateSeatsDistribution():');
//\Doctrine\Common\Util\Debug::dump($this->parties->findAll());
//print_r('<br><br>');
	$this->tooManyOrTooLessSeats();
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
	 * Do some calculations before comparing lists of supervisory bords.
	 *
	 * @return void
	 */
	protected function beforeListCompare(){

		foreach($this->supervisoryBoards as $sb){
			
//			$this->supervisoryBoards[$sb]->basicCalculations();
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
		$this->allConnectedSB[$area][$context] = $value;
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
				$party->setSeats($seatsDifference, $this->area[$i], 'difference');
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