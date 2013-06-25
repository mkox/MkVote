<?php
namespace Mk\Vote\Service\Setup;

class startArray1{
	
	public function __construct() {
		
	}
	
	public function getContent(){

		$startArray = array(
			'name' => 'Ranking list A',
			'description' => 'A description for ranking list A',
			'supervisoryBoards' => array(
				'SB1' => array(
					'id' => 'SB1',
					'seats' => 5,
					'votesPerList' => array(
						'A' => array(
								'parties' => 'p XY, p XZ',
								//'votes' => 625,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 179,
											'regional' => 41
										),
										'parties' => 'p XZ',
									),
									'c2' => array(
										'votes' => array(
											'international' => 210,
											'regional' => 21
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 147,
											'regional' => 42
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 11,
											'regional' => 0
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 78,
											'regional' => 4
										),
										'parties' => '',
									)
								)
							),
						'B' => array(
								'parties' => '',
								//'votes' => 1300,
								'candidates' => array(
									'c6' => array(
										'votes' => array(
											'international' => 411,
											'regional' => 31
										),
										'parties' => '',
									),
									'c7' => array(
										'votes' => array(
											'international' => 517,
											'regional' => 203
										),
										'parties' => '',
									),
									'c8' => array(
										'votes' => array(
											'international' => 213,
											'regional' => 15
										),
										'parties' => '',
									),
									'c9' => array(
										'votes' => array(
											'international' => 87,
											'regional' => 31
										),
										'parties' => '',
									),
									'c10' => array(
										'votes' => array(
											'international' => 72,
											'regional' => 8
										),
										'parties' => '',
									)
								)
							),
						'C' => array(
								'parties' => '',
								//'votes' => 3125,
								'candidates' => array(
									'c11' => array(
										'votes' => array(
											'international' => 1013,
											'regional' => 53
										),
										'parties' => '',
									),
									'c12' => array(
										'votes' => array(
											'international' => 1307,
											'regional' => 41
										),
										'parties' => '',
									),
									'c13' => array(
										'votes' => array(
											'international' => 512,
											'regional' => 354
										),
										'parties' => '',
									),
									'c14' => array(
										'votes' => array(
											'international' => 280,
											'regional' => 51
										),
										'parties' => '',
									),
									'c15' => array(
										'votes' => array(
											'international' => 13,
											'regional' => 0
										),
										'parties' => '',
									)
								)
							),
						'D' => array(
								'parties' => '',
								//'votes' => 3811,
								'candidates' => array(
									'c16' => array(
										'votes' => array(
											'international' => 1417,
											'regional' => 403
										),
										'parties' => '',
									),
									'c17' => array(
										'votes' => array(
											'international' => 1087,
											'regional' => 203
										),
										'parties' => '',
									),
									'c18' => array(
										'votes' => array(
											'international' => 313,
											'regional' => 21
										),
										'parties' => '',
									),
									'c19' => array(
										'votes' => array(
											'international' => 548,
											'regional' => 44
										),
										'parties' => '',
									),
									'c20' => array(
										'votes' => array(
											'international' => 446,
											'regional' => 61
										),
										'parties' => '',
									)
								)
							),
					)
				),
				'SB2' => array(
					'id' => 'SB2',
					'seats' => 5,
					'votesPerList' => array(
						'A' => array(
								'parties' => '',
								//'votes' => 775,
								'candidates' => array(
									'c21' => array(
										'votes' => array(
											'international' => 280,
											'regional' => 120
										),
										'parties' => '',
									),
									'c22' => array(
										'votes' => array(
											'international' => 160,
											'regional' => 131
										),
										'parties' => '',
									),
									'c23' => array(
										'votes' => array(
											'international' => 191,
											'regional' => 60
										),
										'parties' => '',
									),
									'c24' => array(
										'votes' => array(
											'international' => 81,
											'regional' => 12
										),
										'parties' => '',
									),
									'c25' => array(
										'votes' => array(
											'international' => 63,
											'regional' => 14
										),
										'parties' => '',
									)
								)
							),
						'B' => array(
								'parties' => '',
								//'votes' => 1700,
								'candidates' => array(
									'c26' => array(
										'votes' => array(
											'international' => 351,
											'regional' => 45
										),
										'parties' => '',
									),
									'c27' => array(
										'votes' => array(
											'international' => 474,
											'regional' => 71
										),
										'parties' => '',
									),
									'c28' => array(
										'votes' => array(
											'international' => 504,
											'regional' => 114
										),
										'parties' => '',
									),
									'c29' => array(
										'votes' => array(
											'international' => 171,
											'regional' => 24
										),
										'parties' => '',
									),
									'c30' => array(
										'votes' => array(
											'international' => 200,
											'regional' => 13
										),
										'parties' => '',
									)
								)
							),
						'C' => array(
								'parties' => '',
								//'votes' => 3910,
								'candidates' => array(
									'c31' => array(
										'votes' => array(
											'international' => 1487,
											'regional' => 574
										),
										'parties' => '',
									),
									'c32' => array(
										'votes' => array(
											'international' => 1212,
											'regional' => 631
										),
										'parties' => '',
									),
									'c33' => array(
										'votes' => array(
											'international' => 412,
											'regional' => 21
										),
										'parties' => '',
									),
									'c34' => array(
										'votes' => array(
											'international' => 617,
											'regional' => 103
										),
										'parties' => '',
									),
									'c35' => array(
										'votes' => array(
											'international' => 182,
											'regional' => 14
										),
										'parties' => '',
									)
								)
							),
						'D' => array(
								'parties' => '',
								//'votes' => 3619,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 912,
											'regional' => 223
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 613,
											'regional' => 218
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 412,
											'regional' => 104
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 389,
											'regional' => 105
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 1293,
											'regional' => 113
										),
										'parties' => '',
									)
								)
							),
					)
				),
				'SB3' => array(
					'id' => 'SB3',
					'seats' => 5,
					'votesPerList' => array(
						'A' => array(
								'parties' => '',
								//'votes' => 675,
								'candidates' => array(
									'c6' => array(
										'votes' => array(
											'international' => 211,
											'regional' => 14
										),
										'parties' => '',
									),
									'c7' => array(
										'votes' => array(
											'international' => 141,
											'regional' => 31
										),
										'parties' => '',
									),
									'c8' => array(
										'votes' => array(
											'international' => 78,
											'regional' => 5
										),
										'parties' => '',
									),
									'c9' => array(
										'votes' => array(
											'international' => 187,
											'regional' => 2
										),
										'parties' => '',
									),
									'c10' => array(
										'votes' => array(
											'international' => 58,
											'regional' => 0
										),
										'parties' => '',
									)
								)
							),
						'B' => array(
								'parties' => '',
								//'votes' => 1650,
								'candidates' => array(
									'c11' => array(
										'votes' => array(
											'international' => 711,
											'regional' => 248
										),
										'parties' => '',
									),
									'c12' => array(
										'votes' => array(
											'international' => 103,
											'regional' => 147
										),
										'parties' => '',
									),
									'c13' => array(
										'votes' => array(
											'international' => 326,
											'regional' => 112
										),
										'parties' => '',
									),
									'c14' => array(
										'votes' => array(
											'international' => 351,
											'regional' => 37
										),
										'parties' => '',
									),
									'c15' => array(
										'votes' => array(
											'international' => 159,
											'regional' => 45
										),
										'parties' => '',
									)
								)
							),
						'C' => array(
								'parties' => '',
								//'votes' => 4212,
								'candidates' => array(
									'c16' => array(
										'votes' => array(
											'international' => 1651,
											'regional' => 289
										),
										'parties' => '',
									),
									'c17' => array(
										'votes' => array(
											'international' => 1253,
											'regional' => 341
										),
										'parties' => '',
									),
									'c18' => array(
										'votes' => array(
											'international' => 491,
											'regional' => 112
										),
										'parties' => '',
									),
									'c19' => array(
										'votes' => array(
											'international' => 611,
											'regional' => 121
										),
										'parties' => '',
									),
									'c20' => array(
										'votes' => array(
											'international' => 206,
											'regional' => 87
										),
										'parties' => '',
									)
								)
							),
						'D' => array(
								'parties' => '',
								//'votes' => 4783,
								'candidates' => array(
									'c21' => array(
										'votes' => array(
											'international' => 1384,
											'regional' => 357
										),
										'parties' => '',
									),
									'c22' => array(
										'votes' => array(
											'international' => 1625,
											'regional' => 312
										),
										'parties' => '',
									),
									'c23' => array(
										'votes' => array(
											'international' => 897,
											'regional' => 214
										),
										'parties' => '',
									),
									'c24' => array(
										'votes' => array(
											'international' => 307,
											'regional' => 89
										),
										'parties' => '',
									),
									'c25' => array(
										'votes' => array(
											'international' => 570,
											'regional' => 187
										),
										'parties' => '',
									)
								)
							),
					)
				),
				'SB4' => array(
					'id' => 'SB4',
					'seats' => 5,
					'votesPerList' => array(
						'A' => array(
								'parties' => '',
								//'votes' => 725,
								'candidates' => array(
									'c26' => array(
										'votes' => array(
											'international' => 173,
											'regional' => 65
										),
										'parties' => '',
									),
									'c27' => array(
										'votes' => array(
											'international' => 247,
											'regional' => 121
										),
										'parties' => '',
									),
									'c28' => array(
										'votes' => array(
											'international' => 204,
											'regional' => 112
										),
										'parties' => '',
									),
									'c29' => array(
										'votes' => array(
											'international' => 68,
											'regional' => 12
										),
										'parties' => '',
									),
									'c30' => array(
										'votes' => array(
											'international' => 33,
											'regional' => 21
										),
										'parties' => '',
									)
								)
							),
						'B' => array(
								'parties' => '',
								//'votes' => 1350,
								'candidates' => array(
									'c31' => array(
										'votes' => array(
											'international' => 661,
											'regional' => 251
										),
										'parties' => '',
									),
									'c32' => array(
										'votes' => array(
											'international' => 312,
											'regional' => 198
										),
										'parties' => '',
									),
									'c33' => array(
										'votes' => array(
											'international' => 241,
											'regional' => 58
										),
										'parties' => '',
									),
									'c34' => array(
										'votes' => array(
											'international' => 41,
											'regional' => 9
										),
										'parties' => '',
									),
									'c35' => array(
										'votes' => array(
											'international' => 95,
											'regional' => 21
										),
										'parties' => '',
									)
								)
							),
						'C' => array(
								'parties' => '',
								//'votes' => 3369,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 813,
											'regional' => 121
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 1248,
											'regional' => 307
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 512,
											'regional' => 201
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 105,
											'regional' => 8
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 691,
											'regional' => 41
										),
										'parties' => '',
									)
								)
							),
						'D' => array(
								'parties' => '',
								//'votes' => 4451,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 1713,
											'regional' => 507
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 913,
											'regional' => 154
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 1217,
											'regional' => 206
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 224,
											'regional' => 54
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 384,
											'regional' => 108
										),
										'parties' => '',
									)
								)
							),
					)
				),
				'SB5' => array(
					'id' => 'SB5',
					'seats' => 5,
					'votesPerList' => array(
						'A' => array(
								'parties' => '',
								//'votes' => 711,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 178,
											'regional' => 21
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 164,
											'regional' => 34
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 231,
											'regional' => 31
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 47,
											'regional' => 3
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 91,
											'regional' => 12
										),
										'parties' => '',
									)
								)
							),
						'B' => array(
								'parties' => '',
								//'votes' => 1925,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 217,
											'regional' => 45
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 241,
											'regional' => 65
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 187,
											'regional' => 41
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 1174,
											'regional' => 213
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 106,
											'regional' => 47
										),
										'parties' => '',
									)
								)
							),
						'C' => array(
								'parties' => '',
								//'votes' => 3690,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 1587,
											'regional' => 31
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 1421,
											'regional' => 27
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 412,
											'regional' => 102
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 217,
											'regional' => 15
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 53,
											'regional' => 8
										),
										'parties' => '',
									)
								)
							),
						'D' => array(
								'parties' => '',
								//'votes' => 3217,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 1157,
											'regional' => 254
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 843,
											'regional' => 112
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 861,
											'regional' => 341
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 137,
											'regional' => 54
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 219,
											'regional' => 135
										),
										'parties' => '',
									)
								)
							),
					)
				),
				'SB6' => array(
					'id' => 'SB6',
					'seats' => 5,
					'votesPerList' => array(
						'A' => array(
								'parties' => '',
								//'votes' => 689,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 217,
											'regional' => 45
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 123,
											'regional' => 31
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 219,
											'regional' => 40
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 98,
											'regional' => 17
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 32,
											'regional' => 9
										),
										'parties' => '',
									)
								)
							),
						'B' => array(
								'parties' => '',
								//'votes' => 1817,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 715,
											'regional' => 203
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 401,
											'regional' => 121
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 453,
											'regional' => 251
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 107,
											'regional' => 41
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 141,
											'regional' => 45
										),
										'parties' => '',
									)
								)
							),
						'C' => array(
								'parties' => '',
								//'votes' => 4475,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 1691,
											'regional' => 457
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 1153,
											'regional' => 215
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 1146,
											'regional' => 198
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 351,
											'regional' => 32
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 134,
											'regional' => 12
										),
										'parties' => '',
									)
								)
							),
						'D' => array(
								'parties' => '',
								//'votes' => 4378,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 2341,
											'regional' => 145
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 841,
											'regional' => 124
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 517,
											'regional' => 64
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 583,
											'regional' => 45
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 96,
											'regional' => 5
										),
										'parties' => '',
									)
								)
							),
					)
				),
				'SB7' => array(
					'id' => 'SB7',
					'seats' => 5,
					'votesPerList' => array(
						'A' => array(
								'parties' => '',
								//'votes' => 450,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 147,
											'regional' => 45
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 163,
											'regional' => 30
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 46,
											'regional' => 17
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 51,
											'regional' => 8
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 43,
											'regional' => 14
										),
										'parties' => '',
									)
								)
							),
						'B' => array(
								'parties' => '',
								//'votes' => 1975,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 871,
											'regional' => 245
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 713,
											'regional' => 284
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 219,
											'regional' => 45
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 143,
											'regional' => 21
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 29,
											'regional' => 2
										),
										'parties' => '',
									)
								)
							),
						'C' => array(
								'parties' => '',
								//'votes' => 4561,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 1413,
											'regional' => 41
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 742,
											'regional' => 204
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 1541,
											'regional' => 102
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 487,
											'regional' => 21
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 378,
											'regional' => 13
										),
										'parties' => '',
									)
								)
							),
						'D' => array(
								'parties' => '',
								//'votes' => 4189,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 1754,
											'regional' => 461
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 1142,
											'regional' => 351
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 887,
											'regional' => 153
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 309,
											'regional' => 87
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 97,
											'regional' => 23
										),
										'parties' => '',
									)
								)
							),
					)
				),
				'SB8' => array(
					'id' => 'SB8',
					'seats' => 5,
					'votesPerList' => array(
						'A' => array(
								'parties' => '',
								//'votes' => 950,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 297,
											'regional' => 49
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 288,
											'regional' => 41
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 153,
											'regional' => 37
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 114,
											'regional' => 11
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 98,
											'regional' => 15
										),
										'parties' => '',
									)
								)
							),
						'B' => array(
								'parties' => '',
								//'votes' => 1025,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 374,
											'regional' => 46
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 213,
											'regional' => 57
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 316,
											'regional' => 31
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 86,
											'regional' => 15
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 36,
											'regional' => 12
										),
										'parties' => '',
									)
								)
							),
						'C' => array(
								'parties' => '',
								//'votes' => 4231,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 2217,
											'regional' => 452
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 1467,
											'regional' => 301
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 217,
											'regional' => 54
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 128,
											'regional' => 41
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 202,
											'regional' => 21
										),
										'parties' => '',
									)
								)
							),
						'D' => array(
								'parties' => '',
								//'votes' => 4381,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 811,
											'regional' => 101
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 2117,
											'regional' => 217
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 741,
											'regional' => 254
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 447,
											'regional' => 53
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 265,
											'regional' => 22
										),
										'parties' => '',
									)
								)
							),
					)
				),
				'SB9' => array(
					'id' => 'SB9',
					'seats' => 5,
					'votesPerList' => array(
						'A' => array(
								'parties' => '',
								//'votes' => 1000,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 417,
											'regional' => 41
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 281,
											'regional' => 81
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 134,
											'regional' => 23
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 98,
											'regional' => 17
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 70,
											'regional' => 12
										),
										'parties' => '',
									)
								)
							),
						'B' => array(
								'parties' => '',
								//'votes' => 1183,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 281,
											'regional' => 31
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 303,
											'regional' => 34
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 297,
											'regional' => 42
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 187,
											'regional' => 17
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 115,
											'regional' => 14
										),
										'parties' => '',
									)
								)
							),
						'C' => array(
								'parties' => '',
								//'votes' => 3388,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 1452,
											'regional' => 507
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 1151,
											'regional' => 421
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 507,
											'regional' => 231
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 213,
											'regional' => 89
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 65,
											'regional' => 21
										),
										'parties' => '',
									)
								)
							),
						'D' => array(
								'parties' => '',
								//'votes' => 3549,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 1117,
											'regional' => 309
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 1241,
											'regional' => 204
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 419,
											'regional' => 126
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 541,
											'regional' => 131
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 231,
											'regional' => 81
										),
										'parties' => '',
									)
								)
							),
					)
				),
				'SB10' => array(
					'id' => 'SB10',
					'seats' => 5,
					'votesPerList' => array(
						'A' => array(
								'parties' => '',
								//'votes' => 400,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 138,
											'regional' => 42
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 155,
											'regional' => 29
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 37,
											'regional' => 12
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 41,
											'regional' => 17
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 29,
											'regional' => 6
										),
										'parties' => '',
									)
								)
							),
						'B' => array(
								'parties' => '',
								//'votes' => 1075,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 349,
											'regional' => 47
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 289,
											'regional' => 39
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 180,
											'regional' => 62
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 169,
											'regional' => 32
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 88,
											'regional' => 4
										),
										'parties' => '',
									)
								)
							),
						'C' => array(
								'parties' => '',
								//'votes' => 3039,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 927,
											'regional' => 203
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 1448,
											'regional' => 141
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 324,
											'regional' => 88
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 217,
											'regional' => 61
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 123,
											'regional' => 48
										),
										'parties' => '',
									)
								)
							),
						'D' => array(
								'parties' => '',
								//'votes' => 3622,
								'candidates' => array(
									'c1' => array(
										'votes' => array(
											'international' => 1268,
											'regional' => 257
										),
										'parties' => '',
									),
									'c2' => array(
										'votes' => array(
											'international' => 1227,
											'regional' => 268
										),
										'parties' => '',
									),
									'c3' => array(
										'votes' => array(
											'international' => 403,
											'regional' => 104
										),
										'parties' => '',
									),
									'c4' => array(
										'votes' => array(
											'international' => 418,
											'regional' => 98
										),
										'parties' => '',
									),
									'c5' => array(
										'votes' => array(
											'international' => 306,
											'regional' => 76
										),
										'parties' => '',
									)
								)
							),
					)
				),

			)

		);
		
		return $startArray;
	}

}
		
?>
