<?php
namespace Mk\Vote\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mk.Vote".               *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Mk\Vote\Domain\Model\RankingList;

class RankingListController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \Mk\Vote\Domain\Repository\RankingListRepository
	 */
	protected $rankingListRepository;
	
//	/**
//	 * @Flow\Inject
//	 * @var \Mk\Vote\Domain\Repository\PartyRepository
//	 */
//	protected $parties;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('rankingLists', $this->rankingListRepository->findAll());
	}

	/**
	 * @param \Mk\Vote\Domain\Model\RankingList $rankingList
	 * @return void
	 */
	public function showAction(RankingList $rankingList) {
//		$rankingList->setParties($this->parties);
		
		$rankingList->calculateSeatsDistribution();
//		\Doctrine\Common\Util\Debug::dump($rankingList);
//		print_r('<br><br>');
		
//		\Doctrine\Common\Util\Debug::dump($rankingList->getSupervisoryBoards());
		
//		$supervisoryBoards = $rankingList->getSupervisoryBoards();
//		\Doctrine\Common\Util\Debug::dump($supervisoryBoards[0]);
//		$listsOfCandidates = $supervisoryBoards[0]->getListsOfCandidates();
//		print_r('<br><br>A List of Candidates: ');
//		\Doctrine\Common\Util\Debug::dump($listsOfCandidates[0]);
		$this->view->assign('rankingList', $rankingList);
	}

	/**
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * @param \Mk\Vote\Domain\Model\RankingList $newRankingList
	 * @return void
	 */
	public function createAction(RankingList $newRankingList) {
		$this->rankingListRepository->add($newRankingList);
		$this->addFlashMessage('Created a new ranking list.');
		$this->redirect('index');
	}

	/**
	 * @param \Mk\Vote\Domain\Model\RankingList $rankingList
	 * @return void
	 */
	public function editAction(RankingList $rankingList) {
		$this->view->assign('rankingList', $rankingList);
	}

	/**
	 * @param \Mk\Vote\Domain\Model\RankingList $rankingList
	 * @return void
	 */
	public function updateAction(RankingList $rankingList) {
		$this->rankingListRepository->update($rankingList);
		$this->addFlashMessage('Updated the ranking list.');
		$this->redirect('index');
	}

	/**
	 * @param \Mk\Vote\Domain\Model\RankingList $rankingList
	 * @return void
	 */
	public function deleteAction(RankingList $rankingList) {
		$this->rankingListRepository->remove($rankingList);
		$this->addFlashMessage('Deleted a ranking list.');
		$this->redirect('index');
	}

}

?>