<?php
namespace Mk\Vote\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "Mk.Vote".                    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A List of candidates
 *
 * @Flow\Entity
 */
class ListOfCandidates {

	/**
	 * The name
	 * @var string
	 */
	protected $name;
	
	/**
	 * The supervisory board
	 * @var \Mk\Vote\Domain\Model\SupervisoryBoard
	 * @ORM\ManyToOne(inversedBy="listsOfCandidates")
	 */
	protected $supervisoryBoard;

	/**
	 * The candidate in list
	 * @var \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\CandidateInList>
	 * @ORM\OneToMany(mappedBy="listOfCandidates")
	 */
	protected $candidatesInList;

	/**
	 * @ORM\ManyToMany
	 * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn()})
	 * @var \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\Party>
	 */
	protected $parties;
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $area = array('regional', 'international');
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $seats = array('regional' => array('first' => 0), 'international' => array('first' => 0));
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $votes = array('regional' => 0, 'international' => 0);

	
	/**
	 * Constructs this list of candidates
	 */
	public function __construct() {
		$this->candidatesInList = new \Doctrine\Common\Collections\ArrayCollection();
		$this->parties = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the name of the list of candidates
	 *
	 * @return string The name of the list of canndidates
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name of the list of candidates
	 *
	 * @param string $name The name of the list of canndidates
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * Get the List of candidates's supervisory board
	 *
	 * @return \Mk\Vote\Domain\Model\SupervisoryBoard The List of candidates's supervisory board
	 */
	public function getSupervisoryBoard() {
		return $this->supervisoryBoard;
	}

	/**
	 * Sets this List of candidates's supervisory board
	 *
	 * @param \Mk\Vote\Domain\Model\SupervisoryBoard $supervisoryBoard The List of candidates's supervisory board
	 * @return void
	 */
	public function setSupervisoryBoard(\Mk\Vote\Domain\Model\SupervisoryBoard $supervisoryBoard) {
		$this->supervisoryBoard = $supervisoryBoard;
	}

	/**
	 * Get the List of candidates's candidate in list
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\CandidateInList> The List of candidates's candidate in list
	 */
	public function getCandidatesInList() {
		return $this->candidatesInList;
	}


	/**
	 * Get the List of candidates's parties
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\Parties> The List of candidates's parties
	 */
	public function getParties() {
		return $this->parties;
	}
	
	/**
	 * Get the name of the list of canndidates
	 *
	 * @return array The seats of the list of candidates
	 */
	public function getSeats() {
		return $this->seats;
	}

	/**
	 * Sets the seats of a list of candidates
	 *
	 * @param array $seats The seats of a list of candidates
	 * @return void
	 */
	public function setSeats($seats) {
		$this->seats = $seats;
	}
	
	/**
	 * Get the votes of the list of candidates
	 *
	 * @return array The votes of the list of candidates
	 */
	public function getVotes() {
		return $this->votes;
	}

	/**
	 * Sets the votes of the list of candidates
	 *
	 * @param int $votes The votes of the list of candidates, for 1 area
	 * @return void
	 */
	public function setVotes() {
		foreach($this->candidatesInList as $candidate => $cvalue){
			for($i=0;$i<count($this->area);$i++){
				if($this->area[$i] == 'regional'){
					$votes = $this->candidatesInList[$candidate]->getVotesRegional();
				} else {
					$votes = $this->candidatesInList[$candidate]->getVotesInternational();
				}
				$this->votes[$this->area[$i]] += $votes;
			}
		}
	}
//	public function setVotes($votes, $area) {
//		$this->votes[$area] += $votes;
//	}

}
?>