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
            $this->layout->add_js('utils');
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

    function suggestConfirmation($filters='') {

        $params = !empty($filters)?$filters:$this->input->get(NULL,TRUE);
        $this->load->model('confirmation_model'); 
        $raw_resutl = $this->confirmation_model->suggest_communion($params['key']);

        $result = array();
        foreach($raw_resutl as $raw) {
            $name = $raw->num_carte_bapt.'-'.$raw->nom_bapt.'-'.$raw->prenom_bapt;
            array_push($result, array('id'=>$raw->id_communion,'name'=>$name));  
        }

        echo json_encode($result);
        
    }

    public function saveBapteme($is_ajax = false) {
        
        $data = $this->input->post();
        $errors = array();
        unset($data['0']);
        
        if(!is_int($data['id_lieu_bapteme']) || empty($data['id_lieu_bapteme'])) {
            array_push($errors,'Veuillez selectionner le lieu de bapteme');    
        }

        unset($data['nom_pere']); 
        unset($data['nom_mere']); 
        unset($data['prenom_pere']); 
        unset($data['prenom_mere']); 
        unset($data['nom_parain']); 
        unset($data['prenom_parain']); 
        unset($data['lieu_bapt']); 
        unset($data['lieu_ministere']);

        $this->load->model('bapteme_model');
        $message = array();
        if( $this->bapteme_model->save_bapteme($data)) {
            $message['text'] = 'Le bapteme a bien ete enregistre';
            $message['type'] = 'error';

        }else {
            
            $message['text'] = 'Le bapteme a bien ete enregistre';
            $message['type'] = 'error';
        }

        echo json_encode($message);

    }

    public function saveConfirmation($is_ajax=false) {
        $data = $this->input->post();

        if(!$is_ajax) {
            $is_ajax = $data['ajax'];
        }
        unset($data['search']);
        unset($data['lieu_conf']);

        //TODO make same validations here
        $this->load->model('confirmation_model');

        $message = array();
        if($this->confirmation_model->save_confirmation($data)) {
            $message['text'] = 'La Confirmation a ete enregistre';
            $message['type'] = 'success';    
        }else {
            $messsage['text'] = 'Une erreur est survenue lors de l\'enregistrement.
                Reesayez SVP';
           $message['type'] = $is_ajax?'error':'danger'; 
        }

        if($is_ajax) {
            echo json_encode($message);
        }else {
            
            $this->session->set_flashdata('action_message',$message);

            redirect('sacrement/confirmations');
        }
    }

    public function saveCommunion($is_ajax=false) {
    
        $data = $this->input->post();
        
        if(!$is_ajax) {
            $is_ajax = $data['ajax'];
        }
        unset($data['search']);
        unset($data['lieu_conf']);

        //TODO make same validations here
        $this->load->model('communion_model');

        $message = array();
        if($this->communion_model->save_communion($data)) {
            $message['text'] = 'La communion a ete enregistre';
            $message['type'] = 'success';    
        }else {
            $messsage['text'] = 'Une erreur est survenue lors de l\'enregistrement. Reesayez SVP';
            $message['type'] = $is_ajax?'error':'danger'; 
        }

        if($is_ajax) {
            echo json_encode($message);
        }else {
            
            $this->session->set_flashdata('action_message',$message);

            redirect('sacrement/communions');
        }
    }

    public function communions() {
    
        // Restrict access to users with Confirmation.View (View Permission ) permission
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have right to view Communions'), 'Communion.View');

        // SB Admin CSS - Include with every page
        $this->layout->add_css('sb-admin');

        // SB Admin Scripts - Include with every page
        $this->layout->add_js('sb-admin');

        $this->load->model('communion_model');

        $communions = $this->communion_model->get_communions();

        $communions_columns = array('Photo','Num. Carte','Nom','Prenom','Date Communion',
            'Parroisse Communion','Parroisse Bapteme');

        if(has_permission('Communion.Edit') || has_permission('Communion.Delete')) {
            $communions_columns[] = 'Actions';  
        }

        $data['communions'] = $communions;
        $data['communions_columns'] = $communions_columns;
                
        $this->layout->view('communion_list',$data);
         
    }

    public function confirmations() {
            
        // Restrict access to users with Bapteme.View (View Permission ) permission
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have right to view Bapteme'), 'Confirmation.View');

        // SB Admin CSS - Include with every page
        $this->layout->add_css('sb-admin');

        // SB Admin Scripts - Include with every page
        $this->layout->add_js('sb-admin');
        //$this->layout->add_js('users_list');

        $this->load->model('confirmation_model');

        $confirmations = $this->confirmation_model->get_confirmations();

        $confirmation_columns = array('Photo','Num. Carte','Nom','Prenom','Date Confirmation',
            'Parroisse Confirmation','Parroisse Communion','Parroisse Bapteme');

        if(has_permission('Confirmation.Edit') || has_permission('Confirmation.Delete')) {
            $confirmation_columns[] = 'Actions';  
        }

        $data['confirmations'] = $confirmations;
        $data['confirmation_columns'] = $confirmation_columns;
                
        $this->layout->view('confirmation_list',$data);
    }

    public function createCommunion($is_ajax=false) {
    
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have the permission to add Communion'), 'Communion.Add');

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
            $this->load->view('communion_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin');
            $this->layout->add_css('bootstrap-datetimepicker.min');
            $this->layout->add_css('bootstrapValidator.min');

            $this->layout->add_js('moment.min');
            $this->layout->add_js('bootstrap-datetimepicker.min');
            $this->layout->add_js('bootstrapValidator.min');
            $this->layout->add_js('bootstrap-typeahead');
            $this->layout->add_js('chosen.jquery.min');
            // SB Admin Scripts - Include with every page
            $this->layout->add_js('sb-admin');
            $this->layout->add_js('utils');
            $this->layout->add_js('confirmation');

            $this->layout->view('communion_form',$data);
        }
    }

    public function createConfirmation($is_ajax=false) {
        
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have the permission to add Confirmation'), 'Confirmation.Add');

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
            $this->load->view('confirmation_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin');
            $this->layout->add_css('bootstrap-datetimepicker.min');
            $this->layout->add_css('bootstrapValidator.min');

            $this->layout->add_js('moment.min');
            $this->layout->add_js('bootstrap-datetimepicker.min');
            $this->layout->add_js('bootstrapValidator.min');
            $this->layout->add_js('bootstrap-typeahead');
            $this->layout->add_js('chosen.jquery.min');
            // SB Admin Scripts - Include with every page
            $this->layout->add_js('sb-admin');
            $this->layout->add_js('utils');
            $this->layout->add_js('confirmation');

            $this->layout->view('confirmation_form',$data);
        }
    }

    public function marriage() {
    
    }

    public function deces() {
    
        // Restrict access to users with Confirmation.View (View Permission ) permission
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have right to view Communions'), 'Deces.View');

        // SB Admin CSS - Include with every page
        $this->layout->add_css('sb-admin');

        // SB Admin Scripts - Include with every page
        $this->layout->add_js('sb-admin');

        $this->load->model('deces_model');

        $deces = $this->deces_model->get_deces();

        $deces_columns = array('Photo','Num. Enterement','Nom','Prenom','Date Naissance','Date Deces');

        if(has_permission('Deces.Edit') || has_permission('Deces.Delete')) {
            $deces_columns[] = 'Actions';  
        }

        $data['deces'] = $deces;
        $data['deces_columns'] = $deces_columns;
                
        $this->layout->view('deces_list',$data);
    }

    function createDeces($is_ajax=false) {

        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have the permission to add Communion'), 'Deces.Add');

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
            $this->load->view('deces_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin');
            $this->layout->add_css('bootstrap-datetimepicker.min');
            $this->layout->add_css('bootstrapValidator.min');

            $this->layout->add_js('moment.min');
            $this->layout->add_js('bootstrap-datetimepicker.min');
            $this->layout->add_js('bootstrapValidator.min');
            $this->layout->add_js('bootstrap-typeahead');
            $this->layout->add_js('chosen.jquery.min');
            // SB Admin Scripts - Include with every page
            $this->layout->add_js('sb-admin');
            $this->layout->add_js('utils');
            $this->layout->add_js('confirmation');

            $this->layout->view('deces_form',$data);
        }

    }

} 
