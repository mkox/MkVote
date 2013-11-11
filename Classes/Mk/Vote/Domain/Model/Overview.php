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
	protected $rankingLists;


	/**
	 * Get the Overview's ranking lists
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Mk\Vote\Domain\Model\RankingList> The Overview's ranking list
	 */
	public function getRankingLists() {


//print_r('OV $allParties for $this->rankingLists');
//$allParties = $this->rankingLists;
//$m = 0;
//		foreach($allParties as $key => $party){
//print_r('<br>OV $m: ' . $m++ . '<br>');
//					$filteredParties[] = $party;
//
//		}
//print_r('$filteredParties');
//\Doctrine\Common\Util\Debug::dump($filteredParties);

print_r("<br>Rankinglists from Overview: ");
\Doctrine\Common\Util\Debug::dump($this->rankingLists);
		return $this->rankingLists;
	}

}
?>