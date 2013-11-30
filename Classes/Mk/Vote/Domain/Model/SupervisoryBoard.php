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
		foreach($this->listsOfCandidates as $list => $lvalue){
			$lvalue->addVotesOfThisListToPartyTotalVotes();
			
			$votesOfAListOfCandidates = $lvalue->getVotes();
			$votesPerSBInternational += $votesOfAListOfCandidates['international'];
			$votesPerSBRegional += $votesOfAListOfCandidates['regional'];

		}

		$this->setVotes($votesPerSBInternational, 'international');
		$this->setVotes($votesPerSBRegional, 'regional');

		$this->setSeatsOfListsThroughSainteLague();
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
//print_r('<br>in setSeatsOfListsThroughSainteLague(), $areaSeats: ');
//print_r($areaSeats);
			$sainteLague = \Mk\Vote\Service\MethodesOfSeatsDistribution::voteBySainteLague($this->listsOfCandidates, $areaVotes, $areaSeats, $this->area[$i], '');
//print_r('<br>$sainteLague:');	
//print_r($sainteLague);
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

}
?>