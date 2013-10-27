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


}
?>