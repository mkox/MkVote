<?php
namespace Mk\Vote\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "Mk.Vote".                    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Setup controller for the Mk.Vote package 
 *
 * @Flow\Scope("singleton")
 */
class SetupController extends \TYPO3\Flow\Mvc\Controller\ActionController {
	
	/**
	 * @Flow\Inject
	 * @var \Mk\Vote\Domain\Repository\RankingListRepository
	 */
	protected $rankingListRepository;
	
	/**
	 * @Flow\Inject
	 * @var \Mk\Vote\Domain\Repository\PartyRepository
	 */
	protected $partyRepository;
        
	/**
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		
		$startArrayObject = new \Mk\Vote\Service\Setup\startArray1;
		$startArray = $startArrayObject->getContent();
		
		$adjustStartData = 0;
		$adjustData = new \Mk\Vote\Service\adjustData;
		if($adjustStartData == 1){
			$changeData = $adjustData->chooseStartArray(1, 4);
			$startArray = $adjustData->createNewStartArrayFromOld($startArray, $changeData);
		}
		$startArray = $adjustData->addListNameAsPartyName($startArray);
		
		$this->setParties($startArray);
        $this->persistenceManager->persistAll();
        $allParties = $this->partyRepository->findAll();
        
//$allPartiesCount = $this->partyRepository->countAll();
//print_r('y $allPartiesCount: ');
//\Doctrine\Common\Util\Debug::dump($allPartiesCount);
//        
//        $allParties = $this->partyRepository->findAll();
//print_r('<br><br>y $allParties: ');
//\Doctrine\Common\Util\Debug::dump($allParties);
////\TYPO3\Flow\var_dump($allParties);
//
//        foreach ($allParties as $key => $value) {
//            print_r('<br>MMM-$key: ');
//            print_r(\Doctrine\Common\Util\Debug::dump($key));
//            print_r('<br>MMM-$value: ');
//            print_r(\Doctrine\Common\Util\Debug::dump($value));
//            print_r('<br>MMM-$value->getName(): ');
//            print_r($value->getName());
//            print_r('<br>');
////            print_r('<br>' . $key . '<br>' . $value);
////            print_r('<br>' . $allParties->$key->getName());
//        }
//
//exit();
		
		$rankingList = new \Mk\Vote\Domain\Model\RankingList();
		$rankingList->setName($startArray['name']);
		$rankingList->setDescription($startArray['description']);
		
		$sbParties = array();
		$candidateParties = array();
		
		foreach($startArray['supervisoryBoards'] as $sbKey => $sbValue){

			$supervisoryBoard = new \Mk\Vote\Domain\Model\SupervisoryBoard();
			
			foreach($startArray['supervisoryBoards'][$sbKey] as $sbLevel1Key => $sbLevel1value){
				if($sbLevel1Key == 'seats'){
					
					$supervisoryBoard->setSeats($sbLevel1value);
					
				}
			
				else if($sbLevel1Key == 'votesPerList'){

					foreach($startArray['supervisoryBoards'][$sbKey]['votesPerList'] as $list => $lValue){

						$singleListOfCandidates = new \Mk\Vote\Domain\Model\ListOfCandidates();
						$singleListOfCandidates->setName($list);
						$singleListOfCandidates->setSupervisoryBoard($supervisoryBoard);

						foreach($startArray['supervisoryBoards'][$sbKey]['votesPerList'][$list] as $lKey2 => $lValue2){
							if($lKey2 == 'parties'){
								
								if(trim($lValue2) != ''){
									$partyObjectsOfThisList = $this->filterPartyObjects($allParties, $lValue2);
									foreach($partyObjectsOfThisList as $partyObject){
										$singleListOfCandidates->getParties()->add($partyObject);
									}
								}
								
							} else if($lKey2 == 'candidates') {
								foreach($lValue2 as $cKey => $cValue){
									$candidateInList = new \Mk\Vote\Domain\Model\CandidateInList();
								
									$candidateInList->setName('Standard name of candidate in list');
									$candidateInList->setVotesInternational($lValue2[$cKey]['votes']['international']);
									$candidateInList->setVotesRegional($lValue2[$cKey]['votes']['regional']);
									$candidateInList->setListOfCandidates($singleListOfCandidates);
									
									if(trim($cValue['parties']) != ''){
										$partyObjectsOfThisCandidate = $this->filterPartyObjects($allParties, $cValue['parties']);
										foreach($partyObjectsOfThisCandidate as $partyObject){
											$candidateInList->getParties()->add($partyObject);
										}
									//to be done: accept candidate party only, if it is among the parties of the list of this candididate
									}
									
									$singleListOfCandidates->getCandidatesInList()->add($candidateInList);
									
									
								}
							}
						}
						$supervisoryBoard->getListsOfCandidates()->add($singleListOfCandidates);
					}
				}
				
			}

//			$supervisoryBoard->setName('Standard SB name');
			$supervisoryBoard->setName($startArray['supervisoryBoards'][$sbKey]['name']);
			$supervisoryBoard->setRegionalCode(1);
			
			$supervisoryBoard->setRankingList($rankingList);
			
			$rankingList->getSupervisoryBoards()->add($supervisoryBoard);
		}

//print_r('<br>$rankingList:<br>');
//\Doctrine\Common\Util\Debug::dump($rankingList);

		$this->rankingListRepository->add($rankingList);
                $this->persistenceManager->persistAll();
//		$this->redirect('info1');

//exit;
	}
	
	/**
	 * @return void
	 */
	public function info1Action() {
	}
        
