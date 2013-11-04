<?php
namespace Mk\Vote\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "Mk.Vote".                    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Standard controller for the Mk.Vote package 
 *
 * @Flow\Scope("singleton")
 */
class StandardController extends \TYPO3\Flow\Mvc\Controller\ActionController {


	/**
	 * @Flow\Inject
	 * @var \Mk\Vote\Domain\Repository\RankingListRepository
	 */
	protected $rankingListRepository;
	
	/**
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		
$Overview = new \Mk\Vote\Domain\Model\Overview;
$Overview->getRankingLists();

print_r("<br>Rankinglists more directly: ");
\Doctrine\Common\Util\Debug::dump($this->rankingListRepository->findAll());
		
		$this->view->assign('foos', array(
			'bar', 'baz'
		));
	}
	
	/**
	 * Shows the ranking lists
	 */
	public function rankingListsAction() {
			$this->view->assign('rankingLists', $this->rankingListRepository->findAll());
	}

}

?>