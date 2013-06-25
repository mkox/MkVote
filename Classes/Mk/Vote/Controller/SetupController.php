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
		
		$this->setParties($startArray);
		
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
								
//z								$singleListOfCandidates['parties']['name'] = $lValue2;
//z								$singleListOfCandidates['parties']['parentParty'] = 10;
								
//z								$partiesOfList = new \Doctrine\Common\Collections\ArrayCollection();
//z								$partiesOfList2 = array('name' => $lValue2, 'parentParty' => 10);
//z								$partiesOfList->add($partiesOfList2);
//z								$singleListOfCandidates['parties'] = $partiesOfList;
								
								$sbPartiesWithJoinedEntitiy = $this->listOfPartiesWithJoinedEntity($lValue2, $singleListOfCandidates);
								if(is_array($sbPartiesWithJoinedEntitiy)){
									$sbParties = array_merge($sbParties, $sbPartiesWithJoinedEntitiy);
								}
								
							} else if($lKey2 == 'candidates') {
								foreach($lValue2 as $cKey => $cValue){
									$candidateInList = new \Mk\Vote\Domain\Model\CandidateInList();
								
									$candidateInList->setName('Standard name of candidate in list');
									$candidateInList->setVotesInternational($lValue2[$cKey]['votes']['international']);
									$candidateInList->setVotesRegional($lValue2[$cKey]['votes']['regional']);
									$candidateInList->setListOfCandidates($singleListOfCandidates);
									
									$singleListOfCandidates->getCandidateInList()->add($candidateInList);
									
									$candidatePartiesWithJoinedEntitiy = $this->listOfPartiesWithJoinedEntity($cValue['parties'], $candidateInList);
									if(is_array($candidatePartiesWithJoinedEntitiy)){
										$candidateParties = array_merge($sbParties, $candidatePartiesWithJoinedEntitiy);
									}
								}
							}
						}
						$supervisoryBoard->getListOfCandidates()->add($singleListOfCandidates);
					}
				}
				
			}

			$supervisoryBoard->setName('Standard SB name');
			$supervisoryBoard->setRegionalCode(1);
			
			$supervisoryBoard->setRankingList($rankingList);
			
			$rankingList->getSupervisoryBoard()->add($supervisoryBoard);
		}

//print_r('<br>$rankingList:<br>');
//\Doctrine\Common\Util\Debug::dump($rankingList);

		$this->rankingListRepository->add($rankingList);


