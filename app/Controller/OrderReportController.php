<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
			// debug($portions);exit;

            $new_order = array();

            foreach($orders as $key_o => $each_o){
                $new_order[$key_o]['Order'] = $each_o['Order'];
                foreach($each_o['OrderDetail'] as $key_o_od => $each_o_od){
                    $new_order[$key_o]['OrderDetail'][$key_o_od]["id"] = $each_o_od["id"];
                    $new_order[$key_o]['OrderDetail'][$key_o_od]["order_id"] = $each_o_od["order_id"];
                    $new_order[$key_o]['OrderDetail'][$key_o_od]["item_id"] = $each_o_od["item_id"];
                    $new_order[$key_o]['OrderDetail'][$key_o_od]["quantity"] = $each_o_od["quantity"];
                    $new_order[$key_o]['OrderDetail'][$key_o_od]["valid"] = $each_o_od["valid"];
                    $new_order[$key_o]['OrderDetail'][$key_o_od]["created"] = $each_o_od["created"];
                    $new_order[$key_o]['OrderDetail'][$key_o_od]["modified"] = $each_o_od["modified"];
                    $new_order[$key_o]['OrderDetail'][$key_o_od]["Item"] = $each_o_od["Item"];
                    foreach($portions as $key_po=>$each_po){
                        if($each_o_od['Item']["id"] == $each_po['Item']['id']){
                            $new_order[$key_o]['OrderDetail'][$key_o_od]["Portion"] = $each_po["Portion"];
                            foreach($each_po['PortionDetail'] as $key_po_pd => $each_po_pd){
                                $new_order[$key_o]['OrderDetail'][$key_o_od]["PortionDetail"][$key_po_pd]["id"] = $each_po_pd["id"];
                                $new_order[$key_o]['OrderDetail'][$key_o_od]["PortionDetail"][$key_po_pd]["portion_id"] = $each_po_pd["portion_id"];
                                $new_order[$key_o]['OrderDetail'][$key_o_od]["PortionDetail"][$key_po_pd]["part_id"] = $each_po_pd["part_id"];
                                $new_order[$key_o]['OrderDetail'][$key_o_od]["PortionDetail"][$key_po_pd]["value"] = $each_po_pd["value"];
                                $new_order[$key_o]['OrderDetail'][$key_o_od]["PortionDetail"][$key_po_pd]["valid"] = $each_po_pd["valid"];
                                $new_order[$key_o]['OrderDetail'][$key_o_od]["PortionDetail"][$key_po_pd]["created"] = $each_po_pd["created"];
                                $new_order[$key_o]['OrderDetail'][$key_o_od]["PortionDetail"][$key_po_pd]["modified"] = $each_po_pd["modified"];
                                $new_order[$key_o]['OrderDetail'][$key_o_od]["PortionDetail"][$key_po_pd]["Part"] = $each_po_pd["Part"];
                            }
                        }
                    }
                }
            }
//            var_dump($new_order);exit();

            $order_reports = array();
            foreach($new_order as $each){
                foreach($each["OrderDetail"] as $each_order_detail){
                    foreach($each_order_detail["PortionDetail"] as $each_portion_detail){
                        if(isset($order_reports[$each["Order"]["name"]][$each_portion_detail["Part"]["name"]])){
                            $order_reports[$each["Order"]["name"]][$each_portion_detail["Part"]["name"]] += $each_portion_detail["value"] * $each_order_detail["quantity"];
                        }else{
                            $order_reports[$each["Order"]["name"]][$each_portion_detail["Part"]["name"]] = $each_portion_detail["value"] * $each_order_detail["quantity"];
                        }
                    }
                }
            }
//            var_dump($order_reports);exit();

			// To Do - write your own array in this format
/*			$order_reports = array('Order 1' => array(
										'Ingredient A' => 1,
										'Ingredient B' => 12,
										'Ingredient C' => 3,
										'Ingredient G' => 5,
										'Ingredient H' => 24,
										'Ingredient J' => 22,
										'Ingredient F' => 9,
									),
								  'Order 2' => array(
								  		'Ingredient A' => 13,
								  		'Ingredient B' => 2,
								  		'Ingredient G' => 14,
								  		'Ingredient I' => 2,
								  		'Ingredient D' => 6,
								  	),
								);*/

			// ...

			$this->set('order_reports',$order_reports);

			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

//			var_dump($orders);exit();

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}