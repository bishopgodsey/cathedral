<?php 

class Marriage_model extends CI_Model {

    private $table_name = 'marriage';

    public function __construct () {

        parent::__construct();
    }

    public function save_marriage($data) {
    
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

    public function get_marriages() {
    
        $sql = "SELECT * FROM marriage";
        $data = $this->db->query($sql)->result_array(); 
        
        $this->load->model('personne_model');
        $this->load->model('bapteme_model');
        $this->load->model('institution_model');

        foreach($data as $key=>$d) {

            $husband = null;
            if($d['conjoint_id']) {
                $husband = $this->confirmation_model->getConfirmation($d['conjoint_id']); 
                $data[$key]['husband'] = ($husband)?$husband['nom_bapt'].' '.$husband['prenom_bapt']:''; 
            }else {
                
                $husband = $this->personne_model->find($d['no_catholique_conjoint_id']); 
                $data[$key]['husband'] = ($husband)?$husband->nom.' '.$husband->prenom:''; 
            }
 
            $wife = null;
            if($d['conjointe_id']) {
                $wife = $this->confirmation_model->getConfirmation($d['conjointe_id']);  
                $data[$key]['wife'] = ($wife)?$wife['nom_bapt'].' '.$wife['prenom_bapt']:''; 
            }else {
                
                $wife = $this->personne_model->find($d['no_catholique_conjointe_id']); 
                $data[$key]['wife'] = ($wife)?$wife->nom.' '.$wife->prenom:''; 
            }

            $parrain = null;
            if($d['parrain_id']) {
                $parrain = $this->confirmation_model->getConfirmation($d['parrain_id']);
                $data[$key]['parrain'] = ($parrain)?$parrain['nom_bapt'].' '.$parrain['prenom_bapt']:''; 
            }else {
                $parrain = $this->personne_model->find($d['no_catholique_parrain_id']);
                $data[$key]['parrain'] = ($parrain)?$parrain->nom.' '.$parrain->prenom:''; 
            }

            $marraine = null;
            if($d['marraine_id']) {
                $marraine = $this->confirmation_model->getConfirmation($d['marraine_id']);
                $data[$key]['marraine'] = ($marraine)?$marraine['nom_bapt'].' '.$marraine['prenom_bapt']:''; 
            }else{
                $marraine = $this->personne_model->find($d['no_catholique_marraine_id']); 
                $data[$key]['marraine'] = ($marraine)?$marraine->nom.' '.$marraine->prenom:''; 
            }

            $lieu = $this->institution_model->find($d['lieu_celebration_id']);
            
            $data[$key]['lieu'] = ($lieu)?$lieu->nom_institution:''; 
        }

        return $data;
    }

    public function search($filters) {
        $this->db->like($filters);

        return $this->db->get($this->table_name)->result();
    }
    
    public function suggest_marriage($filter) {
        $sql = "SELECT conf.id_confirmation,ba.num_carte_bapt,ba.nom_bapt, ba.prenom_bapt,ba.sexe_bapt,ba.date_naissance, ba.domicile_bapt, ba.tel_mob, ba.email,ba.photo 
            FROM confirmation conf 
            LEFT JOIN communion co on conf.id_communion = co.id_communion
            left join bapteme ba on ba.id_bapt = co.id_bapt 
            where ba.num_carte_bapt like '%".$filter."%' 
            OR ba.nom_bapt like '%".$filter."%'
            OR ba.prenom_bapt like '%".$filter."%'";

        return $this->db->query($sql)->result();
    }
	
	public function details($id_mariage){
		$this->db->where('marriage_id', $id_mariage);
		
		return $this->db->get($this->table_name)->row_array();
	}

}
