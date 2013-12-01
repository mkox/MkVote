<?php
namespace Mk\Vote\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "Mk.Vote".                    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Party
 *
 * @Flow\Entity
 */
class Party {

	/**
	 * The name
	 * @var string
	 */
	protected $name;

	/**
	 * The parent party
	 * @var integer
	 */
	protected $parentParty;
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $votes = array('regional' => 0, 'international' => 0);
	
	/**
	 * @var array
	 * @Flow\Transient
	 */
	protected $seats = array('regional' => array('first' => 0, 'corrected' => 0, 'difference' => 0), 
						'international' => array('first' => 0, 'corrected' => 0, 'difference' => 0));

	/**
	 * Constructs this party
	 */
	public function __construct() {
		
	}

	/**
	 * Get the Party's name
	 *
	 * @return string The Party's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Party's name
	 *
	 * @param string $name The Party's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Party's parent party
	 *
	 * @return integer The Party's parent party
	 */
	public function getParentParty() {
		return $this->parentParty;
	}

	/**
	 * Sets this Party's parent party
	 *
	 * @param integer $parentParty The Party's parent party
	 * @return void
	 */
	public function setParentParty($parentParty) {
		$this->parentParty = $parentParty;
	}

	/**
	 * Get the Party's votes
	 *
	 * @return array The Party's votes
	 */
	public function getVotes() {
		return $this->votes;
	}

	/**
	 * Sets this Party's votes
	 *
	 * @param int $votes The Party's votes
	 * @param string $area The area of the votes
	 * @return void
	 */
	public function setVotes($votes, $area) {
		$this->votes[$area] += $votes;
	}
		
	/**
	 * Get the Party's seats
	 *
	 * @return array The Party's seats
	 */
	public function getSeats() {
		return $this->seats;
	}

	/**
	 * Sets this Party's seats
	 *
	 * @param int $seats The Party's seats
	 * @param string $area The area of the votes
	 * @param string $context The context: first, corrected, difference, toCorrect
	 * @return void
	 */
	public function setSeats($seats, $area, $context) {
			$this->seats[$area][$context] += $seats;
	}
	
	/**
	 * Get the Persistence_Object_Identifier of this list of candidates
	 *
	 * @return string The Persistence_Object_Identifier of this list of candidates
	 */
	public function getPersistenceObjectIdentifier() {
		return $this->Persistence_Object_Identifier;
	}

}
?>