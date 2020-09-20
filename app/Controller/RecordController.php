<?php
	class RecordController extends AppController{

	    public $paginate = array(
	        'limit' => 5,
            'order' => array('Record.id','Desc')
        );

		public function index(){
			ini_set('memory_limit','256M');
			set_time_limit(0);
			
			$this->setFlash('Listing Record page too slow, try to optimize it.');


//			$records = $this->Record->find('all');

//			$this->set('records',$records);

			
			$this->set('title',__('List Record'));
		}

		public function fetch(){
            $this->modelClass = "Record";
            $this->autoRender = false;
            $output = $this->Record->getData();

            echo json_encode($output);
        }
		
		
// 		public function update(){
// 			ini_set('memory_limit','256M');
			
// 			$records = array();
// 			for($i=1; $i<= 1000; $i++){
// 				$record = array(
// 					'Record'=>array(
// 						'name'=>"Record $i"
// 					)			
// 				);
				
// 				for($j=1;$j<=rand(4,8);$j++){
// 					@$record['RecordItem'][] = array(
// 						'name'=>"Record Item $j"		
// 					);
// 				}
				
// 				$this->Record->saveAssociated($record);
// 			}
			
			
			
// 		}
	}