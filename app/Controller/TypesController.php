<?php
	class TypesController extends AppController{
		public function save(){
		    $dataType = $this->request->data['Type']['type'];
//		    $data = $this->request;
//		    var_dump($data);
//		    var_dump($_POST['data']['Type']['type']);exit();
			$this->set('dataType',$dataType);
		}
		public function index(){}
	}