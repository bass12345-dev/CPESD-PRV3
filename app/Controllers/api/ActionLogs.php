<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\CustomModel;
use Config\Custom_config;

class ActionLogs extends BaseController
{
	private   $activity_logs_table              = 'activity_logs';
	private   $users_table                      = 'users';
	protected $request;
	protected $CustomModel;
	protected $UserModel;

	public function __construct()
    {
       $db = db_connect();
       $this->CustomModel = new CustomModel($db); 
       $this->UserModel = new UserModel($db); 
      
    }
    public function get_all_logs()
    {
        	
        $data = [];
	    $items = $this->UserModel->getActivityLogs();

	  	foreach ($items as $row ) {


               $links = $this->links($row->type,$row->action,$row->_id);
	  			

       			$data[] = array(
                  			
                            'name'                 => $row->first_name.' '.$row->middle_name.' '.$row->last_name.' '.$row->extension,
                            'action'				   => $links,
                            'user_type'				=> $row->user_type,
                            'date_and_time'			=> date('F d Y', strtotime($row->activity_log_created)).' '.date('h:i a', strtotime($row->activity_log_created)),
 	                          	
                           
                );


    	}

     echo json_encode($data);
	}


   private function links($type,$action,$id) {

      $links = '';

      switch ($type) {
                  case 'rfa':
                  $links = '<a href="'.base_url().'view-rfa?id='.$id.'">'.$action.'</a>';
                     break;
                  case 'pmas':
                  $links = '<a href="'.base_url().'view-transaction?id='.$id.'">'.$action.'</a>';
                     break;

                  case 'cso':
                  $links = '<a href="'.base_url().'admin/cso/cso-information?id='.$id.'">'.$action.'</a>';
                     break;
                  
      }

      return $links;
   }

}
