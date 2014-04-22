<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct() {
		parent::__construct();
		$this->auth->restrict();
	}
	
	public function index()
	{
		$this->load->library('layout');
		
		// page level css
		$this->layout->add_css('plugins/morris/morris-0.4.3.min');
		$this->layout->add_css('plugins/timeline/timeline');
		$this->layout->add_css('sb-admin');
		
		// Page-Level Plugins Scripts - Dashboard . Core scripts have been loaded by the theme helper :8
		$this->layout->add_js_files(array('plugins/morris/raphael-2.1.0.min',
										'plugins/morris/morris'));
		
		// SB Admin Scripts - Include with every page
		$this->layout->add_js('sb-admin');
		
		// Page-Level Demo Scripts - Dashboard - Use for reference
		$this->layout->add_js('demo/dashboard-demo');
		
		
		$this->layout->view('welcome_message');
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
