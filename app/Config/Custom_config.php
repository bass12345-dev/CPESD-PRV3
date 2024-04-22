<?php

namespace Config;

use CodeIgniter\Config\BaseConfig; 

class Custom_config extends BaseConfig
{
     
    public $barangay = [
        "Apil",
        "Binuangan",
        "Bolibol",
        "Buenavista",
        "Bunga",
        "Buntawan",
        "Burgos",
        "Canubay",
        "Clarin Settlement",
        "Dolipos Bajo",
        "Dolipos Alto",
        "Dulapo",
        "Dullan Norte",
        "Dullan Sur",
        "Lower Lamac",
        "Layawan",
        "Lower Langcangan",
        "Lower Loboc",
        "Lower Rizal",
        "Malindang",
        "Mialen",
        "Mobod",
        "Ciriaco Pastrano",
        "Paypayan",
        "Pines",
        "Poblacion 1",
        "Poblacion 2",
        "Proper Langcangan",
        "San Vicente Alto",
        "San Vicente Bajo",
        "Sebucal",
        "Senote",
        "Taboc Norte",
        "Taboc Sur",
        "Talairon",
        "Talic",
        "Toliyok",
        "Tipan",
        "Transville",
        "Tuyabang Alto",
        "Tuyabang Bajo",
        "Tuyabang Proper",
        "Upper Langcangan",
        "Upper Lamac",
        "Upper Loboc",
        "Upper Rizal",
        "Victoria",
        "Villaflor" 
    ];

    public $civilStatus = [
        "Single",
        "Married",
        "Widowed"
    ];


    public $cso_type  = ['PO', 'Coop','NSC'];
    public $positions  =  [
        'President/BOD Chairperson/BOT',
        'Vice President/BOD Vice Chairperson',
        'Secretary',
        'Treasurer',
        'Auditor',
        'Manager'
        ];

    public $folder_name = ['cor_folder_name' => 'cor','bylaws_folder_name' => 'bylaws', 'aoc_folder_name' => 'aoc' , 'other_docs_folder_name' => 'other_docs'];
  
    public $type_of_activity = ['rmpm' => 'Regular Monthly Project Monitoring'];

    public $user_type = ['admin','user'];

    public $employment_status = ['employed','self-employed','unemployed and actively looking for work', 'underemployed'];

    public $type_of_transactions = ['simple','complex'];

    public $cso_print_options = ['CSO Information' => 'print_cso_information', 'Officers' => 'print_cso_officers', 'CSO Project' => 'print_cso_project' ];
 

} 