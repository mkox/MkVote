<?php
namespace Mk\Vote\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "Mk.Vote".                    *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Ranking list
 *
 * @FLOW3\Entity
 */
class RankingList {
	
	/**
	 * The overview
	 * @var \Mk\Vote\Domain\Model\Overview
	 * @ORM\ManyToOne(inversedBy="rankingList")
	 */
	protected $overview;

	/**
	 * The supervisory board
	 * @var \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\SupervisoryBoard>
	 * @ORM\OneToMany(mappedBy="rankingList")
	 */
	protected $supervisoryBoard;

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
	 * Constructs this ranking list
	 */
	public function __construct() {
		$this->supervisoryBoard = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the Ranking list's supervisory board
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\SupervisoryBoard> The Ranking list's supervisory board
	 */
	public function getSupervisoryBoard() {
		return $this->supervisoryBoard;
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

}
?>