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
	
	/**
	 * @var array $arguments
	 */
	protected $arguments;

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
		
		/* outcommented lines: later used for json functionality. */
		
//		$startArrayObject = new \Mk\Vote\Service\Setup\startArray1;
//		$startArray = $startArrayObject->getContent();
//		$je1 = json_encode($startArray);
		
		$this->setArguments();
		$rankingList->calculateSeatsDistribution($this->arguments);
//		$rankingList->setArrayOfBasicData();
//		$je1 = json_encode($rankingList->getBasicData());
		$rankingList->setPartiesForPercentageForm();
		$rankingList->setOriginalPartiesForSelectBox();
		$this->view->assign('rankingList', $rankingList);
//		$this->view->assign('je1', $je1);
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
	
	/**
	* set arguments
	*
	* @return void
	*/
	public function setArguments() {
			$this->arguments = $this->request->getArguments();
	}

}

?>