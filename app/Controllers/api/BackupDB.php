<?php

namespace App\Controllers\Api;
use Ifsnop\Mysqldump\Mysqldump;

use App\Controllers\BaseController;

class BackupDB extends BaseController
{
    public function index()
    {


        $now = new \DateTime();
        $now->setTimezone(new \DateTimezone('Asia/Manila'));
        $date_time  = $now->format('Y-m-d H-i-s');
        $filename = $date_time.' ' . 'cpesd-is' . '.sql';
       
        try {
            
    
        
        $dump = new Mysqldump('mysql:host=localhost;dbname=cpesd_is_backup;port=3306', 'root', '');
        $dump->start(FCPATH .'/uploads/database/final_database_backup3/'.$filename);
        
        $data = array(
                'response' => true,
                'message' => 'Database Exported.');

        }catch (\Exception $e) {
            $data = array(
                'response' => false,
                'message'  => 'error');
        }

        echo json_encode($data);

    
             
    }


    // public function get_database()
    // {
    //     $dir = FCPATH . '/uploads/database/';
    //     $data = [];
    //     $file_data = scandir($dir);

    //     foreach ($file_data as $file) {

    //         if ($file === '.' OR $file === '..') {

    //             continue;
    //             // code...
    //         }else {
                
    //             $data[] = array(

    //                 'database' => $file
    //             );
    //         }
    //     }

    //     echo json_encode($data);
    // }

}
