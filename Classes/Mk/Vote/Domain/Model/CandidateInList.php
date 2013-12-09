<?php
namespace Mk\Vote\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "Mk.Vote".                    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Candidate in list
 *
 * @Flow\Entity
 */
class CandidateInList {

	/**
	 * The list of candidates
	 * @var \Mk\Vote\Domain\Model\ListOfCandidates
	 * @ORM\ManyToOne(inversedBy="candidatesInList")
	 */
	protected $listOfCandidates;

	/**
	 * The name
	 * @var string
	 */
	protected $name;

	/**
	 * The votes international
	 * @var integer
	 */
	protected $votesInternational;

	/**
	 * The votes regional
	 * @var integer
	 */
	protected $votesRegional;
	
//	/**
//	 * @var array
//	 * @Flow\Transient
//	 */
//	protected $votes;

	/**
	 * @ORM\ManyToMany
	 * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn()})
	 * @var \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\Party>
	 */
	protected $parties;
	
	/**
	 * Constructs this candidate in list
	 */
	public function __construct() {
		$this->parties = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the Candidate in list's list of candidates
	 *
	 * @return \Mk\Vote\Domain\Model\ListOfCandidates The Candidate in list's list of candidates
	 */
	public function getListOfCandidates() {
		return $this->listOfCandidates;
	}

	/**
	 * Sets this Candidate in list's list of candidates
	 *
	 * @param \Mk\Vote\Domain\Model\ListOfCandidates $listOfCandidates The Candidate in list's list of candidates
	 * @return void
	 */
	public function setListOfCandidates(\Mk\Vote\Domain\Model\ListOfCandidates $listOfCandidates) {
		$this->listOfCandidates = $listOfCandidates;
	}

	/**
	 * Get the Candidate in list's name
	 *
	 * @return string The Candidate in list's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Candidate in list's name
	 *
	 * @param string $name The Candidate in list's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Candidate in list's votes international
	 *
	 * @return integer The Candidate in list's votes international
	 */
	public function getVotesInternational() {
		return $this->votesInternational;
	}

	/**
	 * Sets this Candidate in list's votes international
	 *
	 * @param integer $votesInternational The Candidate in list's votes international
	 * @return void
	 */
	public function setVotesInternational($votesInternational) {
		$this->votesInternational = $votesInternational;
	}

	/**
	 * Get the Candidate in list's votes regional
	 *
	 * @return integer The Candidate in list's votes regional
	 */
	public function getVotesRegional() {
		return $this->votesRegional;
	}

	/**
	 * Sets this Candidate in list's votes regional
	 *
	 * @param integer $votesRegional The Candidate in list's votes regional
	 * @return void
	 */
	public function setVotesRegional($votesRegional) {
		$this->votesRegional = $votesRegional;
	}

	/**
	 * Get the Candidate in list's parties
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\Party> The Candidate in list's parties
	 */
	public function getParties() {
		return $this->parties;
	}
	
	
//	/**
//	 * Get the votes of the votes of a candidates
//	 *
//	 * @return array The votes of a candidates
//	 */
//	public function getVotes() {
//		return $this->votes;
//	}
//	
//	/**
//	 * add a new key 'original' to the votes array, 
//	 * copy existing data to this place,
//	 * add percentages of this candidate in relation to all votes of an area (at the moment: an area of a ranking list).
//	 *
//	 * @param array $percentages
//	 * @return void
//	 */
//	public function setVotesOriginal($percentages) {
////		$this->votes['original']['regional']['sum'] = $this->votes['regional'];
////		$this->votes['original']['international']['sum'] = $this->votes['international'];
//		$this->votes['original']['regional']['percentage'] = $percentages['regional'];
//		$this->votes['original']['international']['percentage'] = $percentages['international'];
//	}

}
?>