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
	 * @ORM\ManyToOne(inversedBy="listOfCandidates")
	 */
	protected $supervisoryBoard;

	/**
	 * The candidate in list
	 * @var \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\CandidateInList>
	 * @ORM\OneToMany(mappedBy="listOfCandidates")
	 */
	protected $candidateInList;

	/**
	 * @ORM\ManyToMany
	 * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
	 * @var \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\Party>
	 */
	protected $parties;
	
	/**
	 * Constructs this list of candidates
	 */
	public function __construct() {
		$this->candidateInList = new \Doctrine\Common\Collections\ArrayCollection();
		$this->parties = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the name of the list of canndidates
	 *
	 * @return string The name of the list of canndidates
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name of the list of canndidates
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
	public function getCandidateInList() {
		return $this->candidateInList;
	}


	/**
	 * Get the List of candidates's parties
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\Parties> The List of candidates's parties
	 */
	public function getParties() {
		return $this->parties;
	}

}
?>