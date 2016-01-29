<?php 
class Sacrement extends CI_Controller {

    public function __construct() {
    
        parent::__construct();
		$this->load->model('bapteme_model');
		$this->load->model('communion_model');
		$this->load->model('confirmation_model');
		$this->load->model('deces_model');
		$this->load->model('institution_model');
		$this->load->model('marriage_model');
		$this->load->model('personne_model');
        $this->auth->restrict();
        $this->load->library('layout');
        $this->load->helper('form');
    }

    public function index() {
        echo 'listing all sacrements';  
    }

    public function savePersonne($is_ajax=false) {

        $this->load->model('personne_model');
        $data = $this->input->post();

        $message = array();

        $inserted_id = $this->personne_model->savePersonne($data);

        $result = array();
        if($inserted_id > 0 ) { 
            $message['type']='success';
            $message['text'] = 'Bien enregistre!';

            $result['personne_id'] = $inserted_id;
            $result['message'] = $message;
        }else {

            $message['type'] = 'error';
            $message['text'] = 'An error occured';
            $result['personne_id'] = '';
            $result['message'] = $message;
        }

        if($is_ajax) {
            echo json_encode($result); 
        }else {
            echo '<pre>';
                print_r($message);
            echo '</pre>';
        }
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

        $bapteme_columns = array('Cert. Number','Photo','Name','Surname','Date of Baptism', 'Parent spirituelle','Parish of Baptism', '
Place of baptism');

        if(has_permission('Bapteme.Edit') || has_permission('Bapteme.Delete')) {
            $bapteme_columns[] = 'Actions';  
        }

        $data['baptemes'] = $baptemes;
        $data['bapteme_columns'] = $bapteme_columns;

		for($i=0; $i<count($baptemes); $i++){
				$lieu_bapteme=$this->institution_model->find($baptemes[$i]['id_lieu_bapteme']); 
				$data['baptemes'][$i]['lieu_bapteme']=$lieu_bapteme->nom_institution;

		}

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

    public function suggestMarriage($filters='') {
        
        $params = !empty($filters)?$filters:$this->input->get(NULL,TRUE);
        $this->load->model('marriage_model'); 
        $raw_resutl = $this->marriage_model->suggest_marriage($params['input']);

        $result = array();
        foreach($raw_resutl as $raw) {
            $name = $raw->num_carte_bapt.'-'.$raw->nom_bapt.'-'.$raw->prenom_bapt;
            array_push($result, array('id'=>json_encode($raw),'name'=>$name));  
        }

        echo json_encode($result);
    }

	function suggestCommunion($filters){
		 $params = !empty($filters)?$filters:$this->input->get(NULL,TRUE);
		 $this->load->model('communion_model');

		 $row_result=$this->communion_model->search($params['key']);

		 $result=array();
		 foreach ($row_result as $row) {
			 $name = $row->num_carte_bapt.'-'.$row->nom_bapt.'-'.$row->prenom_bapt;
             array_push($result, array('id'=>$row->id_bapt,'name'=>$name));
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

    function suggestBaptise($filters='') {
    
        $params = !empty($filters)?$filters:$this->input->get(NULL,TRUE);
        
        $this->load->model('bapteme_model'); 
        $raw_resutl = $this->bapteme_model->suggest_baptise($params['key']);

        $result = array();
        foreach($raw_resutl as $raw) {
            $name = $raw->num_carte_bapt.'-'.$raw->nom_bapt.'-'.$raw->prenom_bapt;
            array_push($result, array('id'=>$raw->id_bapt,'name'=>$name));  
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
            $message['text'] = 'Le bapteme a été bien  enregistré';
            $message['type'] = 'error';
			redirect('sacrement/bapteme');
        }else {
            
            $message['text'] = 'Le bapteme n\'a pas été enregistré';
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
        unset($data['lieu_comm']);

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
            'Parroisse Communion','Parroisse Bapteme', 'Lieu de Communion');

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
            'Parroisse Confirmation','Parroisse Communion','Parroisse Bapteme', 'Lieu de confirmation');

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
            $this->layout->add_js('communion');

            $this->layout->view('communion_form',$data);
        }
    }

	public function editCommunion($id_communion){
		$data=$this->communion_model->getCommunion($id_communion);


		$is_ajax=false;
		$data['ajax'] = $is_ajax;
		$data['search']=$data['numero_communion'].'-'.$data['nom_bapt'].'-'.$data['prenom_bapt'];

		$this->load->model('institution_model');
        $dioceses = $this->institution_model->get_by_type(1);

        $parroisses = array();

        foreach($dioceses as $diocese) {

            $parroisses[$diocese->id_institution] = $this->institution_model->get_all(array('parent_id'=>$diocese->id_institution)); 
        }
		$data['parroisses'] = $parroisses;

		$paroisse_communion=$this->institution_model->find($data['id_paroisse_communion']);
		$data['nom_paroisse_communion']=$paroisse_communion->nom_institution;

        $data['dioceses'] = $dioceses;
		$lieu_com=$this->institution_model->find($data['id_lieu_communion']);
		$data['lieu_comm']=$lieu_com->nom_institution;


		if($is_ajax) {
			$this->layout->add_js('communion');
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
            $this->layout->add_js('communion');

            $this->layout->view('communion_form',$data);
        }
	}

    public function createConfirmation($is_ajax=false) {
        
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have the permission to add Confirmation'), 'Confirmation.Add');
		$data['confirmation']['num_carte_bapt']="";	$data['confirmation']['nom_bapt']="";	$data['confirmation']['prenom_bapt']="";
		$data['confirmation']['num_confirmation']="";	$data['confirmation']['professionConfirmation']="";	$data['confirmation']['date_confirmation']="";
		$data['confirmation']['nom_celebrant']="";	$data['confirmation']['prenom_celebrant']="";
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

	public function editBapteme($id_Bapteme, $is_ajax=false){
		$data['bapteme']=$this->bapteme_model->details($id_Bapteme);

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

		$lieu_ministere=$this->institution_model->find($data['bapteme']->id_lieu_ministere);
		$data['bapteme']->id_lieu_ministere=$lieu_ministere->nom_institution;

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


	public function editConfirmation($id_confirmation){
		$data['confirmation']=$this->confirmation_model->getConfirmation($id_confirmation);

		$is_ajax=false;
		$data['ajax'] =$is_ajax;

		$this->load->model('institution_model');
        $dioceses = $this->institution_model->get_by_type(1);

        $parroisses = array();

        foreach($dioceses as $diocese) {

            $parroisses[$diocese->id_institution] = $this->institution_model->get_all(array('parent_id'=>$diocese->id_institution)); 
        }

        $data['parroisses'] = $parroisses;

        $data['dioceses'] = $dioceses;

		$lieu_conf=$this->institution_model->find($data['confirmation']['id_lieu_conf']);
		$data['confirmation']['lieu_conf']=$lieu_conf->nom_institution;

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
    
        // Restrict access to users with Confirmation.View (View Permission ) permission
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have right to view Marriages'), 'Marriage.View');

        // SB Admin CSS - Include with every page
        $this->layout->add_css('sb-admin');

        // SB Admin Scripts - Include with every page
        $this->layout->add_js('sb-admin');

        $this->load->model('marriage_model');

        $marriages = $this->marriage_model->get_marriages();

        $marriage_columns = array('Num Marriage','Mari','Epouse','Parrain','Marraine',
            'Date Marriage');

        if(has_permission('Marriage.Edit') || has_permission('Marriage.Delete')) {
            $marriage_columns[] = 'Actions';  
        }

        $data['marriages'] = $marriages;
        $data['marriage_columns'] = $marriage_columns;
                
        $this->layout->view('marriage_list',$data);
    }

    public function createMarriage($is_ajax = false) {
        
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have the permission to add marriages'), 'Marriage.Add');
		$data['husband']="";	$data['conjoint_id']=""; $data['husband_name']=""; $data['husband_surname']="";
		$data['husband_date_naissance']=""; $data['husband_email']="";$data['husband_tel']="";$data['husband_domicile_bapt']="";
		$data['nom_celebrant']=""; $data['prenom_celebrant']="";

		$data['wife']=""; $data['wife_name']=""; $data['wife_surname']=""; $data['wife_date_naissance']=""; $data['wife_email']="";
		$data['wife_tel']=""; $data['wife_email']=""; $data['wife_domicile_bapt']="";

		$data['marriage_id']="";
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
            $this->load->view('marriage_form',$data);
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
            $this->layout->add_js('marriage');
            $this->layout->view('marriage_form',$data);
        }
    }


    public function saveMarriage($is_ajax=false) {

        $this->load->model(array('personne_model','marriage_model'));
        $data = $this->input->post();

        $is_mari_catholic = $data['type_personne']==='chretien';   
        $is_epouse_catholic = $data['type_personne5']==='chretien';   
        $is_parrain_catholic = $data['type_personne2']==='chretien';   
        $is_marraine_catholic = $data['type_personne3']==='chretien';

        $marriage = array();
        $marriage['num_marriage'] = $data['num_marriage'];
        $marriage['date_marriage'] = $data['date_marriage'];
        $marriage['nom_celebrant'] = $data['nom_celebrant'];
        $marriage['prenom_celebrant'] = $data['prenom_celebrant'];
        $marriage['id_lieu_ministere'] = $data['id_lieu_ministere'];
        $marriage['diocese_id'] = $data['id_diocese'];
        $marriage['parroisse_id'] = $data['id_paroisse'];
        $marriage['lieu_celebration_id'] = $data['lieu_celebration_id'];
		$marriage['service']=$data['service'];

        if($is_mari_catholic) {
           $marriage['conjoint_id'] = $data['conjoint_id'];      
        }else {
            $mari_data = array();
            $mari_data['nom'] = $data['nom'];
            $mari_data['prenom'] = $data['prenom'];
            $mari_data['sexe'] = $data['sexe'];
            $mari_data['date_naissance'] = $data['date_naissance'];
            $mari_data['adresse'] = $data['adresse'];
            $mari_data['tel'] = $data['tel'];
            $mari_data['email'] = $data['email'];
            $mari_data['religion'] = 'No Catholique';

            $marriage['no_catholique_conjoint_id'] = $this->personne_model->savePersonne($mari_data);
        }

        if($is_epouse_catholic) {
            $marriage['conjointe_id'] = $data['conjointe_id'];            
        }else {
            $epouse_data = array();
            $epouse_data['nom'] = $data['nom_epouse'];
            $epouse_data['prenom'] = $data['prenom_epouse'];
            $epouse_data['sexe'] = $data['sexe_epouse'];
            $epouse_data['date_naissance'] = $data['date_naissance_epouse'];
            $epouse_data['adresse'] = $data['adresse_epouse'];
            $epouse_data['tel'] = $data['tel_epouse'];
            $epouse_data['email'] = $data['email_epouse'];
            $epouse_data['religion'] = 'No Catholique';
            
            $marriage['no_catholique_conjointe_id'] = $this->personne_model->savePersonne($epouse_data);
        }
        
        if($is_parrain_catholic) {
            $marriage['parrain_id'] = $data['parrain_id'];
        }else {
            $parrain_data = array();
            $parrain_data['nom'] = $data['nom_parrain'];
            $parrain_data['prenom'] = $data['prenom_parrain'];
            $parrain_data['sexe'] = $data['sexe_parrain'];
            $parrain_data['date_naissance'] = $data['date_naissance_parrain'];
            $parrain_data['adresse'] = $data['adresse_parrain'];
            $parrain_data['tel'] = $data['tel_parrain'];
            $parrain_data['email'] = $data['email_parrain'];
            $parrain_data['religion'] = 'No Catholique';
            
            $marriage['no_catholique_parrain_id'] = $this->personne_model->savePersonne($parrain_data);
        }

        if($is_marraine_catholic) {
            $marriage['marraine_id'] = $data['marraine_id'];
        }else {
            $marraine_data = array();
            $marraine_data['nom'] = $data['nom_marraine'];
            $marraine_data['prenom'] = $data['prenom_marraine'];
            $marraine_data['sexe'] = $data['sexe_marraine'];
            $marraine_data['date_naissance'] = $data['date_naissance_marraine'];
            $marraine_data['adresse'] = $data['adresse_marraine'];
            $marraine_data['tel'] = $data['tel_marraine'];
            $marraine_data['email'] = $data['email_marraine'];
            $marraine_data['religion'] = 'No Catholique';
            
            $marriage['no_catholique_marraine_id'] = $this->personne_model->savePersonne($marraine_data);
        }

        unset($data);

        $message = array();
        if($this->marriage_model->save_marriage($marriage)) {
           $message['text'] = 'Le marriage a ete enregistre'; 
           $message['type'] = 'success'; 
        }else {
            $message['text'] = 'Le marriage a ete enregistre'; 
            $message['type'] = $is_ajax?'error':'danger'; 
        }
        
        if($is_ajax) {
            echo json_encode($message);
        }else {
            
            $this->session->set_flashdata('action_message',$message);

            redirect('sacrement/marriage');
        }
    }

	public function editMarriage($id_mariage){
		//$this->load->model(array('personne_model','marriage_model'));
		$this->load->model('marriage_model');
		//echo "mariage:".$id_mariage."<br/>";
		$data=$this->marriage_model->details($id_mariage);
		//echo "<pre>"; print_r($data); //exit;
			$is_ajax=false;
			$data['ajax'] =$is_ajax;


		//Si le mari est catholique
		if($data['conjoint_id']!=''){
			$husband = $this->confirmation_model->getConfirmation($data['conjoint_id']);
			$data['husband']=$husband['num_carte_bapt'].'-'.$husband['nom_bapt'].'-'.$husband['prenom_bapt'];
			$data['husband_name']=$husband['nom_bapt']; $data['husband_surname']=$husband['prenom_bapt']; 
			$data['husband_date_naissance']=$husband['date_naissance']; $data['husband_email']=$husband['email'];
			$data['husband_tel']=$husband['tel_fixe'].'/'.$husband['tel_mob'];
			$data['husband_domicile_bapt']=$husband['domicile_bapt'];
			//echo "<pre>"; print_r($husband);
		}else{
			 $husband = $this->personne_model->find($data['no_catholique_conjoint_id']); 
             $data['husband']=$husband->nom.' '.$husband->prenom;
			$data['husband_name']=$husband->nom; $data['husband_surname']=$husband->prenom;
			$data['husband_date_naissance']=$husband->date_naissance; $data['husband_email']=$husband->email;
			$data['husband_tel']=$husband->tel;
			$data['husband_domicile_bapt']=$husband->adresse;
		}

		//Si la femme est catholique
		if($data['conjointe_id']!=''){
			$wife = $this->confirmation_model->getConfirmation($data['conjointe_id']); //echo "<pre>"; print_r($wife); exit;
			$data['wife']=$wife['num_carte_bapt'].'-'.$wife['nom_bapt'].'-'.$wife['prenom_bapt'];
			$data['wife_name']=$wife['nom_bapt']; $data['wife_surname']=$wife['prenom_bapt']; 
			$data['wife_date_naissance']=$wife['date_naissance']; $data['wife_email']=$wife['email'];
			$data['wife_tel']=$wife['tel_fixe'].'/'.$wife['tel_mob'];
			$data['wife_domicile_bapt']=$wife['domicile_bapt'];
		}else{
			$wife = $this->personne_model->find($data['no_catholique_conjointe_id']);   
            $data['wife']=$wife->nom.' '.$wife->prenom;
			$data['wife_name']=$wife->nom; $data['wife_surname']=$wife->prenom;
			$data['wife_date_naissance']=$wife->date_naissance; $data['wife_email']=$wife->email;
			$data['wife_tel']=$wife->tel;
			$data['wife_domicile_bapt']=$wife->adresse;
		}

		//Si le parrain est catholique
		if($data['parrain_id']!=''){
			$godfather=$this->confirmation_model->getConfirmation($data['parrain_id']);
			$data['godfather']=$godfather['num_carte_bapt'].'-'.$godfather['nom_bapt'].'-'.$godfather['prenom_bapt'];
			$data['godfather_name']=$godfather['nom_bapt']; $data['godfather_surname']=$godfather['prenom_bapt']; 
			$data['godfather_date_naissance']=$godfather['date_naissance']; $data['godfather_email']=$godfather['email'];
			$data['godfather_tel']=$godfather['tel_fixe'].'/'.$godfather['tel_mob'];
			$data['godfather_domicile_bapt']=$godfather['domicile_bapt'];
		}else{
			$godfather=$this->personne_model->find($data['no_catholique_parrain_id']);
			$data['godfather']=$godfather->nom.' '.$godfather->prenom;
			$data['godfather_name']=$godfather->nom; $data['godfather_surname']=$godfather->nom; 
			$data['godfather_date_naissance']=$godfather->date_naissance; $data['godfather_email']=$godfather->email;
			$data['godfather_tel']=$godfather->tel;
			$data['godfather_domicile_bapt']=$godfather->adresse;
		}

		//Si la marraine est catholique
		if($data['marraine_id']!=''){
			$godmother=$this->confirmation_model->getConfirmation($data['marraine_id']);
			$data['godmother']=$godmother['num_carte_bapt'].'-'.$godmother['nom_bapt'].'-'.$godmother['prenom_bapt'];
			$data['godmother_name']=$godmother['nom_bapt']; $data['godmother_surname']=$godmother['prenom_bapt']; 
			$data['godmother_date_naissance']=$godmother['date_naissance']; $data['godmother_email']=$godmother['email'];
			$data['godmother_tel']=$godmother['tel_fixe'].'/'.$godmother['tel_mob'];
			$data['godmother_domicile_bapt']=$godmother['domicile_bapt'];
		}else{
			$godmother=$this->personne_model->find($data['no_catholique_marraine_id']);
			$data['godmother']=$godmother->nom.' '.$godmother->prenom;
			$data['godmother_name']=$godmother->nom; $data['godmother_surname']=$godmother->prenom; 
			$data['godmother_date_naissance']=$godmother->date_naissance; $data['godmother_email']=$godmother->email;
			$data['godmother_tel']=$godmother->tel;
			$data['godmother_domicile_bapt']=$godmother->adresse;
		}

		$lieu_celebration=$this->institution_model->find($data['lieu_celebration_id']); //echo "<pre>"; print_r($lieu_celebration);
		$data['lieu_marriage']=$lieu_celebration->nom_institution;
		$lieu_ministere_celebrant=$this->institution_model->find($data['id_lieu_ministere']);
		$data['lieu_ministere']= $lieu_ministere_celebrant->nom_institution;


			$dioceses = $this->institution_model->get_by_type(1);

        $parroisses = array();

        foreach($dioceses as $diocese) {

            $parroisses[$diocese->id_institution] = $this->institution_model->get_all(array('parent_id'=>$diocese->id_institution)); 
        }

        $data['parroisses'] = $parroisses;

        $data['dioceses'] = $dioceses;
			 if($is_ajax) {
            $this->load->view('marriage_form',$data);
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
            $this->layout->add_js('marriage');
            $this->layout->view('marriage_form',$data);
        }

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

    public function createDeces($is_ajax=false) {

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
            $this->layout->add_js('deces');

            $this->layout->view('deces_form',$data);
        }

    }

    public function saveDeces($is_ajax = false) {

        $errors = array();

        $data = $this->input->post();

        $this->load->library('form_validation');

        $config = array(
                array(
                    'field' => 'id_bapt',
                    'label' => 'Une personne',
                    'rules' => 'callback_check_baptise'
                ),
                array(
                    'field' => 'id_nonBaptise',
                    'label' => 'Une personne',
                    'rules' => 'callback_check_non_baptise'
                ),
               array(
                     'field'   => 'num_enterrement', 
                     'label'   => 'Numero d\'enterrement', 
                     'rules'   => 'required|trim'
                  ),
               array(
                     'field'   => 'date_deces', 
                     'label'   => 'Date de deces', 
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'date_enterrement', 
                     'label'   => 'Date d\'enterrement', 
                     'rules'   => 'required'
                  ),   
               array(
                     'field'   => 'id_diocese', 
                     'label'   => 'Diocese', 
                     'rules'   => 'required|is_natural'
                  ),
                array(
                    'field' => 'id_paroisse',
                    'label' => 'Parroisse',
                    'rules'=>'required'
                ),
                array(
                    'field' => 'lieu_cel',
                    'label' => 'Lieu',
                    'rules'=>'required|required'
                ),
                array(
                    'field' => 'nom_celebrant',
                    'label' => 'Nom Celebrant',
                    'rules'=>'required'
                ),
                array(
                    'field' => 'prenom_celebrant',
                    'label' => 'Prenom Celebrant',
                    'rules'=>'required'
                )
            );

        $this->form_validation->set_rules($config);
        
        if($this->form_validation->run()===FALSE) {
        
            $this->createDeces($is_ajax);
        }else {
            
            $id_bapteme = $data['id_bapt'];
            $id_personne = $data['id_nonBaptise'];
            $type = $data['type_personne'];

            unset($data['search']);
            unset($data['lieu_cel']);
            unset($data['type_personne']);

            if(!$id_bapteme && !$id_personne) {

                //something is wrong
                echo 'something is wrong with the user';
                exit;
            }
            
            $this->load->model('deces_model');

            if($this->deces_model->save_deces($data)) {
            
                $message['text'] = 'Le deces a ete enregistre';
                $message['type'] = 'success';    
            }else {
            
                $message['text'] = 'Une erreur est survenue lors de l\'enregistrement du deces. Reesayer SVP!';
                $message['type'] = ($is_ajax)?'error':'danger';    
            }

            if($is_ajax) {
                echo json_encode($message); 
            }else {
            
                $this->session->set_flashdata('action_message',$message);

                redirect('sacrement/deces');
            }
        }    
    }

    function check_baptise($value) {
        $this->load->library('form_validation');
        $id_non_baptise = $this->input->post('id_nonBaptise'); 
        if($value || $id_non_baptise) {
           return TRUE; 
        }

       $this->form_validation->set_message('check_baptise','Veuillez Selectionnez une personne');
       return FALSE; 
    }
    
    function check_non_baptise($value) {
        $this->load->library('form_validation');
        $id_baptise = $this->input->post('id_bapt'); 
        if($value || $id_baptise) {
           return TRUE; 
        }

        $this->form_validation->set_message('check_non_baptise','Veuillez Selectionnez une personne');
       return FALSE; 
    }

	function editDeces($id_Deces){
		$data['deces']=$this->deces_model->getDeces($id_Deces);

		$is_ajax=false;
		$data['ajax'] =$is_ajax;

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
            $this->layout->add_js('deces');

            $this->layout->view('deces_form',$data);
        }
	}


}
