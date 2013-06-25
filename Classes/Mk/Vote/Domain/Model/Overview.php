<?php
namespace Mk\Vote\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "Mk.Vote".                    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Overview
 *
 * @Flow\Entity
 */
class Overview {

	/**
	 * The ranking list
	 * @var \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\RankingList>
	 * @ORM\OneToMany(mappedBy="overview")
	 */
	protected $rankingList;


	/**
	 * Get the Overview's ranking list
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\RankingList> The Overview's ranking list
	 */
	public function getRankingList() {
		return $this->rankingList;
	}

}
?>