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

        if($is_ajax) {
            $this->load->view('bapteme_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin');
            $this->layout->add_css('bootstrap-datetimepicker.min');
            $this->layout->add_css('bootstrapValidator.min');

            // SB Admin Scripts - Include with every page
            $this->layout->add_js('moment.min');
            $this->layout->add_js('bootstrap-datetimepicker.min');
            $this->layout->add_js('bootstrapValidator.min');
            $this->layout->add_js('jquery.bootstrap.wizard.min');
            $this->layout->add_js('sb-admin');
            $this->layout->add_js('bapteme');
            $this->layout->view('bapteme_form',$data);
        }
            
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
