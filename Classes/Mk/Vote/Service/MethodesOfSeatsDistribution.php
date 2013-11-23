<?php
namespace Mk\Vote\Service;

class MethodesOfSeatsDistribution{
	
	static function voteBySainteLague($lists, $votesTotal, $seats, $area, $mode){
//print_r('<br>voteBySainteLague: <br>');
//print_r('<br>$lists: ');	
//print_r($lists);
//print_r('<br>$votesTotal: ');	
//print_r($votesTotal);
//print_r('<br>$seats: ');	
//print_r($seats);
		$resultList = array();
		$divisor = 0.5;
		$counter = 0;
		for($i=1;$i<=$seats;$i++){
			foreach($lists as $list => $value){
//print_r('<br>$lists -> $value: ');	
//print_r($value);
				$counter ++;
				if($mode == ''){
				//	$votesOfList = $value['votes']['international'];
					$votesOfList = $value['votes'][$area];
				} else {
					$votesOfList = $value['votes'];
				}
			//	$resultList[$counter]['dividedValue'] = $value['votes']['international'] / $divisor;
//print_r('<br>$votesOfList: ');
//print_r($votesOfList);
				$resultList[$counter]['dividedValue'] = $votesOfList / $divisor;
				$resultList[$counter]['list'] = $list;
			}
			$divisor += 1;
		}
//print_r('<br>$resultList10: ');	
//print_r($resultList);

		usort($resultList, 'compare');
//print_r('<br>$resultList20: ');	
//print_r($resultList);
		$seatsResult = array();
		for($i=0;$i<$seats;$i++){
			
			if($seatsResult[$resultList[$i]['list']]){
				
				$seatsResult[$resultList[$i]['list']] += 1;
			} else {
				
				$seatsResult[$resultList[$i]['list']] = 1;
			}
		}
//print_r('<br>$seatsResult: ');	
//print_r($seatsResult);
//print_r('<br>$resultList30: ');	
//print_r($resultList);
		return $seatsResult;
		
//print_r('<br>$resultList:');	
//print_r($resultList);
		
	}
	
}

/**
 * Get sorted list from voteBySainteLague()
 *
 * @return array Sorted list from voteBySainteLague
 */
function compare($valueA, $valueB){

	$a = $valueA['dividedValue'];
	$b = $valueB['dividedValue'];

	if ($a == $b) {
		return 0;
	}

	return ($a < $b) ? +1 : -1;
}

?>
