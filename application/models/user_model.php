<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User Model
 * Central way for accessing CRUD ON Users
 */
class User_model extends CI_Model
{

	private $table_name = 'users';

	public function __construct() {
		parent::__construct();
	}

	public function get_user_by_id($user_id) {

		$data = $this->db->where('id',$user_id)->get($this->table_name)->row();

		return $data;
	}

	public function get_user_by_credentials($user_name, $password) {
		$filters = array('username'=>$user_name,'password_hash'=>$password);

		$data = $this->db->where($filters)->get($this->table_name)->row();

		return $data;
	}

	public function get_all($filters = array()) {
		if(!empty($filters)) {
			$this->db->where($filters);
		}

		return $this->db->get($this->table_name)->result();
	}

	public function save_user($data) {

		$this->db->set('created_on','NOW()',false);
		$this->db->insert($this->table_name, $data);

		return (bool) $this->db->affected_rows();
	}

	public function delete($user_id) {
		$this->db->where('id',$user_id);

		$this->db->delete($this->table_name);

		return (bool) $this->db->affected_rows();
	}


  public function update_user($data) {

      $this->db->where('id',$data['id']);
      unset($data['id']);
      $this->db->update($this->table_name,$data);

      return true; // (bool) $this->db->affected_rows();

  }
}//end User_model
