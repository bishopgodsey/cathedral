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
     
        $data = $this->db->get($this->table_name)->result_array(); 

        foreach($data as $k=>$d) {

            if($d['id_bapt'] && !$d['id_nonBaptise']) {

                $this->load->model('bapteme_model');
                $data_baptise = $this->bapteme_model->find($d['id_bapt']);
                $d['photo'] = $data_baptise->photo;
                $d['nom_bapt'] = $data_baptise->nom_bapt;
                $d['prenom_bapt'] = $data_baptise->prenom_bapt;
                $d['date_naissance'] = $data_baptise->date_naissance; 
            }

            if($d['id_nonBaptise'] && !$d['id_bapt']) {
            
                $this->load->model('personne_model');
                $data_no_baptise = $this->personne_model->find($d['id_nonBaptise']); 
                $d['photo'] = $data_no_baptise->photo;
                $d['nom_bapt'] = $data_no_baptise->nom;
                $d['prenom_bapt'] = $data_no_baptise->prenom;
                $d['date_naissance'] = $data_no_baptise->date_naissance; 
            }

            $data[$k] = $d;
        }
        return $data;
    }

    public function search($filters) {
        $this->db->like($filters);

        return $this->db->get($this->table_name)->result();
    }

	public function getDeces($id){
		$sql="SELECT conf.id_confirmation, com.id_communion,  com.numero_communion, ba.num_carte_bapt, conf.num_confirmation, conf.professionConfirmation, conf.date_confirmation, ba.photo, ba.nom_bapt, ba.prenom_bapt, 
			  com.profession_communion, com.id_paroisse_communion, conf.nom_celebrant, conf.prenom_celebrant, ba.id_paroisse id_paroisse_bapteme, conf.id_lieu_conf FROM confirmation conf
			  JOIN communion com ON com.id_communion=conf.id_communion
			  JOIN bapteme ba ON com.id_bapt = ba.id_bapt WHERE conf.id_confirmation=".$id."";

			return $this->db->query($sql)->row_array();
	}
}
