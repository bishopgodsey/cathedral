<?php 

class Communion_model extends CI_Model {

    private $table_name = 'communion';

    public function __construct () {

        parent::__construct();
    }

    public function save_communion($data) {
    
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

    public function get_communions() {
    
        $sql = "SELECT com.id_communion, ba.num_carte_bapt, com.date_communion, ba.photo, ba.nom_bapt, ba.prenom_bapt, com.id_paroisse_communion, ba.id_paroisse id_paroisse_bapteme
            FROM communion com
            JOIN bapteme ba ON com.id_bapt = ba.id_bapt";
        
        $data = $this->db->query($sql)->result_array(); 

        $this->load->model('institution_model');
        foreach($data as $key=>$d) {
            $parroisse_communion = $this->institution_model->find($d['id_paroisse_communion']);
            $parroisse_bapteme = $this->institution_model->find($d['id_paroisse_bapteme']);
            $data[$key]['parroisse_communion'] = $parroisse_communion->nom_institution; 
            $data[$key]['parroisse_bapteme'] = $parroisse_bapteme->nom_institution; 
        }

        return $data;
    }

    public function search($filters) {
        $this->db->like($filters);

        return $this->db->get($this->table_name)->result();
    }
}
