<?php
namespace Mk\Vote\Service;

// Especially for adjusted data that might be stored in a database.
class adjustData{
	
	/**
	 * The area
	 * @var array
	 */
	protected $area = array('regional', 'international');
	
	public function chooseStartArray($id, $subId, $startArray){
		switch($id){
			case 1:
				
				//include('startArray1.php');

				if($subId > 0){
					switch($subId){
						case 1:
							$changeData = $this->changeStartArrayData1();
							break;
						case 2:
							$changeData = $this->changeStartArrayData2();
							break;
						case 3:
							$changeData = $this->changeStartArrayData3();
							break;
						case 4:
							$changeData = $this->changeStartArrayData4();
							break;
					}
					$startArray = $this->createNewStartArrayFromOld($startArray, $changeData);
				}
				break;
		}
		return $startArray;
	}

//	protected function originalListPercentageData1(){
//		$data = array('A'=>7, 'B'=>15, 'C'=>38, 'D'=>40);
//		return $data;
//	}
	
	//original: 7, 15, 38, 40
	protected function changeStartArrayData1(){
		
		$data = array(
			0 => array('A', 'A', 7, 8),
				//$data[0][0]: List/Party of new start array
				//$data[0][1]: List/Party of old start array
				//$data[0][2]: Percentage international of new list/party
				//$data[0][2]: Percentage regional of new list/party
					//About regional area ($this->area[0]) see also remarks in method originalListPercentageData($startArray).
			1 => array('B', 'D', 10, 9),
			2 => array('C', 'B', 15, 17),
			3 => array('D', 'C', 33, 32),
			4 => array('E', 'D', 35, 34)
		);
		return $data;
	}
	
	protected function changeStartArrayData2(){
		
		$data = array(
			0 => array('A', 'A', 8, 5),
			1 => array('B', 'D', 14, 18),
			2 => array('C', 'B', 22, 24),
			3 => array('D', 'C', 27, 26),
			4 => array('E', 'D', 29, 27)
		);
		return $data;
	}
	
	protected function changeStartArrayData3(){
		
		$data = array(
			0 => array('A', 'A', 7, 7),
			1 => array('B', 'D', 15, 15),
			2 => array('C', 'B', 22, 22),
			3 => array('D', 'C', 27, 27),
			4 => array('E', 'D', 29, 29)
		);
		return $data;
	}
	
	protected function changeStartArrayData4(){
		
//		$data = array(
//			0 => array('A', 'A', 7, 10),
//			1 => array('B', 'D', 13, 10),
//			2 => array('C', 'B', 23, 20),
//			3 => array('D', 'C', 27, 29),
//			4 => array('E', 'D', 30, 31)
//		);

		$data = array(
			0 => array('A', 'A', 7, 7),
			1 => array('B', 'D', 13, 13),
			2 => array('C', 'B', 23, 23),
			3 => array('D', 'C', 27, 27),
			4 => array('E', 'D', 30, 30)
		);
		
		return $data;
	}
	
