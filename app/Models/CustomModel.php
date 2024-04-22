<?php

namespace App\Models;

use CodeIgniter\Model;

use CodeIgniter\Database\ConnectionInterface;


class CustomModel extends Model
{
    protected $db;

    public function __construct(ConnectionInterface &$db){
       parent::__construct();
       $this->db =& $db;
       // $db = \Config\Database::connect();
    }
   // Get


  

    public function getwhere($table,$where){
         
        $builder = $this->db->table($table);
        $builder->where($where);
        $query = $builder->get()->getResult();
        return $query;
        
    }

    public function get_all_desc($table,$order_key,$order_by){
         
        $builder = $this->db->table($table);
        $builder->orderBy($order_key, $order_by);
        $query = $builder->get()->getResult();
        return $query;
        
    }

    public function get_all_order_by($table,$order_key,$order_by){
         
        $builder = $this->db->table($table);
        $builder->orderBy($order_key, $order_by);
        $query = $builder->get()->getResult();
        return $query;
        
    }

    public function getwhere_orderby($table,$where,$order_key,$order_by){
         
        $builder = $this->db->table($table);
        $builder->where($where);
        $builder->orderBy($order_key, $order_by);
        $query = $builder->get()->getResult();
        return $query;
        
    }
    




    // Count

    public function countwhere($table,$where){
         
        $builder = $this->db->table($table);
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query; 
    }

    public function count_all_order_by($table,$order_key,$order_by){
         
        $builder = $this->db->table($table);
        $builder->orderBy($order_key, $order_by);
        $query = $builder->countAllResults();
        return $query;
        
    }

    // Add

    public function addData($table,$data){

        $builder = $this->db->table($table);
        return $builder->insert($data);
        
    }

    // Update

    public function updatewhere($where,$data,$table){

        $builder = $this->db->table($table);
        $builder->where($where);
        $query = $builder->update($data);
        return $query;

    }

    // Delete

    public function deleteData($table,$where){

        $builder = $this->db->table($table);
        $query = $builder->delete($where);
        return $query;

    }


    public function get_sum_project_monitoring($table,$column){

        $builder = $this->db->table($table);
        $builder->select('sum('.$column.') as Total');
        $query = $builder->get()->getResult();
        return $query;
    }


    public function get_sum_project_monitoring_where($table,$column,$where){

        $builder = $this->db->table($table);
        $builder->select('sum('.$column.') as Total');
        $builder->where($where);
        $query = $builder->get()->getResult();
        return $query;
    }



    public function search($table,$data){

        $builder = $this->db->table($table);
        $builder->like($data);
        $query = $builder->get()->getResult();
        return $query;
       

    }


     public function count_search($table,$data){

        $builder = $this->db->table($table);
        $builder->like($data);
        $query = $builder->countAllResults();
        return $query; 
       

    }



        public function getReferto(){
         
        $builder = $this->db->table('users');
        $builder->where('user_type != "admin"');
        $query = $builder->get()->getResult();
        return $query;
        
    }


    public function get_cso_project_by_year($where,$year,$order_key,$order_by){


        $builder = $this->db->table('cso_project_implemented');
        $builder->where($where);
        $builder->where("DATE_FORMAT(cso_project_implemented.year,'%Y') = '".$year."' ");
        $builder->orderBy($order_key, $order_by);
        $query = $builder->get()->getResult();
        return $query;

    }



}
