<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Institution extends CI_Controller {

	/**
	 * Eglise Controller
	 *
	 * This controller is used for all "Eglise Operations"
	 */

    private $institution_types = array();

	public function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->library('layout');
        $this->load->helper('form');
        $this->load->model(array('institution_model'));

        $this->institutions_type = $this->app->get_institution_types();
	}

    public function index() {
        echo 'list all institutions';
    }


	public function type($type='')
	{

        //restrict access to users with Institutions.View permission        
        $warning = array('type'=>'warning',
            'text'=>'You dont have permission to view inistitutions');

        $this->auth->restrict($warning,'Institutions.View');
        if(!$type) {
            $this->index();
            return;
        }
         
        // SB Admin CSS - Include on every page
        $this->layout->add_css('sb-admin');
        
        // SB Admin Scripts - Include with every page
        $this->layout->add_js('sb-admin');

        // get all institution by the type requested 
        $institutions = $this->institution_model->get_by_type($type);
        $data['institutions'] = $institutions;

        //find the institution type string for display in the view
        $institution_type = $this->institutions_type[$type];
        $data['institution_type'] = $institution_type;
        
        $parent = $institution_type->parent;

        $parent_institution_type = null;
        $parent_institutions = array();
        
        if($parent) {
            $parent_institution_type = $this->institutions_type[$parent];
            $parent_institutions = $this->app->get_institutions_by_type($parent_institution_type->id_type);
        }
	    // define institution columns. May be i should find a better way to do 
        // this.	
        $institution_columns = array('Institution');

        if($parent_institution_type && $parent_institution_type->nom_type) {
            $institution_columns[] = $parent_institution_type->nom_type;
        }
        
        $institution_columns[] = 'Nom Responsable';
        $institution_columns[] = 'Prenom Responsable';

        if(has_permission('Institutions.Edit') || has_permission('Institutions.Delete')) {
            $institution_columns[] = 'Actions';  
        }

        $data['institution_columns'] = $institution_columns;
        $data['parent_institutions'] = $parent_institutions;    
		
		$this->layout->view('institution_list',$data);
    }

    public function create($type, $is_ajax=0) {
     
        
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have the permission to create an institution'), 'Institutions.Add');
        
        $data['ajax'] = $is_ajax;
        
        //find the institution type string for display in the view
        $institution_type = $this->institutions_type[$type];

        $parent = $institution_type->parent;

        $parent_institution_type = null;
        $parent_institutions = array();
        
        if($parent) {
            $parent_institution_type = $this->institutions_type[$parent];
            $parent_institutions = $this->app->get_institutions_by_type($parent_institution_type->id_type);
        }

        $data['institution_type'] = $institution_type;

        $data['parent_institution_type'] = $parent_institution_type; 

        $data['parent_institutions'] = $parent_institutions;

        if($is_ajax) {
            $this->load->view('institution_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin');
        
            // SB Admin Scripts - Include with every page
            $this->layout->add_js('sb-admin');
            $this->layout->view('institution_form',$data);
        }

    }

    public function edit($type, $institution_id, $is_ajax=0) {

        
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have the permission to edit an institution'), 'Institutions.Edit');
        
        $data['ajax'] = $is_ajax;

        $institution = $this->institution_model->find($institution_id);
       
        $data['institution'] = $institution;
        
        //find the institution type string for display in the view
        $institution_type = $this->institutions_type[$type];

        $parent = $institution_type->parent;

        $parent_institution_type = null;
        $parent_institutions = array();
        
        if($parent) {
            $parent_institution_type = $this->institutions_type[$parent];
            $parent_institutions = $this->app->get_institutions_by_type($parent_institution_type->id_type);
        }

        $data['institution_type'] = $institution_type;

        $data['parent_institution_type'] = $parent_institution_type; 

        $data['parent_institutions'] = $parent_institutions;

        if($is_ajax) {
            $this->load->view('institution_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin');
        
            // SB Admin Scripts - Include with every page
            $this->layout->add_js('sb-admin');
            $this->layout->view('institution_form',$data);
        }
    }

    public function delete($type, $id, $is_ajax=0) {
        
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have the permission to delete an institution'), 'Institutions.Delete');
        
        $data['ajax'] = $is_ajax;

        $message = array();

        $institution_type = $this->institutions_type[$type];
        $institution_type_name = $institution_type->nom_type;

        if($this->institution_model->delete($id)) {
            $message['type'] = 'success';
            $message['text'] = $institution_type_name.' has been deleted Successfully';
        }else {
            $message['type'] = ($is_ajax)?'error':'danger';
            $message['text'] = 'An error occured while deleting '.$institution_type_name;

        }
        
        if($is_ajax) {
            echo json_encode($message);
        }else {
            $this->session->set_flashdata('action_message',$message);

            redirect('institution/type/'.$type);
        }

    }

    public function saveInstitution($type) {
        
        $institution_id = $this->input->post('id_institution');
    
        $is_ajax = $this->input->post('ajax');
        
        $this->load->library('form_validation');
        
        $config = array(
            array('field'=>'nom_institution',
                  'label'=>'Institution Name',
                  'rules'=>'required')
              );
        
        $this->form_validation->set_rules($config);
        
        if($this->form_validation->run()===FALSE) {
           $this->create($type,$is_ajax); 
        }else {
            $this->load->model('institution_model');
            
            $data = $this->input->post();
            $data['id_type'] = $type; 
            //find the institution type string for display in the view
            $institution_type = $this->institutions_type[$type];
            
            $institution_type_name = $institution_type->nom_type; 
            
            $message = array();
            if(empty($institution_id)) {
                if($this->institution_model->save_institution($data)) {
                    $message['type'] = 'success';
                    $message['text'] = $institution_type_name.' created Successfully';
                }else {
                    $message['type'] = $is_ajax?'error':'danger';
                    $message['text'] = 'An error occured while creating '.$institution_type_name.' . Please try again';
                }
            
            }else {
                
                if($this->institution_model->update_institution($data)) {
                    
                    $message['type'] = 'success';
                    $message['text'] = $institution_type_name.' updated successfully';
                }else {
                    
                    $message['type'] = $is_ajax?'error':'danger';
                    $message['text'] = 'An error occured while creating '.$institution_type_name.' . Please try again';
                }
            }

            if($is_ajax) {
                echo json_encode($message);
            }else {
                $this->session->set_flashdata('action_message',$message);

                redirect('institution/type/'.$type);
            }
        }    
    
    }
}
