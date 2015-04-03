<?php 

class Bapteme_model extends CI_Model {

    private $table_name = 'bapteme';

    public function __construct () {

        parent::__construct();
    }

    public function save_bapteme($data) {
        $this->db->set('created_by',$this->auth->user_id());
        $this->db->set('created_on','NOW()',FALSE);

			if(empty($data['id_bapt']) or $data['id_bapt']=="" or $data['id_bapt']==0){
        $this->db->insert($this->table_name, $data);
			}else{
				 $this->db->update($this->table_name, $data, array (
					'id_bapt' => $data ['id_bapt'] ));
			}

        return (bool) $this->db->affected_rows();        

    }

    public function suggest_baptise($filter) {
    
        $sql = "SELECT ba.id_bapt,ba.num_carte_bapt,ba.nom_bapt, ba.prenom_bapt 
            FROM bapteme ba 
            where ba.num_carte_bapt like '%".$filter."%' 
            OR ba.nom_bapt like '%".$filter."%'
            OR ba.prenom_bapt like '%".$filter."%'";

        return $this->db->query($sql)->result();
    }
    public function get_all($filters = array()) {
        if(!empty($filters)) {
            $this->db->where($filters);
        }

		return $this->db->select('*')->from('bapteme')->join('institution', 'bapteme.id_paroisse=institution.id_institution')->get() ->result_array();

    }

    public function search($filters) {
        $this->db->like($filters);

        return $this->db->get($this->table_name)->result();
    }
    
    public function find($id) {
        $this->db->where('id_bapt',$id);

        return $this->db->get($this->table_name)->row();
    }

    public function details($id) {
        $sql = "SELECT b.id_bapt, b.id_categorie, b.num_carte_bapt, b.nom_bapt, b.prenom_bapt, b.date_bapt, b.date_naissance, b.sexe_bapt,b.nom_celebrant,b.contact,b.dateMariageParent,
        		 b.prenom_celebrant,b.id_lieu_bapteme,b.id_lieu_ministere,b.service, b.domicile_bapt,pere.nom_bapt nom_pere, pere.prenom_bapt prenom_pere, mere.nom_bapt nom_mere,
        		 mere.prenom_bapt prenom_mere, parrain.nom_bapt nom_parrain, parrain.prenom_bapt prenom_parrain, lb.nom_institution lieu_bapteme, min.nom_institution lieu_ministere,
        		 b.email, b.professionBapt, b.tel_fixe, b.tel_mob  FROM bapteme b
            LEFT JOIN bapteme pere on b.pere_id = pere.id_bapt
            LEFT JOIN bapteme mere on b.mere_id = mere.id_bapt
            LEFT JOIN bapteme parrain on b.parent_bapt_id = parrain.id_bapt
            LEFT JOIN institution lb on b.id_lieu_bapteme = lb.id_institution 
           LEFT JOIN institution min on b.id_lieu_ministere = min.id_institution 
            WHERE b.id_bapt = '".$id."'";

        return $this->db->query($sql)->row();
    }


}
