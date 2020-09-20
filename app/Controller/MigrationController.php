<?php
	class MigrationController extends AppController{
		
		public function q1(){
			
			$this->setFlash('Question: Migration of data to multiple DB table');
				
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
		public function q1_instruction(){

			$this->setFlash('Question: Migration of data to multiple DB table');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}

		public function process(){
            ini_set('max_execution_time', '0');
            $this->loadModel('Member');
            $this->loadModel('Transaction');
            $this->loadModel('TransactionItem');
            if ($this->request->is('post')) {
                $this->TransactionItem->set($this->request->data);
                if ($this->TransactionItem->validates()) {

                    $file = $this->request->data['Transaction']['file'];
                    $name = explode(".", $file['name']);
                    $name = uniqid().".".$name[1];

                    $ext = substr(strtolower(strrchr($name, '.')), 1); //get the extension
                    $arr_ext = array('xlsx');  //set allowed extensions

                    move_uploaded_file($file['tmp_name'], WWW_ROOT . '/files/' . $name);

                    App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
//                    $objPHPExcel = new PHPExcel();
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                    $objReader->setReadDataOnly(true);

                    $objPHPExcel = $objReader->load(WWW_ROOT . '/files/' . $name);
                    $objWorksheet = $objPHPExcel->getActiveSheet();

                    $highestRow = $objWorksheet->getHighestRow();
                    $highestColumn = $objWorksheet->getHighestColumn();

                    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                    $column_header = array('date','ref_no','member_name','member_no','member_paytype','member_company',
                        'payment_method','batch_no','receipt_no','cheque_no','payment_type','renewal_year','subtotal','tax','total','empty');
                    $columns = array();

//                    echo '<table border="1">' . "\n";
                    for ($row = 1; $row <= $highestRow; ++$row) {
//                        echo '<tr>' . "\n";

                        for ($col = 0; $col <= $highestColumnIndex; ++$col) {
//                            echo '<td>' . $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() . '</td>' . "\n";
                            if($col==0 && $row>1){
                                $value = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(0, $row)->getValue()));
//                                echo '<td>' . date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(0, $row)->getValue())) . '</td>' . "\n";
                            }else{
                                $value = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
//                                echo '<td>' . $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() . '</td>' . "\n";
                            }

                            if($row>1){
                                $columns[$column_header[$col]][] = $value;
                            }
                        }
//                        echo '</tr>' . "\n";
                    }
//                    echo '</table>' . "\n";

                    $total_data = count($columns[$column_header[0]]);

                    $inserted_counter_members = 0;
                    $inserted_counter_transactions = 0;
                    for($i=0;$i<$total_data;$i++){
                        $exploder_no_type = explode(' ',$columns['member_no'][$i]);
                        $type = $exploder_no_type[0];
                        $no = $exploder_no_type[1];

                        $member_data = array();
                        $transaction_data = array();
                        $transaction_item_data = array();
                        $member_data[$i]['type'] = $type;
                        $member_data[$i]['no'] = $no;
                        $member_data[$i]['name'] = $columns['member_name'][$i];
                        $member_data[$i]['company'] = $columns['member_company'][$i];


                        $dt = new DateTime($columns['date'][$i]);
                        $day_of_month = $dt->format('j');
                        $month = $dt->format('n');
                        $year = $dt->format('Y');
                        $transaction_data[$i]['member_name'] = $columns['member_name'][$i];
                        $transaction_data[$i]['member_paytype'] = $columns['member_paytype'][$i];
                        $transaction_data[$i]['member_company'] = $columns['member_company'][$i];
                        $transaction_data[$i]['date'] = $columns['date'][$i];
                        $transaction_data[$i]['year'] = $year;
                        $transaction_data[$i]['month'] = $month;
                        $transaction_data[$i]['ref_no'] = $columns['ref_no'][$i];
                        $transaction_data[$i]['receipt_no'] = $columns['receipt_no'][$i];
                        $transaction_data[$i]['payment_method'] = $columns['payment_method'][$i];
                        $transaction_data[$i]['batch_no'] = $columns['batch_no'][$i];
                        $transaction_data[$i]['cheque_no'] = $columns['cheque_no'][$i];
                        $transaction_data[$i]['payment_type'] = $columns['payment_type'][$i];
                        $transaction_data[$i]['renewal_year'] = $columns['renewal_year'][$i];
                        $transaction_data[$i]['remarks'] = null;
                        $transaction_data[$i]['subtotal'] = $columns['subtotal'][$i];
                        $transaction_data[$i]['tax'] = $columns['tax'][$i];
                        $transaction_data[$i]['total'] = $columns['total'][$i];

                        $transaction_item_data[$i]['description'] = 'Being Payment for : '."\n".$columns['payment_type'][$i].' : '.$columns['renewal_year'][$i];
                        $transaction_item_data[$i]['quantity'] = "1.00";
                        $transaction_item_data[$i]['unit_price'] = $columns['subtotal'][$i];
                        $transaction_item_data[$i]['uom'] = NULL;
                        $transaction_item_data[$i]['sum'] = $transaction_item_data[$i]['quantity']*$columns['subtotal'][$i];

                        $this->Member->create();
                        if ($this->Member->saveAll($member_data)) {
                            $transaction_data[$i]['member_id'] =$this->Member->inserted_ids[$inserted_counter_members];
                            $inserted_counter_members++;
                            $this->Transaction->create();
                            if ($this->Transaction->saveAll($transaction_data)) {
                                $transaction_item_data[$i]['transaction_id'] = $this->Transaction->inserted_ids[$inserted_counter_transactions];
                                $inserted_counter_transactions++;
                                $transaction_item_data[$i]['table'] = 'Member';
                                $transaction_item_data[$i]['table_id'] = $transaction_data[$i]['member_id'];
                                $this->TransactionItem->create();
                                if (!$this->TransactionItem->saveAll($transaction_item_data)) {
                                    exit('Entity Transaction Item Empty');
                                }else{
                                }
                            }else{
                                exit('Entity Transaction Empty');
                            }
                        }else{
                            exit('Entity Member Empty');
                        }
                    }

                    $this->Session->setFlash(__('File Migration is done', true));

//                    var_dump($member_data);exit();

/*                    $this->Member->create();
                    if ($this->Member->saveAssociated($this->request->data)) {
                        die('a');
                    }else{
                        die('b');
                    }*/
/*                    $this->Member->create();
                    if ($this->Member->saveAll($member_data)) {
                        $this->Session->setFlash(__('Member Migrate Done', true));
                        die('a');
                    }else{
                        $this->Session->setFlash(__('Member Migrate Fail', false));
                        die('b');
                    }*/

/*                    $this->Transaction->create();
                    if ($this->Transaction->saveAll($member_data)) {
                        $this->Session->setFlash(__('Member Migrate Done', true));
                        die('a');
                    }else{
                        $this->Session->setFlash(__('Member Migrate Fail', false));
                        die('b');
                    }*/

/*                    $this->TransactionItem->create();
                    if ($this->TransactionItems->saveAll($member_data)) {
                        $this->Session->setFlash(__('Member Migrate Done', true));
                        die('a');
                    }else{
                        $this->Session->setFlash(__('Member Migrate Fail', false));
                        die('b');
                    }*/
                } else {
                    $errors = $this->Transaction->validationErrors;
                    $this->Session->setFlash(__('File Upload is not XLSX format', false));
                }
            }

            $members = $this->Member->find('all');
            $transactions = $this->Transaction->find('all');
            $transaction_items = $this->TransactionItem->find('all');

            $this->set(compact('members'));
            $this->set(compact('transactions'));
            $this->set(compact('transaction_items'));

            $this->set('title', __('Migration of data to multiple DB table'));
//            $this->setFlash('Question: Migration of data to multiple DB table');
        }

	}