<?php

class Transaction extends AppModel{
    var $belongsTo = array('Member');

    var $inserted_ids = array();

    function afterSave($created, $options = Array()) {
        if($created) {
            $this->inserted_ids[] = $this->getInsertID();
        }
        return true;
    }
    public $validate = array(
        'file' => array(
            'rule' => array('mimeType', array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')),
            'message' => "Invalid File Migration xls or xlsx"
        ),
    );
}