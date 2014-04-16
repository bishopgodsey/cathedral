<?php

class Role_permission_model extends CI_Model {

    private $table_name = 'role_permissions';
    
    function __construct() {
        parent::__construct();
    }

    function find_for_role($role_id) {
    
    }

    function find_all_roles_permissions() {
        return $this->db->get($this->table_name)->result();
    }

    

}