//exit;
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
	 * Set parties
	 *
	 * @param string $parties The parties
	 * @param 
	 * @return void
	 */
	public function listOfPartiesWithJoinedEntity($parties, $joinedEntity) {
		
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
	
	/**
	 * Index action
	 *
	 * @return void
	 */
	public function index2Action() {

//		$this->blogRepository->removeAll();
//
//		$blog = new \TYPO3\Blog\Domain\Model\Blog();
//		$blog->setTitle('My Blog');
//		$blog->setDescription('A blog about Foo, Bar and Baz.');
//		$this->blogRepository->add($blog);

//		$startArray = $xy;
//		$rankingList = new \Mk\Vote\Domain\Model\RankingList();
//		$rankingList->setTitle($startArray['title']);
//		$rankingList->setDescription($startArray['description']);
//		foreach($startArray['supervisoryBoard'] as $sb => $value){
//			
//		}
/*		
		$startArray = $xy;
		$rankingList = new \Mk\Vote\Domain\Model\RankingList();
		$rankingList->setTitle($startArray['title']);
		$rankingList->setDescription($startArray['description']);
		
		$supervisoryBoard = new \Doctrine\Common\Collections\ArrayCollection();
		
		foreach($startArray['supervisoryBoard'] as $sb => $value){
			$supervisoryBoard->add($sb);
		}
		$rankingList->setSupervisoryBoard($supervisoryBoard);
		
		$this->rankingListRepository->add($rankingList);
*/		
		
		$startArray = $xy;
		$rankingList = new \stdClass();
		$rankingList->title = $startArray['title'];
		$rankingList->description = $startArray['description'];
		$rankingList->supervisoryBoard = new \stdClass();
		
		foreach($startArray['supervisoryBoard'] as $sb => $value){
			foreach($value as $key2 => $value2){
				if($key2 == 'seats'){
					
				} else if($key2 == 'votesPerList'){
					foreach($value['votesPerList'] as $list => $lValue){
						foreach($lValue as $lKey2 => $lValue2){
							if($lKey2 == 'parties'){
								
							} else if($lKey2 == 'candidates') {
								
							}
						}
					}
				}
			}
		}
		
		$this->rankingListRepository->add($rankingList);
		
	}
	
	/**
	 * Index action
	 *
	 * @return void
	 */
	public function index3Action() {

//		$this->blogRepository->removeAll();
//
//		$blog = new \TYPO3\Blog\Domain\Model\Blog();
//		$blog->setTitle('My Blog');
//		$blog->setDescription('A blog about Foo, Bar and Baz.');
//		$this->blogRepository->add($blog);

//		$startArray = $xy;
//		$rankingList = new \Mk\Vote\Domain\Model\RankingList();
//		$rankingList->setTitle($startArray['title']);
//		$rankingList->setDescription($startArray['description']);
//		foreach($startArray['supervisoryBoard'] as $sb => $value){
//			
//		}
/*		
		$startArray = $xy;
		$rankingList = new \Mk\Vote\Domain\Model\RankingList();
		$rankingList->setTitle($startArray['title']);
		$rankingList->setDescription($startArray['description']);
		
		$supervisoryBoard = new \Doctrine\Common\Collections\ArrayCollection();
		
		foreach($startArray['supervisoryBoard'] as $sb => $value){
			$supervisoryBoard->add($sb);
		}
		$rankingList->setSupervisoryBoard($supervisoryBoard);
		
		$this->rankingListRepository->add($rankingList);
*/		
		
		$startArrayObject = new \Mk\Vote\Service\Setup\startArray1;
		$startArray = $startArrayObject->getContent();
		$rankingList = new \Mk\Vote\Domain\Model\RankingList();
		$rankingList->setName($startArray['name']);
		$rankingList->setDescription($startArray['description']);
//\Doctrine\Common\Util\Debug::dump($rankingList);
		//$rankingList->supervisoryBoard = new \stdClass();
		
		foreach($startArray['supervisoryBoards'] as $sbKey => $sbValue){
			$supervisoryBoard = array();
			//foreach($sbValue as $key2 => $value2){
//			$sbCount = 0;
			foreach($startArray['supervisoryBoards'][$sbKey] as $sbLevel1Key => $sbLevel1value){
				if($sbLevel1Key == 'seats'){
//!!					
					//$rankingList->getSupervisoryBoard()->setSeats($value2);
					
					//$seatsOfThisSB = array('seats' => $sbLevel1value);
					$supervisoryBoard['seats'] = $sbLevel1value;
					
				}
/*			
				else if($sbLevel1Key == 'votesPerList'){
					//foreach($sbValue['votesPerList'] as $list => $lValue){
					//$listOfCandidates = new \Mk\Vote\Domain\Model\ListOfCandidates;
					$listOfCandidates = new \Doctrine\Common\Collections\ArrayCollection();
					foreach($startArray['supervisoryBoards'][$sbKey]['votesPerList'] as $list => $lValue){
						$singleListOfCandidates = array();
						//foreach($lValue as $lKey2 => $lValue2){
						foreach($startArray['supervisoryBoards'][$sbKey]['votesPerList'][$list] as $lKey2 => $lValue2){
							if($lKey2 == 'parties'){
//								$singleListOfCandidates['parties']['name'] = $lValue2;
//								$singleListOfCandidates['parties']['parentParty'] = 10;
								
//								$partiesOfList = new \Doctrine\Common\Collections\ArrayCollection();
//								$partiesOfList2 = array('name' => $lValue2, 'parentParty' => 10);
//								$partiesOfList->add($partiesOfList2);
//								$singleListOfCandidates['parties'] = $partiesOfList;
							} else if($lKey2 == 'candidates') {
								foreach($lValue2 as $cKey => $cValue)
//									$singleListOfCandidates['candidateInList']['name'] = 'Standard name of candidate in list';			
//									$singleListOfCandidates['candidateInList']['votesInternational'] = $lValue2[$cKey]['votes']['international'];
//									$singleListOfCandidates['candidateInList']['votesRegional'] = $lValue2[$cKey]['votes']['regional'];
									$candidateInList = new \Doctrine\Common\Collections\ArrayCollection();
									$candidateInList2 = array(
										'name' => 'Standard name of candidate in list',
										'votesInternational' => $lValue2[$cKey]['votes']['international'],
										'votesRegional' => $lValue2[$cKey]['votes']['regional']
									);
									$candidateInList->add($candidateInList2);
									$singleListOfCandidates['candidateInList'] = $candidateInList;
							}
						}
						$listOfCandidates->add($singleListOfCandidates);
					}
				}
*/				
			}

			$supervisoryBoard['name'] = 'Standard SB name';
			$supervisoryBoard['regionalCode'] = 1;
//			$supervisoryBoard['listOfCandidates'] = $listOfCandidates;
//			$supervisoryBoard['sbCount'] = $sbCount;
//			$sbCount++;
			//$rankingList->getSupervisoryBoard()->add($supervisoryBoard);
		}

print_r('<br>$rankingList:<br>');
\Doctrine\Common\Util\Debug::dump($rankingList);

//print_r('<br>$rankingList->getSupervisoryBoard(): <br>');
//print_r($rankingList->getSupervisoryBoard());
//
//print_r('<br>xdebug_get_code_coverage() 10');
//var_dump(xdebug_get_code_coverage());
//
//print_r('<br>before repository<br>');
print_r('\TYPO3\Flow\var_dump($rankingList): ');
\TYPO3\Flow\var_dump($rankingList);
xdebug_start_code_coverage();
		$this->rankingListRepository->add($rankingList);
xdebug_print_function_stack('Test message 1');
print_r('<br> xdebug_get_function_stack() 20:');
var_dump(xdebug_get_function_stack());
//$abc->grt = 'zzz';
print_r('<br>xdebug_get_code_coverage() 20');
var_dump(xdebug_get_code_coverage());
print_r('<br>after repository<br>');
//xdebug_break();
print_r('zzzz');

print_r('<br>');


//$test10 = array('a' => 'aa', 'b' => 'bb');
//var_dump($test10);
//var_dump($_SERVER);
exit;
	}
	
	/**
	 * Index action
	 *
	 * @return void
	 */
	public function index4Action() {
		
		$startArrayObject = new \Mk\Vote\Service\Setup\startArray1;
		$startArray = $startArrayObject->getContent();
		$rankingList = new \Mk\Vote\Domain\Model\RankingList();
		$rankingList->setName($startArray['name']);
		$rankingList->setDescription($startArray['description']);

print_r('<br>$rankingList:<br>');
\Doctrine\Common\Util\Debug::dump($rankingList);

print_r('\TYPO3\Flow\var_dump($rankingList): ');
\TYPO3\Flow\var_dump($rankingList);
xdebug_start_code_coverage();
		$this->rankingListRepository->add($rankingList);
xdebug_print_function_stack('Test message 1');
print_r('<br> xdebug_get_function_stack() 20:');
var_dump(xdebug_get_function_stack());
//$abc->grt = 'zzz';
print_r('<br>xdebug_get_code_coverage() 20');
var_dump(xdebug_get_code_coverage());
print_r('<br>after repository<br>');
//xdebug_break();
print_r('zzz');

print_r('<br>');

//exit;
	}
	

}

?>
