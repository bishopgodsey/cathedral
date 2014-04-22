<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class App {
/*
App library. Should contains application functionality globally accessible by all app modules
*/

	private $CI;
	
	public function __construct() {
	
		$this->CI = &get_instance();
		 
    }

    /*
     * Allows to get types of institutions
     * @ param null
     * @ return array of institutions. Indexes are based on the institution ids for better searching
     *
     */
    public function get_institution_types() {
        $this->CI->load->model('type_institution_model');

        $institution_types = $this->CI->type_institution_model->get_all();

        $type_institutions = array();

        foreach ($institution_types as $type) {
            $type_institutions[$type->id_type] = $type;

        }

        return $type_institutions;

    }

    /*
     * Allows to get an array of institutions based on the type provided as arguments.
     * @param int type
     * $return array Array as institutions.
     * Result are return as key values key being the id, and value being the institution name.
     * This is ideal for building dropdown list. For more info on insitution you should call 
     * a method in institution model
     */
    public function get_institutions_by_type($type) {
        
        $this->CI->load->model('institution_model');

        $institutions =  $this->CI->institution_model->get_by_type($type);
        $result = array();

        foreach($institutions as $institution) {
            $result[$institution->id_institution] = $institution->nom_institution;
        }
        
        return $result;
        
    }
	
	
}
