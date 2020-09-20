<?php

class FileUpload extends AppModel {
    public $validate = array(
        'file' => array(
            'rule' => array('mimeType', array('text/csv','text/plain')),
            'message' => "Invalid File CSV"
        ),
        'name' => array(
            'rule' => array('maxLength', 50),
            'message' => "Name must be no larger than 50 characters long"
        ),
        'email' => array(
            'maxlength' => array(
                'rule' => array('maxLength', 250),
                'message' => "Email must be no larger than 50 characters long"
            ),
            'isUnique' => array(
                'rule' => array('isUnique', array('email', 'name'), false),
                'message' => "This name & email combination has already been used."
            )
        ),
    );
}