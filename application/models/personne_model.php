<?php

class Personne_model extends CI_Model {


    private $table_name = 'personne';


    public function __construct() {

        parent::__construct();
    }

    /*
     * @param array $data : Data to be inserted in the databse
     * @return int inserted_id : The last inserted id to the database
     * As opposed to other methods, this method returns the last insert
     * record into the databse instead of just returning a boolean,
     * This is useful for other methods as this methode will be used 
     * within other methods
     */

    public function savePersonne($data) {
    
        $this->db->insert($this->table_name,$data);

        return $this->db->insert_id();
    }

    public function find($id) {
        $this->db->where('id_personne',$id);

        return $this->db->get($this->table_name)->row();
    }
}
