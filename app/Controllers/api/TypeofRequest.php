<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use App\Models\RFAModel;


class TypeofRequest extends BaseController
{
    private    $type_of_request_table        = 'type_of_request';
    private    $rfa_transactions_table       = 'rfa_transactions';
    private    $order_by_desc                = 'desc';
    private    $order_by_asc                 = 'asc';
    protected $request;
    protected $CustomModel;
    protected $RFAModel;

    public function __construct()
    {
       $db = db_connect();
       $this->CustomModel = new CustomModel($db); 
       $this->RFAModel = new RFAModel($db); 
       $this->request = \Config\Services::request();  
    }

    public function get_last_ref_number(){

         if ($this->request->isAJAX()) {

            $l = '';
            $verify = $this->CustomModel->count_all_order_by($this->rfa_transactions_table,'rfa_date_filed',$this->order_by_desc);
            if($verify) {
                if(date('Y', time()) > date('Y', strtotime($this->CustomModel->get_all_order_by($this->rfa_transactions_table,'rfa_date_filed',$this->order_by_desc)[0]->rfa_date_filed)))
                {
                    
                    $l = '001';

                }else if(date('Y', time()) < date('Y', strtotime($this->CustomModel->get_all_order_by($this->rfa_transactions_table,'rfa_date_filed',$this->order_by_desc)[0]->rfa_date_filed))){

                    $x = $this->RFAModel->get_last_ref_number_where(date('Y-m-d', time()))->getResult()[0]->number + 1;

                    $l = $this->put_zeros($x);

                }else if (date('Y', time()) === date('Y', strtotime($this->CustomModel->get_all_order_by($this->rfa_transactions_table,'rfa_date_filed',$this->order_by_desc)[0]->rfa_date_filed))) 
    
                {
                    $x = $this->RFAModel->get_last_ref_number_where(date('Y', time()))->getResult()[0]->number + 1;

                    $l = $this->put_zeros($x);
                }
            }else {

                $l = '001';

            }
            
            echo $l;

        }
    }




    function put_zeros($x){

        $l = '';

           if ($x  < 10) {

                        $l = '00'.$x;
                      
                    }else if($x < 100 ) {

                        $l = '0'.$x;
                       

                    }else {


                         $l = $x;
                        
                    }

                    return $l;

    }


    public function add_type_of_request()
    {
        if ($this->request->isAJAX()) {


              $now = new \DateTime();
            $now->setTimezone(new \DateTimezone('Asia/Manila'));

            $data = array(

                        'type_of_request_name' => $this->request->getPost('request_name'),
                        'type_of_request_created' =>  $now->format('Y-m-d H:i:s')
            );

            $result  = $this->CustomModel->addData($this->type_of_request_table,$data);

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

             echo json_encode($data);
        }
    }

    public function get_request(){

        $data = [];
        $item = $this->CustomModel->get_all_desc($this->type_of_request_table,'type_of_request_name',$this->order_by_desc); 
        foreach ($item as $row) {
            
                $data[] = array(

                        'type_of_request_id' => $row->type_of_request_id ,
                        'type_of_request_name' => $row->type_of_request_name,
                       
                );
        }

        echo json_encode($data);
    }



        public function update_request(){


                $data = array('type_of_request_name' => $this->request->getPost('update_type_of_request') );

                  $where = array(
                        'type_of_request_id' => $this->request->getPost('type_of_request_id')
                    );

                 $update = $this->CustomModel->updatewhere($where,$data,$this->type_of_request_table);

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



public function delete_request(){

        $where1 = array('tor_id' => $this->request->getPost('id'));
        $where2 = array('type_of_request_id' => $this->request->getPost('id'));
        $check = $this->CustomModel->countwhere($this->rfa_transactions_table,$where1);


        if ($check > 0) {

             $data = array(
                    'message' => 'This data is used in other operations',
                    'response' => false
                    );
            
        }else {

             $result = $this->CustomModel->deleteData($this->type_of_request_table,$where2);


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
