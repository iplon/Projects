<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {
	function __construct() {
                parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('login_model');		
		$this->load->library('session');
		$this->load->helper('money');		
     }
	public function index()
	{	
		$this->session->unset_userdata('filterdate');   	
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['lastlogindate'] = $this->login_model->getlogindetails($session_data['id']);
			$data['newReport'] = $this->login_model->getnewreport($session_data['id']);	
			$this->load->view('cron', $data);	
		}
		else
			redirect(base_url());	
	}
	//----------------------------------------------------------------------------	
	
	public function ods_down() {		
		$file_name = $this->uri->segment(2);
		$file_name1 = $this->uri->segment(2);
		$file_name = 'export/ods/'.$file_name;
		if (file_exists($file_name)) {		
		$this->load->helper('download');
		$data = file_get_contents($file_name);
		force_download($file_name1, $data); 		
		}
		else
		{			
			echo $file_name1;
			echo "File not found";
		}
	}
	
//----------------------------------------------------------------------------		

	function do_upload()
	{
		$config['upload_path'] = './export/ods/';
		$config['allowed_types'] = '*';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  = true;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			//$error = array('error' => $this->upload->display_errors());
			//echo 'This is not valid file format';
			
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}
		else
		{
			$zdata = array('upload_data' => $this->upload->data()); // get data
			$zfile = $zdata['upload_data']['full_path']; // get file path
			chmod($zfile,0777);
			echo 'pass';
			redirect(cron);
		}
	}

public function add_new()
    {
	  $plant = $this->input->post('plant',TRUE);
	  $title = $this->input->post('title',TRUE);
	  $name = $this->input->post('name',TRUE);
	  $type = $this->input->post('type',TRUE);
	  $interval = $this->input->post('interval',TRUE);
      $this->login_model->add_new($plant,$title,$name,$type,$interval);
	  redirect(cron);
		}
public function del_report()
    {
	
	  $id = $this->uri->segment(3);
      $this->login_model->del_report($id);
	  redirect(cron);
		}		
public function calc_revenue()
	{
	  $date = $this->input->post('date',TRUE);
	  list($day, $mon, $yr) = explode("-",  $date);
	  $ts = mktime(0, 0, 0, $mon, $day, $yr);
	  $plant = $this->input->post('plant',TRUE);
	  $cexport = $this->input->post('cexport',TRUE);
	  $import = $this->input->post('import',TRUE);
	  $nexport = $cexport-$import;
	  $dc_capacity = 102;
	  $cuf=($cexport/($dc_capacity*24))*100;
	  $revenue =   $nexport * 1000 * 7.4;
	   
      $this->login_model->add_revenue($ts,$plant,$cexport,$import,$nexport,$cuf,$revenue);
	  redirect(cron);
	}
}

