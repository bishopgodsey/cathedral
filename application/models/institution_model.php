<?php

class Institution_model extends CI_Model {

    private $table_name = 'institution';

    public function __construct() {

        parent::__construct();
    }

    public function get_by_type($type) {

        $this->db->where('id_type',$type); 
        return $this->db->get($this->table_name)->result();    
        
    }

    public function get_all($filters) {
        if(!empty($filters))
            $this->db->where($filters);

        return $this->db->get($this->table_name)->result(); 
    }

    public function find($id) {
        $this->db->where('id_institution',$id);

        return $this->db->get($this->table_name)->row();
    }

    public function save_institution($data) {
        
        $this->db->set('created_by',$this->auth->user_id());
        $this->db->set('created_on','NOW()',FALSE);

        $this->db->insert($this->table_name, $data);

        return (bool) $this->db->affected_rows();        

    }

    public function update_institution($data) {

        $this->db->set('modified_by',$this->auth->user_id());
        $this->db->set('modified_on','NOW()',FALSE);
        
        $this->db->where('id_institution',$data['id_institution']);
        unset($data['id_institution']);

        $this->db->update($this->table_name, $data);

        return true;
    }

    public function delete($id) {
        
        $this->db->where('id_institution',$id);
        $this->db->delete($this->table_name);
        return (bool) $this->db->affected_rows();

    }
    public function get_institutions_with_parent($filters) {

        $query = $this->db->select('c.id_institution,c.nom_institution,p.nom_institution parent')
            ->from('institution c')
            ->join('institution p','c.parent_id = p.id_institution','left')
            ->like('c.nom_institution',$filters['nom_institution'])
            ->get();
       return $query->result(); 
    }
}
