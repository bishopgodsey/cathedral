<?php 

class Confirmation_model extends CI_Model {

    private $table_name = 'confirmation';

    public function __construct () {

        parent::__construct();
    }

    public function save_confirmation($data) {

        $this->db->set('created_by',$this->auth->user_id());
        $this->db->set('created_on','NOW()',FALSE);

		if(isset($data['id_confirmation']) AND $data['id_confirmation']!='' AND $data['id_confirmation']>0){
			$this->db->where('id_confirmation', $data['id_confirmation']);
			$this->db->update($this->table_name, $data);
		}else{
			$this->db->insert($this->table_name, $data);
		}

        return (bool) $this->db->affected_rows();        

    }

    public function get_all($filters = array()) {
        if(!empty($filters)) {
            $this->db->where($filters);
        }

        return $this->db->get($this->table_name)->result();
    }

    public function get_confirmations() {

        $sql = "SELECT con.id_confirmation,ba.num_carte_bapt, con.date_confirmation, con.id_paroisse id_paroisse_confirmation, ba.photo, ba.nom_bapt, ba.prenom_bapt, com.id_paroisse_communion id_paroisse_communion, ba.id_paroisse id_paroisse_bapteme,
			con.id_lieu_conf
            FROM confirmation con
            LEFT JOIN communion com ON con.id_communion = com.id_communion
            JOIN bapteme ba ON com.id_bapt = ba.id_bapt";
        $data = $this->db->query($sql)->result_array(); 

        $this->load->model('institution_model');
        foreach($data as $key=>$d) {
            $parroisse_confirmation = $this->institution_model->find($d['id_paroisse_confirmation']);
			$lieu_confirmation=$this->institution_model->find($d['id_lieu_conf']);
            $parroisse_communion = $this->institution_model->find($d['id_paroisse_communion']);
            $parroisse_bapteme = $this->institution_model->find($d['id_paroisse_bapteme']);
            $data[$key]['parroisse_confirmation'] = $parroisse_confirmation->nom_institution; 
            $data[$key]['parroisse_communion'] = $parroisse_communion->nom_institution; 
            $data[$key]['parroisse_bapteme'] = $parroisse_bapteme->nom_institution; 
            $data[$key]['lieu_confirmation']=$lieu_confirmation->nom_institution;
        }

        return $data;
    }

    public function search($filters) {
        $this->db->like($filters);

        return $this->db->get($this->table_name)->result();
    }
    public function suggest_communion($filter) {
        $sql = "SELECT co.id_communion,ba.num_carte_bapt,ba.nom_bapt, ba.prenom_bapt 
            FROM communion co left join bapteme ba 
            on ba.id_bapt = co.id_bapt 
            where ba.num_carte_bapt like '%".$filter."%' 
            OR ba.nom_bapt like '%".$filter."%'
            OR ba.prenom_bapt like '%".$filter."%'";

        return $this->db->query($sql)->result();
    }

	public function getConfirmation($id){
		$sql="SELECT conf.id_confirmation, com.id_communion,  com.numero_communion, ba.num_carte_bapt, conf.num_confirmation, conf.professionConfirmation, 
			  conf.date_confirmation, ba.photo, ba.nom_bapt, ba.prenom_bapt, com.profession_communion, com.id_paroisse_communion, 
			  conf.nom_celebrant, conf.prenom_celebrant, ba.id_paroisse id_paroisse_bapteme, conf.id_lieu_conf, ba.date_naissance, ba.tel_fixe,
			  ba.tel_mob, ba.domicile_bapt, ba.email FROM confirmation conf
			  JOIN communion com ON com.id_communion=conf.id_communion
			  JOIN bapteme ba ON com.id_bapt = ba.id_bapt WHERE conf.id_confirmation=".$id."";

			return $this->db->query($sql)->row_array();
	}

}