	/**
	 * Set parties
	 *
	 * @param array $startArray The start array
	 * @return void
	 */
	public function setParties($startArray) {
		$parties = array();
		foreach($startArray['supervisoryBoards'] as $sb => $sbValue){
			foreach($startArray['supervisoryBoards'][$sb]['votesPerList'] as $vpl => $vplValue){
				if(trim($vplValue['parties']) != ''){
					$listParties = explode(',', $vplValue['parties']);
					$parties = array_merge($parties, $listParties);
				}
				foreach($startArray['supervisoryBoards'][$sb]['votesPerList'][$vpl]['candidates'] as $c => $cValue){
					if(trim($cValue['parties']) != ''){
						$candidateParties = explode(',', trim($cValue['parties']));
						$parties = array_merge($parties, $candidateParties);
					}
				}
			}
		}
		foreach($parties as $key => $pName){ //later methed in Service or using an other way
			$parties[$key] = trim($pName);
		}
		
		$parties = array_unique($parties);
		
		foreach($parties as $pName){
			$party = new \Mk\Vote\Domain\Model\Party();
			$party->setName($pName);
			$party->setParentParty(0);
			$this->partyRepository->add($party);
		}
		
		
	}
	
	/**
	 * Filter parties
	 *
	 * @param array $allParties
	 * @param array $selectedParties
	 * @return void
	 */
	public function filterPartyObjects($allParties, $selectedParties) {
		
		$filteredParties = array();
		$selectedParties = explode(',', $selectedParties);
		
		$counter = 0;
		$numberSelectedParties = count($selectedParties);
		foreach($allParties as $key => $party){
			foreach($selectedParties as $selectedParty){
				if ($party->getName() == trim($selectedParty)){
					$filteredParties[] = $party;
					$counter++;
					break;
				}
			}
			if($counter == $numberSelectedParties){
				break;
			}
		}
		return $filteredParties;
	}
	
	/**
	 * test1 action
	 *
	 * @return void
	 */
	public function test1Action() {
		$startArrayObject = new \Mk\Vote\Service\Setup\startArray1;
		$startArray = $startArrayObject->getContent();
		$rankingList = new \Mk\Vote\Domain\Model\RankingList();
		$rankingList->setName($startArray['name']);
		$rankingList->setDescription($startArray['description']);
print_r('<br>$rankingList:<br>');
\Doctrine\Common\Util\Debug::dump($rankingList);
xdebug_start_code_coverage();		
		$this->rankingListRepository->add($rankingList);
print_r('<br> xdebug_get_function_stack() 50:');
var_dump(xdebug_get_function_stack());
//$abc->grt = 'zzz20';
//htr
print_r('<br>xdebug_get_code_coverage() 50:');
var_dump(xdebug_get_code_coverage());
	}
	

	

}

?>
