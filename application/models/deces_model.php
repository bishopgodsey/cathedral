<?php 

class Deces_model extends CI_Model {

    private $table_name = 'deces';

    public function __construct () {

        parent::__construct();
    }

    public function save_deces($data) {
    
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

    public function get_deces() {
    
        $sql = "SELECT d.id_deces, d.num_enterrement, d.date_deces, ba.photo, ba.nom_bapt, ba.prenom_bapt, ba.date_naissance
            FROM deces d
            JOIN bapteme ba ON d.id_bapt = ba.id_bapt";
        
        $data = $this->db->query($sql)->result_array(); 

        return $data;
    }

    public function search($filters) {
        $this->db->like($filters);

        return $this->db->get($this->table_name)->result();
    }
}
