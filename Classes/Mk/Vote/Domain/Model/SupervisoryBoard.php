<?php
namespace Mk\Vote\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "Mk.Vote".                    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Supervisory board
 *
 * @Flow\Entity
 */
class SupervisoryBoard {

	/**
	 * The ranking list
	 * @var \Mk\Vote\Domain\Model\RankingList
	 * @ORM\ManyToOne(inversedBy="supervisoryBoards")
	 */
	protected $rankingList;

	/**
	 * The list of candidates
	 * @var \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\ListOfCandidates>
	 * @ORM\OneToMany(mappedBy="supervisoryBoard")
	 * @ORM\OrderBy({"name" = "ASC"})
	 */
	protected $listsOfCandidates;

	/**
	 * The name
	 * @var string
	 */
	protected $name;
	
	/**
	 * The seats
	 * @var string
	 */
	protected $seats;

	/**
	 * The regional code
	 * @var integer
	 */
	protected $regionalCode;
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $area = array('regional', 'international');
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $votes = array('regional' => 0, 'international' => 0);
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $parties = array();
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $voteDifferences = array();
	
	/**
	 * Constructs this supervisory board
	 */
	public function __construct() {
		$this->listsOfCandidates = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the Supervisory board's ranking list
	 *
	 * @return \Mk\Vote\Domain\Model\RankingList The Supervisory board's ranking list
	 */
	public function getRankingList() {
		return $this->rankingList;
	}

	/**
	 * Sets this Supervisory board's ranking list
	 *
	 * @param \Mk\Vote\Domain\Model\RankingList $rankingList The Supervisory board's ranking list
	 * @return void
	 */
	public function setRankingList(\Mk\Vote\Domain\Model\RankingList $rankingList) {
		$this->rankingList = $rankingList;
	}

	/**
	 * Get the Supervisory board's list of candidates
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\ListOfCandidates> The Supervisory board's list of candidates
	 */
	public function getListsOfCandidates() {
		return $this->listsOfCandidates;
	}
	
	/**
	 * Get the Supervisory board's name
	 *
	 * @return string The Supervisory board's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Supervisory board's name
	 *
	 * @param string $name The Supervisory board's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Supervisory board's number of seats
	 *
	 * @return int The Supervisory board's number of seats
	 */
	public function getSeats() {
		return $this->seats;
	}

	/**
	 * Sets this Supervisory board's number of seats
	 *
	 * @param int $seats The Supervisory board's number of seats
	 * @return void
	 */
	public function setSeats($seats) {
		$this->seats = $seats;
	}
	
	/**
	 * Get the Supervisory board's number of regional seats
	 *
	 * @return int The Supervisory board's number regional of seats
	 */
	public function getRegionalSeats() {
		return floor($this->seats / 2);
	}
	
	/**
	 * Get the Supervisory board's number of international seats
	 *
	 * @return int The Supervisory board's number of international seats
	 */
	public function getInternationalSeats() {
		return ceil($this->seats / 2);
	}

	/**
	 * Get the Supervisory board's regional code
	 *
	 * @return integer The Supervisory board's regional code
	 */
	public function getRegionalCode() {
		return $this->regionalCode;
	}

	/**
	 * Sets this Supervisory board's regional code
	 *
	 * @param integer $regionalCode The Supervisory board's regional code
	 * @return void
	 */
	public function setRegionalCode($regionalCode) {
		$this->regionalCode = $regionalCode;
	}
	
	/**
	 * Calculate some basic values from the given data of this supervisory board.
	 *
	 * @return void
	 */
	public function basicCalculations(){
		
		$votesPerSBInternational = 0;
		$votesPerSBRegional = 0;
		foreach($this->listsOfCandidates as $list){
			
			$list->setVotes();
			$list->addVotesOfThisListToPartyTotalVotes();
			
			$votesOfAListOfCandidates = $list->getVotes();
			$votesPerSBInternational += $votesOfAListOfCandidates['international'];
			$votesPerSBRegional += $votesOfAListOfCandidates['regional'];

		}

		$this->setVotes($votesPerSBInternational, 'international');
		$this->setVotes($votesPerSBRegional, 'regional');

		$this->setSeatsOfListsThroughSainteLague();
		foreach($this->listsOfCandidates as $list){
			$list->addSeatsOfThisListToPartyTotalSeats();
			$this->setParties($list);
		}
	}
	
	/**
	 * Set seats of the lists of candidates of this supervisory board,
	 * with the help of the Sainte Lague method.
	 *
	 * @return void
	 */
	protected function setSeatsOfListsThroughSainteLague(){
	
		$votes = $this->getVotes();
		for($i=0;$i<count($this->area);$i++){
			$areaVotes = $votes[$this->area[$i]];
			if($this->area[$i] == 'regional'){
				$areaSeats = $this->getRegionalSeats();
			} else {
				$areaSeats = $this->getInternationalSeats();
			}

			$sainteLague = \Mk\Vote\Service\MethodesOfSeatsDistribution::voteBySainteLague($this->listsOfCandidates, $areaVotes, $areaSeats, $this->area[$i], '');

			foreach($sainteLague as $list => $seats){
				foreach($this->listsOfCandidates as $list2 => $value2){
					if($list == $list2){
						$this->listsOfCandidates[$list2]->setSeats($seats, $this->area[$i], 'first');
						break;
					}
				}
			}
		}
		
	}
	
	/**
	 * Get the votes of this supervisory board
	 *
	 * @return array The votes  of this supervisory board
	 */
	public function getVotes() {
		return $this->votes;
	}

	/**
	 * Sets the votes of this supervisory board
	 *
	 * @param int $votes The votes of this supervisory board
	 * @param string $area The area of the votes
	 * @return void
	 */
	public function setVotes($votes, $area) {
		$this->votes[$area] += $votes;
	}

	/**
	 * Get the list of the parties connected with this supervisory board
	 *
	 * @return array The list of the parties connected with this supervisory board
	 */
	public function getParties() {
		return $this->parties;
	}
	
	/**
	 * Sets the parties of this supervisory board
	 * WORKS NOT GOOD ENOUGH, when a party is in 2 or more lists of this supervisory board.
	 *		This also would not make sense (so in this method is no filtering), but so far is not prevented from happening.
	 *
	 * @return void
	 */
	public function setParties($list) {
		$partiesOfList = $list->getParties();
		$this->parties[$partiesOfList[0]->getPersistenceObjectIdentifier()] = $partiesOfList[0]; // must be changed when there is more than 1 Party
	}
	
	/**
	 * Get the vote differences of this supervisory board that resulted in a change of seat distribution.
	 *
	 * @return array Vote differences of this supervisory board
	 */
	public function getVoteDifferences() {
		return $this->voteDifferences;
	}
	
	/**
	 * Sets the vote differences of this supervisory board that resulted in a change of seat distribution.
	 * 
	 * @param array A vote difference of this supervisory board
	 * @return void
	 */
	public function setVoteDifference($voteDifference, $area) {
		$this->voteDifferences[$area][] = $voteDifference;
	}
	
	/**
	 * Set additional list of candidates.
	 * Is useful while creating a new transient ranking list from the data of a persisted rankinglist.
	 *
	 * @param object
	 * @return void 
	 */
	public function setListOfCandidates($listOfCandidates) {
		$this->listsOfCandidates[] = $listOfCandidates;
	}
	
	/**
	 * Remove all lists of candidates.
	 * Is useful while creating a new transient ranking list from the data of a persisted rankinglist.
	 *
	 * @return void 
	 */
	public function removeAllListsOfCandidates() {
		$this->listsOfCandidates = array();
	}
}
?>