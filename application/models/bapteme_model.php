<?php 

class Bapteme_model extends CI_Model {

    private $table_name = 'bapteme';

    public function __construct () {

        parent::__construct();
    }

    public function save_bapteme($data) {
    
        $this->db->set('created_by',$this->auth->user_id());
        $this->db->set('created_on','NOW()',FALSE);

        $this->db->insert($this->table_name, $data);

        return (bool) $this->db->affected_rows();        

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