	protected function createNewStartArrayFromOld($startArray, $changeData){
		
		$newStartArray = $startArray;
//		$originalListPercentage = $this->originalListPercentageData1();
		$originalListPercentage = $this->originalListPercentageData($startArray);
//print_r('<br>$originalListPercentage: ');
//print_r($originalListPercentage);
//		$originalListPercentage = $originalListPercentage['international'];
		foreach($startArray['supervisoryBoards'] as $sb => $value){
			$newStartArray['supervisoryBoards'][$sb]['votesPerList'] = array();

			for($i=0;$i<count($changeData);$i++){

				if(is_array($value['votesPerList'][$changeData[$i][1]])){
					
					$newStartArray['supervisoryBoards'][$sb]['votesPerList'][$changeData[$i][0]] = $value['votesPerList'][$changeData[$i][1]];
				
					for($j=0;$j<count($this->area);$j++){
						if($changeData[$i][2 + $j] != $originalListPercentage[$this->area[$j]][$changeData[$i][1]]){
							foreach($newStartArray['supervisoryBoards'][$sb]['votesPerList'][$changeData[$i][0]]['candidates'] as $candidate => $cValue){

//								$newStartArray['supervisoryBoards'][$sb]['votesPerList'][$changeData[$i][0]]['candidates'][$candidate]['votes']['international'] = round(($cValue['votes']['international'] / $originalListPercentage[$changeData[$i][1]] * 100) * ($changeData[$i][2] / 100));
//								$newStartArray['supervisoryBoards'][$sb]['votesPerList'][$changeData[$i][0]]['candidates'][$candidate]['votes']['regional'] = round(($cValue['votes']['regional'] / $originalListPercentage[$changeData[$i][1]] * 100) * ($changeData[$i][2] / 100));
								
//								$newStartArray['supervisoryBoards'][$sb]['votesPerList'][$changeData[$i][0]]['candidates'][$candidate]['votes'][$this->area[$j]] = round(($cValue['votes'][$this->area[$j]] / $originalListPercentage[$this->area[$j]][$changeData[$i][1]] * 100) * ($changeData[$i][2] / 100));
								$newStartArray['supervisoryBoards'][$sb]['votesPerList'][$changeData[$i][0]]['candidates'][$candidate]['votes'][$this->area[$j]] = 
										round(($cValue['votes'][$this->area[$j]] / $originalListPercentage[$this->area[$j]][$changeData[$i][1]] * 100) * ($changeData[$i][2 + $j] / 100));
								// About regional area ($this->area[0]) see also remarks in method originalListPercentageData($startArray).
							}
						}
					}
				}
			}

		}
		return $newStartArray;
	}
	
	protected function originalListPercentageData($startArray){
		$votesOriginal = $this->dataOfallConnectedSBofOriginal($startArray);
//print_r('<br>$votesOriginal: ');
//print_r($votesOriginal);
		$sharePerList = array();
		$sharePerList['international'] = array();
		$sharePerList['regional'] = array();
		for($i=0;$i<count($this->area);$i++){
			foreach($votesOriginal['votes'][$this->area[$i]]['lists'] as $list => $votes){
				$sharePerList[$this->area[$i]][$list] = round($votes / $votesOriginal['votes'][$this->area[$i]]['sum'] * 100, 2);
			}
		}
		// For the regional area ($this->area[0]) these %-values have only limited meaning. If these %ages would be for lists/parties of a single supervisory board, the meaning would be bigger; but
		// here there is a ranking list with several supervisory boards, and each company can have its headquarters in a different country. So here the %ages for the ranking list
		// can only be used for a rough overview obout what is happening when a party has, in comparison to its international votes, expecially many or few votes.
		// (More useful is the ability to view and change the [%al] regional votes for a single supervisory board.)
//print_r('<br>$sharePerList: ');
//print_r($sharePerList);
		return $sharePerList;
	}
	
	protected function dataOfallConnectedSBofOriginal($startArray){
		$data = array();
		for($i=0;$i<count($this->area);$i++){
			$data['votes'][$this->area[$i]]['sum'] = 0;
		}

		foreach($startArray['supervisoryBoards'] as $sb){
			foreach($sb['votesPerList'] as $listKey => $list){
				foreach($list['candidates'] as $candidate){
					for($i=0;$i<count($this->area);$i++){
						$data['votes'][$this->area[$i]]['sum'] += $candidate['votes'][$this->area[$i]];
						if(!isset($data['votes'][$this->area[$i]]['lists'][$listKey])){
							$data['votes'][$this->area[$i]]['lists'][$listKey] = 0;
						}
						$data['votes'][$this->area[$i]]['lists'][$listKey] += $candidate['votes'][$this->area[$i]];
					}
				}
			}
		}
		return $data;
	}
	
	// Makes out of the list-name $list also the party-name $list (a temporary solution)
	public function addListNameAsPartyName($startArray) {
		
		foreach($startArray['supervisoryBoards'] as $sb => $value){
			foreach($value['votesPerList'] as $list => $lvalue){
				$startArray['supervisoryBoards'][$sb]['votesPerList'][$list]['parties'] = $list;
			}
		}
		return $startArray;
		
	}
	
}
?>
