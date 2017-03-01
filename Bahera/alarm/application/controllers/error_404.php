<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Error_404 extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->load->model('overview_model');
		$this->load->model('login_model');
		$this->load->model('benchmark_model');
		$this->load->library('session');
     }
	public function index()
	{ 
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
            $data['username'] = $session_data['username'];
			$data['lastlogindate'] = $this->login_model->getlogindetails($session_data['id']);
			$data['plantData'] = $this->benchmark_model->getPlantData($session_data['id']);
			$data["heading"] = "404 Page Not Found";
			$data["message"] = "The page you requested was not found ";
			$this->load->view('error',$data);
		}
		else 
		{
			redirect(base_url());
		}		
	}
	
	
}
?>	