<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->load->model('login_model');		
		$this->load->library('session');
     }
	public function index()
	{	
			$this->load->view('login');	
	}
	
	public function checklogin()
	{
		$userName =$this->input->post('username');
		$password =$this->input->post('password');
		if($userName!='' && $password!=''){
			$logincheck = $this->login_model->validate();
			if($logincheck){
				$this->session->set_flashdata('Sucesslogin','user login successfully !');
				redirect(base_url().'alarm');
			}else{
				$this->session->set_flashdata('failurelogin','Invalid login!');
				redirect(base_url());
			}
		}
	}
	public function profile()
	{
		 if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
            $data['userId'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['lastlogindate'] = $this->login_model->getlogindetails($session_data['id']);
			$data['plantData'] = $this->benchmark_model->getPlantData($session_data['id']);
			$data['userData'] = $this->login_model->getuserDetails($data['userId']);
			$this->load->view('profile',$data);
		 }
	}
	public function updateprofile()
	{
		$userId = $this->input->post('userid');
		$emailAddress = $this->input->post('emailaddress');
		echo $filename= $this->input->post('profile');exit;

	}
	function logout()
	{
		if($this->session->userdata('logged_in')){
			$newdata = array('id'  =>'','username' => '',);
			$this->session->unset_userdata($newdata);
			$this->session->sess_destroy();
			redirect(base_url());
		}
		else{
			redirect(base_url());
		}
	}
}
