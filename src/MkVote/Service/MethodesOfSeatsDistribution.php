<?php
namespace Mk\Vote\Service;

class MethodesOfSeatsDistribution{
	
	static function voteBySainteLague($lists, $votesTotal, $seats, $area, $mode){

		$resultList = array();
		$divisor = 0.5;
		$counter = 0;
		for($i=1;$i<=$seats;$i++){
			foreach($lists as $list => $value){

				$counter ++;
				$getVotes = $value->getVotes();
				if($mode == ''){
				//	$votesOfList = $getVotes['international'];
					$votesOfList = $getVotes[$area];
				} else {
//					$votesOfList = $value['votes'];
					$votesOfList = $value->getVotes();
					$votesOfList = $votesOfList[$area];
				}

				$resultList[$counter]['dividedValue'] = $votesOfList / $divisor;
				$resultList[$counter]['list'] = $list;
			}
			$divisor += 1;
		}

		usort($resultList, function ($valueA, $valueB){
			$a = $valueA['dividedValue'];
			$b = $valueB['dividedValue'];
			if ($a == $b) {
				return 0;
			}
			return ($a < $b) ? +1 : -1;
		});

		$seatsResult = array();
		for($i=0;$i<$seats;$i++){
			
			if(isset($seatsResult[$resultList[$i]['list']])){
				
				$seatsResult[$resultList[$i]['list']] += 1;
			} else {
				
				$seatsResult[$resultList[$i]['list']] = 1;
			}
		}

		return $seatsResult;
	}
	
}

?>
