<?php 

class Communion_model extends CI_Model {

    private $table_name = 'communion';

    public function __construct () {

        parent::__construct();
    }

    public function save_communion($data) {

        $this->db->set('created_by',$this->auth->user_id());
        $this->db->set('created_on','NOW()',FALSE);
		if(isset($data['id_communion']) AND $data['id_communion']!='' AND $data['id_communion']!=0){

		$this->db->where('id_communion', $data['id_communion']);

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

    public function get_communions() {

        $sql = "SELECT com.id_communion, ba.num_carte_bapt, com.date_communion, ba.photo, ba.nom_bapt, ba.prenom_bapt, com.id_paroisse_communion, ba.id_paroisse id_paroisse_bapteme, 
				com.id_lieu_communion FROM communion com
				JOIN bapteme ba ON com.id_bapt = ba.id_bapt";
        
        $data = $this->db->query($sql)->result_array(); 

        $this->load->model('institution_model');
        foreach($data as $key=>$d) {
            $parroisse_communion = $this->institution_model->find($d['id_paroisse_communion']);
            $parroisse_bapteme = $this->institution_model->find($d['id_paroisse_bapteme']);
			$lieu_communion=$this->institution_model->find($d['id_lieu_communion']);
            $data[$key]['parroisse_communion'] = $parroisse_communion->nom_institution; 
            $data[$key]['parroisse_bapteme'] = $parroisse_bapteme->nom_institution; 
			$data[$key]['lieu_communion']=$lieu_communion->nom_institution;
        }

        return $data;
    }

   public function search($filters) {

       $data=$this->db->select('*') ->from('bapteme') ->like('num_carte_bapt', $filters) ->or_like('nom_bapt', $filters) ->or_like('prenom_bapt', $filters) ->get()->result(); 

       return $data;
    }

	public function getCommunion($id){
		$sql="SELECT com.id_communion,  com.numero_communion, ba.id_bapt, ba.num_carte_bapt, com.date_communion, ba.photo, ba.nom_bapt, ba.prenom_bapt, 
			  com.profession_communion, com.id_paroisse_communion, ba.id_paroisse id_paroisse_bapteme, com.id_lieu_communion FROM communion com
			JOIN bapteme ba ON com.id_bapt = ba.id_bapt WHERE com.id_communion=".$id."";

			return $this->db->query($sql)->row_array();
	}
}
