<?php

class Type_institution_model extends CI_Model {

    private $table_name = 'type_institution';

    public function __construct() {
         
    }

    public function get_all($filters = array()) {
        if(! empty($filters)) {
            $this->db->where($filters);
        }
       return $this->db->get($this->table_name)->result(); 
    }
}
