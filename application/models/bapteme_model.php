<?php 

class Bapteme_model extends CI_Model {

    private $table_name = 'bapteme';

    public function __construct () {

        parent::__construct();
    }

    public function get_all($filters = array()) {
        if(!empty($filters)) {
            $this->db->where($filters);
        }

       return $this->db->get($this->table_name)->result(); 
    }

    public function search($filters) {
        $this->db->like($filters);

        return $this->db->get($this->table_name)->result();
    }
}
