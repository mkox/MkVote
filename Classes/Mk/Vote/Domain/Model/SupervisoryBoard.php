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
	 * @ORM\ManyToOne(inversedBy="supervisoryBoard")
	 */
	protected $rankingList;

	/**
	 * The list of candidates
	 * @var \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\ListOfCandidates>
	 * @ORM\OneToMany(mappedBy="supervisoryBoard")
	 */
	protected $listOfCandidates;

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
	 * Constructs this supervisory board
	 */
	public function __construct() {
		$this->listOfCandidates = new \Doctrine\Common\Collections\ArrayCollection();
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
	public function getListOfCandidates() {
		return $this->listOfCandidates;
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
	 * Get the Supervisory board's seats
	 *
	 * @return string The Supervisory board's seats
	 */
	public function getSeats() {
		return $this->seats;
	}

	/**
	 * Sets this Supervisory board's seats
	 *
	 * @param string $seats The Supervisory board's seats
	 * @return void
	 */
	public function setSeats($seats) {
		$this->seats = $seats;
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

}
?>