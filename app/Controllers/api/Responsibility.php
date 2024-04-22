<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CustomModel;

class  Responsibility  extends BaseController
{
    private      $responsibility_table        = 'responsibility_center';
    private      $order_by_desc               = 'desc';
    private     $transactions_table           = 'transactions';
    protected   $request;
    protected   $CustomModel;

    public function __construct()
    {
       $db = db_connect();
       $this->CustomModel = new CustomModel($db); 
       $this->request = \Config\Services::request();  
    }
    public function add_responsibiliy()
    {
       if ($this->request->isAJAX()) {

            $now = new \DateTime();
            $now->setTimezone(new \DateTimezone('Asia/Manila'));
            

            $data = array(

                    'responsibility_center_code' => $this->request->getPost('res_code'),
                    'responsibility_center_name' => $this->request->getPost('center_name'),
                    'responsibility_created' =>  $now->format('Y-m-d H:i:s')
            );

           $verify = $this->CustomModel->countwhere($this->responsibility_table,array('responsibility_center_code' => $data['responsibility_center_code']));

           if ($verify > 0) {

             $data = array(
                'message' => 'Error Duplicate Code',
                'response' => false
                );
              
           }else {

             $result  = $this->CustomModel->addData($this->responsibility_table,$data);

                if ($result) {

                    $data = array(
                    'message' => 'Data Saved Successfully',
                    'response' => true
                    );
                }else {

                    $data = array(
                    'message' => 'Error',
                    'response' => false
                    );
                }
               
           }

            echo json_encode($data);

       }
    }

    public  function get_responsibility(){


        $data = [];
        $item = $this->CustomModel->get_all_order_by($this->responsibility_table,'responsibility_center_id','desc'); 
        foreach ($item as $row) {
            
                $data[] = array(

                        'responsibility_center_code' => $row->responsibility_center_code,
                        'responsibility_center_name' => $row->responsibility_center_name,
                        'responsibility_center_id' => $row->responsibility_center_id 
                );
        }

        echo json_encode($data);

    }


    public function update_responsibility(){

         $data = array('responsibility_center_name' => $this->request->getPost('update_center_name') );

                  $where = array(
                        'responsibility_center_id' => $this->request->getPost('center_id')
                    );

                 $update = $this->CustomModel->updatewhere($where,$data,$this->responsibility_table);

                    if($update){

                        $resp = array(
                            'message' => 'Successfully Updated',
                            'response' => true
                        );

                    }else {

                        $resp = array(
                            'message' => 'Error',
                            'response' => false
                        );

                    }

                    echo json_encode($resp);

    }



         public function delete_responsibility(){

        $where = array('responsibility_center_id' => $this->request->getPost('id'));
        $check = $this->CustomModel->countwhere($this->transactions_table,$where);


        if ($check > 0) {

             $data = array(
                    'message' => 'This item is used in other operations',
                    'response' => false
                    );
            
        }else {

             $result = $this->CustomModel->deleteData($this->responsibility_table,$where);


            if ($result) {

                    $data = array(
                    'message' => 'Deleted Successfully',
                    'response' => true
                    );

                }else {

                    $data = array(
                    'message' => 'Error',
                    'response' => false
                    );
                }

        }
       

             echo json_encode($data);

    }



}
