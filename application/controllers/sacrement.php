<?php 
class Sacrement extends CI_Controller {

    public function __construct() {
    
        parent::__construct();
        $this->auth->restrict();
        $this->load->library('layout');
        $this->load->helper('form');
    }

    public function index() {
        echo 'listing all sacrements';  
    }

    public function bapteme() {
                 
        // Restrict access to users with Bapteme.View (View Permission ) permission
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have right to view Bapteme'), 'Bapteme.View');

        // SB Admin CSS - Include with every page
        $this->layout->add_css('sb-admin');

        // SB Admin Scripts - Include with every page
        $this->layout->add_js('sb-admin');
        //$this->layout->add_js('users_list');

        $this->load->model('bapteme_model');

        $baptemes = $this->bapteme_model->get_all();

        $bapteme_columns = array('Num. Carte','Photo','Nom','Prenom','Date Bapteme', 'Parent spirituelle','Institution');

        if(has_permission('Bapteme.Edit') || has_permission('Bapteme.Delete')) {
            $bapteme_columns[] = 'Actions';  
        }

        $data['baptemes'] = $baptemes;
        $data['bapteme_columns'] = $bapteme_columns;
                
        $this->layout->view('bapteme_list',$data);
    }

    public function createBapteme($is_ajax=0) {
        
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have the permission to create Bapteme'), 'Bapteme.Add');

        $data['ajax'] = $is_ajax;
        $this->load->model('institution_model');

        $dioceses = $this->institution_model->get_by_type(1);

        $parroisses = array();

        foreach($dioceses as $diocese) {

            $parroisses[$diocese->id_institution] = $this->institution_model->get_all(array('parent_id'=>$diocese->id_institution)); 
        }

        $data['parroisses'] = $parroisses;

        $data['dioceses'] = $dioceses;

        if($is_ajax) {
            $this->load->view('bapteme_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin');
            $this->layout->add_css('bootstrap-datetimepicker.min');
            $this->layout->add_css('bootstrapValidator.min');
            $this->layout->add_css('chosen.min');

            // SB Admin Scripts - Include with every page
            $this->layout->add_js('moment.min');
            $this->layout->add_js('bootstrap-datetimepicker.min');
            $this->layout->add_js('bootstrapValidator.min');
            $this->layout->add_js('jquery.bootstrap.wizard.min');
            $this->layout->add_js('bootstrap-typeahead');
            $this->layout->add_js('chosen.jquery.min');
            $this->layout->add_js('sb-admin');
            $this->layout->add_js('bapteme');
            $this->layout->view('bapteme_form',$data);
        }
            
    }

    public function suggestParents($filters='') {
        $params = !empty($filters)?$filters:$this->input->get(NULL,TRUE);

        $filters = array();
        $filters[$params['field']] = $params['input'];
        unset($params['field']); 
        unset($params['input']);
        
        $params = array_merge($params, $filters);

        $this->load->model('bapteme_model');

        $raw_result = $this->bapteme_model->search($params);
        $result = array();

        foreach($raw_result as $row) {
            $name = $row->num_carte_bapt.' - '.$row->nom_bapt.' '.$row->prenom_bapt;
            array_push($result, array('id'=>$row->id_bapt,'name'=>$name));     
        }
        echo json_encode($result);

    }

    public function suggestInstitutions($filters='') {
                 
        $params = !empty($filters)?$filters:$this->input->get(NULL,TRUE);

        $filters = array();
        $filters[$params['field']] = $params['input'];
        unset($params['field']); 
        unset($params['input']);

        $params = array_merge($params, $filters);
        $this->load->model('institution_model');
        $raw_resutl = $this->institution_model->get_institutions_with_parent($params);

        $result = array();
        foreach($raw_resutl as $raw) {
            $name = $raw->nom_institution;
            if($raw->parent)
                $name.= ' - '.$raw->parent;
          array_push($result, array('id'=>$raw->id_institution,'name'=>$name));  
        }

        echo json_encode($result);
    }

    public function communion() {
    
    }

    public function confirmation() {
    
    }

    public function marriage() {
    
    }

    public function deces() {
    
    }

} 
