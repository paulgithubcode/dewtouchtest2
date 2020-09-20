<?php

class FileUploadController extends AppController {

    public function index() {
        ini_set('auto_detect_line_endings', TRUE);

        if ($this->request->is('post')) {
            $this->FileUpload->set($this->request->data);
            if ($this->FileUpload->validates()) {
                $file = $this->request->data['FileUpload']['file'];
                $name = explode(".", $file['name']);
                $name = uniqid().".".$name[1];

                $ext = substr(strtolower(strrchr($name, '.')), 1); //get the extension
                $arr_ext = array('csv');  //set allowed extensions

                move_uploaded_file($file['tmp_name'], WWW_ROOT . '/files/' . $name);


                $result = array();
                if (($handle = fopen(WWW_ROOT . '/files/' . $name, "r")) !== FALSE) {
                    $delimiter = ',';
                    $i = 0;
                    $data2DArray = array();
                    while (($lineArray = fgetcsv($handle)) !== FALSE) {
                        for ($j=0; $j<count($lineArray); $j++) {
                            if($i != 0)
                            $data2DArray[$i][$j] = $lineArray[$j];
                        }
                        $i++;
                    }
                    fclose($handle);

                    $i = 0;
                    foreach($data2DArray as $csv){
                        $result[$i]['name'] = $csv[0];
                        $result[$i]['email'] = $csv[1];
                        $i++;
                    }

                    $this->FileUpload->create();
                    if ($this->FileUpload->saveAll($result)) {
                        $this->Session->setFlash(__('CSV Upload has been processed and saved', true));
                        //$this->redirect(array('action' => 'index'));
                    } else {
//                        $this->FileUpload->validationErrors
                        $this->Session->setFlash(__('Format Name or Email is incorrect Or Data already exists', false));
                    }
//                    $this->set('data', $this->data['FileUpload']);

                }
            } else {
//                        $this->FileUpload->validationErrors
                $errors = $this->FileUpload->validationErrors;
                $this->Session->setFlash(__('File Upload is not CSV format', false));
            }
        }
        $this->set('title', __('File Upload Answer'));

        $file_uploads = $this->FileUpload->find('all');
        $this->set(compact('file_uploads'));

	}

}