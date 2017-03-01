<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alarm extends CI_Controller {

	function __construct() {
        parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('alarm_model');
		$this->load->model('login_model');		
		$this->load->library('session');
		$this->load->helper('money');
     }
	public function index()
	{ 	
	
		$this->session->unset_userdata('filterdate');   	

		$plantData = array();$hourPowTs = array();$hourPowtableTs = array();$hourPowData = array();$weekEMData= array();$monthEMData= array();$yearEMData=array();
		$powTs = array(); $powData = array();$alarmDetails = array();$activePow=array();$powerPR=array(); $emYield = array();$emMonthYield = array();$revcost= array();
		$edit = array(); $list= array();

			if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['lastlogindate'] = $this->login_model->getlogindetails($session_data['id']);			
			
			$list = $this->alarm_model->getList();
			$add_alarm_type_val = $this->alarm_model->getList1();
			$edit = '';
			
			$alarmDetails[] = array('edit'=>$edit,'list'=>$list,'add_alarm_type'=>$add_alarm_type_val);					
			$data['alarmInfo'] = $alarmDetails;	
			$this->load->view('alarm', $data);
			
			//$data['alarmInfo'] = $this->alarm_model->getList();
			//$this->load->view('alarm', $data);

		}	

	}
	
	public function alarm_remove()
	{	

		$id = $this->uri->segment(3);	
		$this->alarm_model->alarmRemove($id);																
		redirect('alarm');
	}
	
	public function alarm_audio()
	{
		$id = $this->uri->segment(3);
		$st_id = $this->uri->segment(4);
		if($st_id=='0')
			$st_id ='1';	
		else
			$st_id ='0';	
		
		if($id != '' && $id > 0 && $st_id != ''){
		$this->alarm_model->alarmAudio($id,$st_id);
		redirect('alarm');		
		}
	}
	
	public function alarm_history()
	{
		$id = $this->uri->segment(3);
		$st_id = $this->uri->segment(4);
		if($st_id=='0')
			$st_id ='1';	
		else
			$st_id ='0';	
	
		if($id != '' && $id > 0 && $st_id != ''){
		$this->alarm_model->alarmHistory($id,$st_id);
		redirect('alarm');
		}
	}
	
	public function alarm_status()
	{
		$id = $this->uri->segment(3);
		$st_id = $this->uri->segment(4);
		if($st_id=='0')
			$st_id ='1';	
		else
			$st_id ='0';	
		
		if($id != '' && $id > 0 && $st_id != ''){
			$this->alarm_model->alarmStatus($id,$st_id);
			redirect('alarm');
		}
	}
	
	
	
	public function priority_change()
	{
	$id = $this->input->post('id',TRUE);
	$priority = $this->input->post('priority',TRUE);	

		$this->alarm_model->alarmPriority($id,$priority);
		redirect('alarm');		
		
	}
	
	public function pup()
	{
	$id = $this->uri->segment(3);
	$priority = $this->uri->segment(4);	

		$this->alarm_model->alarmPriority($id,$priority);
		redirect('alarm');		
		
	}


	public function add_alarm()
	{	
/*		
		$add_alarm_field = $this->alarm_model->alarmAdd_field();
		$alarmDetails[] = array('add_alarm_field'=>$add_alarm_field);					
		//$data['alarmAddInfo'] = $alarmDetails;	
		//print_r($add_alarm_field[0]);
		
		foreach($add_alarm_field as $block_value)
			echo $block_value;
		
echo '<table><tr><td> Alarm Type</td>    <td>   </td></tr>
<tr><td>Alarm Field</td>    <td>   </td></tr>
<tr><td></td>    <td>   </td></tr>
<tr><td>   </td>    <td>   </td></tr>
<tr><td>   </td>    <td>   </td></tr>
<tr><td>   </td>    <td>   </td></tr>
<tr><td>   </td>    <td>   </td></tr></table>';				
			
	
							
		
		//redirect('alarm');		
		*/
		
	}	
	
	
	
	
	public function check_field()
	{
		$field=$this->input->post('field');
		$result=$this->alarm_model->checkFieldExist($field);
		if($result)
		{
			echo "false";
		}
		else{
			echo "true";
		}
	}
	
	
	
	
	public function alarm_edit()
	{
		if($this->session->userdata('logged_in'))
		{
			$edit = array(); $list = array(); $alarmDetails = array();
			
			$id = $this->uri->segment(3);
			if($id != '' && $id > 0)
			{	

				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];				
				$data['lastlogindate'] = $this->login_model->getlogindetails($session_data['id']);
				
				
				
				
				
				$edit = $this->alarm_model->alarmEdit($id);
				//print_r($edit);  echo '<br><br>';
				//redirect('alarm');
				

				$list = $this->alarm_model->getList();
				//print_r($list);
		
				$alarmDetails[] = array('edit'=>$edit,'list'=>$list);					
				$data['alarmInfo'] = $alarmDetails;			
				
				$this->load->view('alarm',$data);
			
				//redirect('alarm');
		
			}
		}
		
	}
	
	
	
	
	
	public function alarm_edit_1()
	{
		if($this->session->userdata('logged_in'))
		{
			$edit = array(); $list = array(); $alarmDetails = array();
			
			$id = $this->uri->segment(3);
			if($id != '' && $id > 0)
			{	

				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];				
				$data['lastlogindate'] = $this->login_model->getlogindetails($session_data['id']);

				$edit = $this->alarm_model->alarmEdit($id);
		
				$alarmDetails[] = array('edit'=>$edit);					
				$data['alarmInfo'] = $alarmDetails;			
				
				$this->load->view('alarm',$data);
			
				//redirect('alarm');
		
			}
		}
		
	}
	
	
	
	
	
	
	
	
	
	public function alarm_add_new()
	{
	$data = array(
	'alarm_type' => $this->input->post('alarm_type'),
	'alarm_field' => $this->input->post('field'),
	'type' => $this->input->post('type'),
	
	'status' => $this->input->post('status'),
	'audio_status' => $this->input->post('audio_status'),
	'history_enable' => $this->input->post('history_status'),
	'priority' => $this->input->post('priority')
	);

	$this->alarm_model->alarmInsert($data);		
	redirect('alarm');
	}
	
	
	public function alarm_update()
	{
	$data = array(
	'id' => $this->input->post('id'),
	'alarm_type' => $this->input->post('alarm_type'),
	'alarm_field' => $this->input->post('field'),
	'type' => $this->input->post('type'),
	'priority' => $this->input->post('priority')
	);

	$id= $this->input->post('id');
	//print_r($data);
	$this->alarm_model->alarmUpdate($id, $data);		
	redirect('alarm');
	}

}

?>	
