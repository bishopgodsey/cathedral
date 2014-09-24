<?php

class Documents extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->restrict();
        $this->load->library('layout');
        $this->load->helper('form');
    }

    public function delogationBapteme() {
        // SB Admin CSS - Include with every page
        $this->layout->add_css('sb-admin');

        // SB Admin Scripts - Include with every page
        $this->layout->add_js('sb-admin');
        $this->layout->add_js('bootstrap-typeahead');
        $this->layout->add_js('utils');
        $this->layout->add_js('delogation');

        $bapteme_columns = array('Num. Carte','Photo','Nom','Prenom','Date Bapteme', 'Parent spirituelle','Institution','Action');
        $data = array();

        $data['bapteme_columns'] = $bapteme_columns;
        
        $this->layout->view('delogation_form',$data); 
    }

    public function suggestBapteme() {
        
        $params = !empty($filters)?$filters:$this->input->get(NULL,TRUE);
        $this->load->model('bapteme_model'); 
        $raw_result = $this->bapteme_model->suggest_baptise($params['key']);
 
        $result = array();
        foreach($raw_result as $raw) {
            $name = $raw->num_carte_bapt.'-'.$raw->nom_bapt.'-'.$raw->prenom_bapt;
            array_push($result, array('id'=>$raw->id_bapt,'name'=>$name));  
        }

        echo json_encode($result);
    }

    public function generateDelogationBapteme($bapteme_id) {

        // Restrict access to users with Bapteme.View (View Permission ) permission
        //$this->auth->restrict(array('type'=>'warning',
        //'text'=>'You dont have right to access this document'), 'Documents.Delogation.Print');

        $this->load->model('bapteme_model');
        $data['bapteme'] = $this->bapteme_model->details($bapteme_id); 

        $html = $this->load->view('delogation_bapteme',$data,true);

       //* 
        // Load library
        $this->load->library('dompdf_gen');
        
        // Convert to PDF
        $this->dompdf->load_html(utf8_decode($html));
        $this->dompdf->render();
        $options = array("Attachment" => 0);
        $this->dompdf->stream("welcome.pdf",$options); 
        //*/
    }
}
