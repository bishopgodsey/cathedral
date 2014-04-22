<?php

class Role_permission_model extends CI_Model {

    private $table_name = 'role_permissions';
    
    function __construct() {
        parent::__construct();
    }

    function find_for_role($role_id) {
        $this->db->where('role_id', $role_id);

        return $this->db->get($this->table_name)->result();    
    }

    function find_all_roles_permissions() {
        return $this->db->get($this->table_name)->result();
    }

    function delete($filters=array()) {
        if(!empty($filters) && is_array($filters)) {
            $this->db->delete($this->table_name,$filters);
        }else {
            $this->db->empty_table($this->table_name);
        }
    }

    function save_all($data) {
        
        $this->db->insert_batch($this->table_name, $data);

        return $this->db->affected_rows() > 0;
    }

    

}

