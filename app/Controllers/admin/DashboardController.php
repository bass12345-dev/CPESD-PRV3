<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use App\Models\TransactionModel;
use App\Models\ProjectMonitoringModel;
use Config\Custom_config;


class DashboardController extends BaseController
{
    private $transactions_table              = 'transactions';
    private $cso_table                       = 'cso';
    private $users_table                     = 'users';
    private $project_monitoring_table        = 'project_monitoring';
    private $order_by_desc                   = 'desc';
    private $order_by_asc                    = 'asc';
    protected $request;
    protected $CustomModel;
    protected $TransactionModel;
    protected $ProjectMonitoringModel;
    protected $db;
    public $config;


    private $total_collection_sales          = 'total_collection_sales';
    private $total_released_purchases        = 'total_released_purchases';
    private $cash_in_bank                    = 'cash_in_bank';
    private $cash_on_hand                    = 'cash_on_hand';
    private $inventories                     = 'inventories';

    public function __construct()
    {
        

    $this->db                       = db_connect();
    $this->CustomModel              = new CustomModel($this->db); 
    $this->TransactionModel         = new TransactionModel($this->db); 
    $this->ProjectMonitoringModel   = new ProjectMonitoringModel($this->db); 
    $this->request                  = \Config\Services::request();  
    $this->config                   = new Custom_config;
       
       
    }
    public function index()
    {   

        if (session()->get('user_type') == 'admin') {
            $data['title']                              = 'Dashboard';
            $data['count_complete_transactions']        = $this->CustomModel->countwhere($this->transactions_table,array('transaction_status' => 'completed'));
            $data['count_pending_transactions']         = $this->CustomModel->countwhere($this->transactions_table,array('transaction_status' => 'pending'));
            $data['count_po']         = $this->CustomModel->countwhere($this->cso_table,array('type_of_cso' => strtoupper($this->config->cso_type[0])));
            $data['count_coop']                         = $this->CustomModel->countwhere($this->cso_table,array('type_of_cso' => strtoupper($this->config->cso_type[1])));
            $data['count_nsc']                          = $this->CustomModel->countwhere($this->cso_table,array('type_of_cso' => strtoupper($this->config->cso_type[2])));
            $data['total_volume_of_business']           = number_format($this->CustomModel->get_sum_project_monitoring($this->project_monitoring_table,$this->total_collection_sales)[0]->Total + $this->CustomModel->get_sum_project_monitoring($this->project_monitoring_table,$this->total_released_purchases)[0]->Total, 2, '.', ',') ;





            $data['total_cash_position'] = number_format($this->CustomModel->get_sum_project_monitoring($this->project_monitoring_table,$this->cash_in_bank)[0]->Total + $this->CustomModel->get_sum_project_monitoring($this->project_monitoring_table,$this->cash_on_hand)[0]->Total + $this->CustomModel->get_sum_project_monitoring($this->project_monitoring_table,$this->inventories)[0]->Total, 2, '.', ',') ;
            
            $data['users_list'] = $this->CustomModel->getwhere_orderby($this->users_table,array('user_status' => 'active'),'user_type',$this->order_by_asc); 
         
            return view('admin/dashboard/index',$data);
        }else {
           throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
      
    }
}
