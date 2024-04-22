<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CustomModel;

class Users extends BaseController
{
    private    $users_table                  = 'users';
    private    $transactions_table           = 'transactions';
    private    $rfa_transactions_table       = 'rfa_transactions';
    protected $request;
    protected $CustomModel;

    public function __construct()
    {
       $db = db_connect();
       $this->CustomModel = new CustomModel($db); 
       $this->request = \Config\Services::request();  
    }

    public function add_user()
    {

    //     $now = new DateTime();
    //     $now->setTimezone(new DateTimezone('Asia/Manila'));
    // echo $now->format('Y-m-d H:i:s');
        if ($this->request->isAJAX()) {

             $now = new \DateTime();
            $now->setTimezone(new \DateTimezone('Asia/Manila'));

            $data = array(
                'first_name' => $this->request->getPost('first_name'),
                'middle_name' => ($this->request->getPost('middle_name') == '') ?  '' : $this->request->getPost('middle_name') ,
                'last_name' => $this->request->getPost('last_name'),
                'extension' => ($this->request->getPost('extension') == '') ?  '' : $this->request->getPost('extension') ,
                'address' => $this->request->getPost('barangay'),
                'user_type' => $this->request->getPost('user_type'),
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'user_created' =>  $now->format('Y-m-d H:i:s'),
                'user_status' => 'active',
              
            );

            $verify = $this->CustomModel->countwhere($this->users_table,array('username' => $data['username']));

            if ($verify > 0) {

                $data = array(
                'message' => 'Error Duplicate Username',
                'response' => false
                );
               
            }else {

                $result  = $this->CustomModel->addData($this->users_table,$data);

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


    public function get_user_active(){

        $data = [];
        $where = array('user_status' => 'active');
        $item = $this->CustomModel->getwhere($this->users_table,$where); 
        foreach ($item as $row) {
            $a = '';

            if ($row->user_type == 'admin') {
                $a = '';
            }else {
                $a = '<ul class="d-flex justify-content-center"><li class="mr-1"><a href="javascript:;" data-id="'.$row->user_id.'" id="view_user"  class="text-secondary action-icon"><i class="ti-eye"></i></a></li><li><a href="javascript:;" data-id="'.$row->user_id.'"  id="delete-user" data-set="inactive" class="text-danger action-icon"><i class="ti-close"></i></a></li></ul>';
            }
 
                $data[] = array(

                        'name' => $row->first_name.' '.$row->middle_name.' '.$row->last_name.' '.$row->extension,
                        'user_type' => $row->user_type,
                        'username' => $row->username,
                        'user_id' => $row->user_id,
                        'action' => $a

                );
        }

        echo json_encode($data);

    }

    public function get_user_inactive(){

        $data = [];
        $where = array('user_status' => 'inactive');
        $item = $this->CustomModel->getwhere($this->users_table,$where); 
        foreach ($item as $row) {
            $a = '';

            if ($row->user_type == 'admin') {
                $a = '';
            }else {
                $a = '<ul class="d-flex justify-content-center"><li class="mr-1"><a href="javascript:;" data-id="'.$row->user_id.'"  id="view_user"  class="text-secondary action-icon"><i class="ti-eye"></i></a></li><li><a href="javascript:;" data-id="'.$row->user_id.'" data-set="active" id="active-user"  class="text-success action-icon"><i class="ti-check"></i></a></li><li><a href="javascript:;" data-name="'.$row->first_name.' '.$row->middle_name.' '.$row->last_name.' '.$row->extension.'" data-id="'.$row->user_id.'" data-set="active" id="remove-user"  class="text-danger action-icon"><i class="ti-trash"></i></a></li></ul>';
            }

                $data[] = array(

                        'name' => $row->first_name.' '.$row->middle_name.' '.$row->last_name.' '.$row->extension,
                        'user_type' => $row->user_type,
                        'username' => $row->username,
                        'user_id' => $row->user_id,
                        'action' => $a


                );
        }

        echo json_encode($data);



    }

    public function update_user_status(){

        $data = array('user_status' => $this->request->getPost('status'));
        $where = array('user_id' => $this->request->getPost('id'));
        $update = $this->CustomModel->updatewhere($where,$data,$this->users_table);

        if ($update) {

            $data = array(
                'message' => 'Updated Successfully',
                'response' => true
            );
            # code...
        }else {

            $data = array(
                'message' => 'Error',
                'response' => false
            );

        }

        echo json_encode($data);

    }

    public function get_user_data(){


        $row  = $this->CustomModel->getwhere($this->users_table,array('user_id' => $this->request->getPost('id')))[0];

        $data = array(

                        'name'           => $row->first_name.' '.$row->middle_name.' '.$row->last_name.' '.$row->extension,
                        'user_type'      => $row->user_type,
                        'username'       => $row->username,
                        'user_id'        => $row->user_id,
                        'first_name'     => $row->first_name,
                        'middle_name'    => $row->middle_name,
                        'last_name'      => $row->last_name,
                        'extension'      => $row->extension,
                        'email_address'  => $row->email_address,
                        'contact_number' => $row->contact_number,
                        'barangay'       => $row->address,
                        'profile_picture'=> $this->get_profile_picture($this->request->getPost('id'))
        );

        echo json_encode($data);

    }


    function get_profile_picture($id){


    $path = "./uploads/profile_picture/".$id;

    $profile_pic = '';

    if (is_dir($path)) {
        
         $file = scandir($path)[2];

         $profile_pic = "uploads/profile_picture/".$id.'/'.$file;
        
    }else {

          $profile_pic = 'assets/images/profile.jpg';
       

    }


    return $profile_pic;


    }


    public function update_user_information(){


           if ($this->request->isAJAX()) {

            $data = array(
                'first_name' => $this->request->getPost('first_name'),
                'middle_name' => ($this->request->getPost('middle_name') == '') ?  '' : $this->request->getPost('middle_name') ,
                'last_name' => $this->request->getPost('last_name'),
                'extension' => ($this->request->getPost('extension') == '') ?  '' : $this->request->getPost('extension') ,
                'address' => $this->request->getPost('barangay'),
                'email_address' =>  $this->request->getPost('email_address'),
                'contact_number' => $this->request->getPost('contact_number'),
                'username' => $this->request->getPost('username'),
                
              
            );

             $where = array(
                        'user_id' => $this->request->getPost('user_id')
                    );


              $update = $this->CustomModel->updatewhere($where,$data,$this->users_table);

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

           
     
        }

    public function verify_old_password(){

        // 

        $where  = array('user_id' => $this->request->getPost('user_id'));
        $pass   = $this->request->getPost('old_password');

        $user = $this->CustomModel->getwhere($this->users_table,$where)[0];
            
            if (password_verify($pass,$user->password) ) {

                 $resp = array(
                            'message' => '',
                            'response' => true
                        );


            }else {

                $resp = array(
                            'message' => "Password Don't Match ",
                            'response' => false
                        );

            }


            echo json_encode($resp);


    }
    

    public function update_password(){

        $where  = array('user_id' => $this->request->getPost('user_id'));

         $data = array(
               
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                
            );

          $update = $this->CustomModel->updatewhere($where,$data,$this->users_table);

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


    public function update_user_profile(){



    $path = FCPATH ."uploads/profile_picture/".session()->get('user_id');

    if (!is_dir($path)) {
        mkdir($path,0777, true);
    }






    $allFiles = scandir($path);
    $files = array_diff($allFiles, array('.', '..'));


    if ($files > 0) {
        
         foreach ($files as $file) {

                unlink($path.'/'.$file);
         }
    }

    $destination = '';
    $new_name = '';

    if (is_dir($path)) {
        if (isset($_FILES['update_profile_picture'])) {
        $new_name = $_FILES['update_profile_picture']['name'];
        $destination = $path.'/'.$new_name;
        move_uploaded_file($_FILES['update_profile_picture']['tmp_name'], $destination);
        

    }

     if(file_exists($destination)) {

             $data = array(
                'message' => 'Profile Picture Updated Successfully',
                'response' => true
                );
         
        } else {


             $data = array(
                'message' => 'Error',
                'response' => false
                );
          
        }


        echo  json_encode($data);
}



    }
   

   public function register(){



     if ($this->request->isAJAX()) {

        $now = new \DateTime();
            $now->setTimezone(new \DateTimezone('Asia/Manila'));

         $data = array(
                'first_name'            => $this->request->getPost('first_name'),
                'middle_name'           => ($this->request->getPost('middle_name') == '') ?  '' : $this->request->getPost('middle_name') ,
                'last_name'             => $this->request->getPost('last_name'),
                'extension'             => ($this->request->getPost('extension') == '') ?  '' : $this->request->getPost('extension') ,
                'address'               => $this->request->getPost('barangay'),
                'work_status'           => $this->request->getPost('work_status'),
                'user_type'             => 'user',
                'email_address'         => $this->request->getPost('email'),
                'contact_number'        => $this->request->getPost('contact_number'),
                'username'              => $this->request->getPost('username'),
                'password'              => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'user_created'          =>  $now->format('Y-m-d H:i:s'),
                'user_status'           => 'inactive',
              
            );



        $verify = $this->CustomModel->countwhere($this->users_table,array('username' => $data['username']));
         if ($verify > 0) {

            $data = array(
                'message' => 'Username is Taken',
                'response' => false
                );

         }else {



              $result  = $this->CustomModel->addData($this->users_table,$data);

                if ($result) {

                    $data = array(
                    'message' => 'Registered Successfully || Please Wait for Account Activation',
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

   public function delete_user(){
    

    $where1 = array('user_id' => $this->request->getPost('id'));
    $where2 = array('created_by' => $this->request->getPost('id'));
    $where4 = array('rfa_client_added_by' => $this->request->getPost('id'));



    $check1 = $this->CustomModel->countwhere($this->transactions_table,$where2);
    $check2 = $this->CustomModel->countwhere('rfa_transactions',array('reffered_to' => $this->request->getPost('id')));
    $check3 = $this->CustomModel->countwhere('rfa_clients',$where4);


    if ($check1 > 0 || $check2 > 0 || $check3 > 0) {
        
          $data = array(
                    'message' => "Can't Delete This user",
                    'response' => false
                    );
    }else {

        $result = $this->CustomModel->deleteData($this->users_table,$where1);


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
