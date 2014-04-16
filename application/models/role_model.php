<?php 

class Role_model extends CI_Model {

    private $table_name = 'role';


    public function __construct() {
        parent::__construct();
    }

    public function get_all($filters=array()) {
    
        if(!empty($filters)) {
            $this->db->where($filters);
        }

        return $this->db->get($this->table_name)->result();
            
    }

    public function find($id) {
        $this->db->where('id_role',$id);
        
        return $this->db->get($this->table_name)->row();
    }

    public function save_role($data) {
    
        $this->db->insert($this->table_name,$data);

        return (bool) $this->db->affected_rows();
    }

    public function update_role($data) {
        
        $this->db->where('id_role',$data['id_role']);
        
        unset($data['id_role']);

        $this->db->update($this->table_name,$data);

        return true;
    }

    public function delete($id) {
        $this->db->where('id_role',$id);

        $this->db->delete($this->table_name);

        return (bool) $this->db->affected_rows();
    }

}
