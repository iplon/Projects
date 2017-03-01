<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

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
			//$data['lastlogindate'] = $this->login_model->getlogindetails($session_data['id']);
			$data['newReport'] = $this->login_model->getnewreport($session_data['id']);	
			$this->load->view('report', $data);	
		}
		else
			redirect(base_url());	
	}

	//----------------------------------------------------------------------------
	public function test()
	{
		$file_name = $this->input->post('file_name',TRUE);
		error_reporting(E_ALL ^ E_NOTICE);
		require_once 'excel_reader.php';
		$data = new Spreadsheet_Excel_Reader($file_name);
		echo $output = $data->dump(true,true);
	}
	
	
	//----------------------------------------------------------------------------
	public function pkill_soffice()
	{
			$kill = "pkill soffice.bin";									   		     		
			exec($kill);
	}	
	
	//----------------------------------------------------------------------------
	
	public function excel_down() {		
		$file_name = $this->uri->segment(3);
		$type = $this->uri->segment(2);
		
		$file_name = str_replace("%2B", "+", $file_name);
		$explode_file_name = explode("_", $file_name);		
		$template = $explode_file_name[0];
		$plant = $explode_file_name[1];
		$type_value = $explode_file_name[2];
		$from_date = $explode_file_name[3];
		$to_date = $explode_file_name[4];
		if($type != "Nill" && $template == 'Block' && $plant == 'Report')	
		{
		
			$explode_file_name = explode("_", $file_name);		
			$template = $explode_file_name[0];
			$template1 = $explode_file_name[1];
			$plant = $explode_file_name[2];
			$from_date = $explode_file_name[3];
			$from_date = $explode_file_name[4];
			$CT = $explode_file_name[5];
			
		$plant = str_replace("%2B", "+", $plant);
			$file_name = $template.'_'.$template1.'_'.$plant.'_'.$type.'_'.$from_date.'_'.$CT;
		}		
		$file_name1 = $file_name;
		$file_name = 'export/excel/'.$file_name;
		if (file_exists($file_name)) {		
		$this->load->helper('download');
		$data = file_get_contents($file_name);
		force_download($file_name1, $data); 		
		}
		else
		{			
			echo $file_name;
			echo "File not found".'<br>';
			$this->excel_down();
		}
	}
	
	//----------------------------------------------------------------------------
		
		public function pdf_down() {		
		$file_name = $this->uri->segment(3);
		$type = $this->uri->segment(2);
		$file_name = str_replace("%2B", "+", $file_name);		
		$explode_file_name = explode("_", $file_name);		
		$template = $explode_file_name[0];
		$plant = $explode_file_name[1];
		$type_value = $explode_file_name[2];
		$from_date = $explode_file_name[3];
		$to_date = $explode_file_name[4];
		
		if($type != "Nill" && $template == 'Block' && $plant == 'Report')
		{
		
			$explode_file_name = explode("_", $file_name);		
			$template = $explode_file_name[0];
			$template1 = $explode_file_name[1];
			$plant = $explode_file_name[2];
			$from_date = $explode_file_name[3];
			$from_date = $explode_file_name[4];
			$CT = $explode_file_name[5];
			
		$plant = str_replace("%2B", "+", $plant);
			$file_name = $template.'_'.$template1.'_'.$plant.'_'.$type.'_'.$from_date.'_'.$CT;
		}
		$file_name1 = $file_name;
		$file_name = 'export/pdf/'.$file_name;
		
		if (file_exists($file_name)) {		
		$this->load->helper('download');
		$data = file_get_contents($file_name);
		force_download($file_name1, $data); 		
		}
		else
		{			
			echo $file_name;
			echo "File not found".'<br>';
			$this->excel_down();
		}
	}

	//----------------------------------------------------------------------------		
	
	
	
	public function check_excel() {
	
		$file_name = $this->input->post('file_name',TRUE);	
		$file_name = '/var/www/report/export/html/'.$file_name.'.xls';
		echo $file_name;
	if (file_exists($file_name)) {					
			echo 'found';
	}	 	
	else {
		echo "File not found";
	}

	}
	
	//----------------------------------------------------------------------------	
	
	public function check_html() {
		
		$file_name = $this->input->post('file_name');
		$block_sel = $this->input->post('block_sel');
		$block_sel = $this->input->post('block_sel');
		$template = $this->input->post('report_name');
		$plant = $this->input->post('plant');
		$type_value = $this->input->post('report_type');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('from_date');
		$report_name = $this->input->post('report_name');
		$CT = $this->input->post('time');
			
		$interval = '15';
		$SH = '0'; 
		$EH = '23'; 
		$SPL = '0';

		if($report_name == 'Station_Report1')
		{
			$file_name = '/var/www/report/export/html/'.$template.'_'.$plant.'_'.$type_value.'_'.$from_date.'_'.$CT.'.html';
			echo $template = $report_name.'-'.$plant.'-'.$type_value;
		}
/*	
if($report_name == 'Inverter_Generation_Report' || $report_name == 'SMU_Generation_Report' || $report_name == 'SMU_Daily_Communication_Report' || $report_name == 'WMS_OneMinutes_Report' || $report_name == 'WMS_Monthly_Report' || $report_name == 'Inverter_Monthly_Generation_Report' || $report_name == 'Plant_Generation_Report' || $report_name == 'Main_Page_Daily' || $report_name == 'Parameter_Daily_Report' || $report_name == 'Daily_Generation_Report' || $report_name == 'Monthly_Report' || $report_name == 'Import_Export' || $report_name == '33kV_Feeder_Report' || $report_name == 'Daily_Generation_Report'){
$template = $template.'-'.$plant;
			
$file_name = '/var/www/report/export/html/'.$file_name.'.html';
}*/

if($report_name == 'Inverter_Generation_Report' || $report_name == 'SMU_Generation_Report' || $report_name == 'SMU_Daily_Communication_Report' || $report_name == 'WMS_OneMinutes_Report' || $report_name == 'WMS_Monthly_Report' || $report_name == 'Inverter_Monthly_Generation_Report' || $report_name == 'Plant_Generation_Report' || $report_name == 'Main_Page_Daily' || $report_name == 'Parameter_Daily_Report' || $report_name == 'Monthly_Report' || $report_name == 'Import_Export' || $report_name == '33kV_Feeder_Report'){
$template = $template.'-'.$plant;
			
$file_name = '/var/www/report/export/html/'.$file_name.'.html';
}


if($report_name == 'Block_Report')
	$file_name = '/var/www/report/export/html/'.$template.'_'.$plant.'_'.$block_sel.'_'.$from_date.'_'.$CT.'.html';


	$from_date = explode("-", $from_date);
		$s_day =  $from_date[0];
		$s_month = $from_date[1];	
		$s_year = $from_date[2];
		
		
		$to_date = explode("-", $to_date);
		$e_day =  $to_date[0];
		$e_month = $to_date[1];	
		$e_year = $to_date[2];
	
		if($template == 'Station_Report'){
			$template = $template.'-'.$plant.'-'.$type_value;
			$type_value = 'day';
			$file_name = '/var/www/report/export/html/'.$file_name.'.html';
			
		}
		if($template == 'PeramRep')
			$interval = '01';

		if($report_name == '33kV_Feeder_Report')
			$interval = '01';				
			
		if($template == '33kV_Block_Report'){
			$SH = '06';
			$EH = '19';
			$interval = '60';
			$SPL = '0';
			
$template = $template.'-'.$plant;
			
$file_name = '/var/www/report/export/html/'.$file_name.'.html';
			
		}
			
		if($template == 'SMU_Hourly_Communication_Report'){		
			$interval = '60';						
			$file_name = '/var/www/report/export/html/'.$file_name.'.html';
			$template = $template.'-'.$plant;		
		}		

		if($report_name == 'Plant_Daily_Generation_Report')	{
			$template = $template.'-'.$plant;
			$file_name = '/var/www/report/export/html/'.$file_name.'.html';
		}		
		
		if($template == 'Inverter_Report' && $type_value == 'Hourly' && $block_sel != 'All'){		
			$file_name = '/var/www/report/export/html/'.$file_name.'.html';
			$template = $template.'-'.$plant.'-Hourly';						
			$type_value = 'day';			
			$SH = '06';
			$EH = '19';
			$interval = '60';
			$SPL = '0';				
		}		
		
		if($template == 'Inverter_Report' && $type_value == 'Hourly' && $block_sel == 'All'){			
			$file_name = '/var/www/report/export/html/'.$file_name.'.html';
			$template = $template.'-'.$plant.'-Hourly-All';	
			$type_value = 'day';			
			$SH = '06';
			$EH = '19';
			$interval = '60';
			$SPL = '0';			
		}		
		
		if($template == 'Inverter_Report' && $type_value != 'Hourly'){
			$file_name = '/var/www/report/export/html/'.$file_name.'.html';	
			$template = $template.'-'.$plant.'-'.$type_value;	
			$type_value = 'Rep';
		}

		if($template == 'PlantGenRep' || $template == 'MainPgDaily' || $template == 'PeramRep' || $template == 'DGRRep' || $template == 'MonthRep' || $template == 'ScaImpExpRep' || $template == 'IGRRep' || $template == 'SMUGenRep' || $template == 'SMUCommRep' || $template == 'INVMonRep' || $template == 'ScaBloRep' || $template == 'ScaOneTenRep' || $template == 'ScaDaiGenRep' || $template == 'Block_Report'){
			$template = $template.'-'.$plant;
		}
		if($template == 'Inverter_Report' && $type_value != 'hour'){
			$template = $template.'-'.$type_value;							
		}
		
		if($template == 'BlockSMUcommRep')
			$interval = '60';
	
		if($template == 'WMS_OneMinutes_Report')
			$interval = '01';
		

		if($template == 'Inverter_CUF_Report' || $template == 'Inverter_Comparison_Report' || $template == 'ABT_Revenue_Report')
		{				
			$file_name = '/var/www/report/export/html/'.$file_name.'.html';
			$template = $template.'-'.$plant;
			$type_value = 'month';
		}
		if($template == 'Daily_Generation_Report')
		{				
			$file_name = '/var/www/report/export/html/'.$file_name.'.html';
			$template = $template.'-'.$plant;
			$type_value = 'Rep';
		}
		if($template == 'WMSMonRep')
			$s_day = '01';

		if($report_name == 'Block_Report')
			$interval = '01';	
		
		if($report_name == 'Parameter_Daily_Report')
			$interval = '01';	
		
		if($report_name == 'WMS_OneMinutes_Report')
			$interval = '01';	
		
		if($type_value == 'Day')
			$type_value = 'day';
		else if($type_value == 'month')
			$type_value = 'month';
		else if($type_value == 'Year')
			$type_value = 'year';		
		
			$cmd = "HOME=/var/www DISPLAY=:0 S_CRON=0 CT={$CT} BLOCK={$block_sel} PLANT={$plant} TYPE={$type_value} SD={$s_day}/{$s_month}/{$s_year} ED={$e_day}/{$e_month}/{$e_year} SH={$SH} EH={$EH} SPL={$SPL} INTERVAL={$interval} DDT2LO_LOAD=1 DDT2LO_SAVEHTML=1 DDT2LO_SAVEPDF=1 DDT2LO_SAVE=1 DDT2LO_QUIT=1 soffice --norestore --headless /var/www/report/export/ods/{$template}.ods";
				//echo $cmd; exit;		     		
			  exec($cmd);  
		while (!file_exists($file_name)) sleep(1);
		 	
		if (file_exists($file_name)) {
		echo $html = file_get_contents($file_name);
		}
		else{echo 'file not exist'; exit;}
	  }	
	
	//----------------------------------------------------------------------------
	//-------------------dynamic check html---------------------------------------
	public function dyn_check_html() {
		$file_name = $this->input->post('file_name');
		$file_name=str_replace('plus','+',$file_name);
		$block_sel = $this->input->post('block_sel');
		$block_sel = 'Nill';
		$template = $this->input->post('report_name'); 
		$template=str_replace('plus','+',$template);
		$plant = $this->input->post('plant');
		$plant=str_replace('plus','+',$plant);
		$type_value = $this->input->post('report_type');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('from_date');
		$report_name = $this->input->post('report_name');
		$interval = $this->input->post('interval');
		$CT = $this->input->post('time');
		$SH = '0'; 
		$EH = '23'; 
		$SPL = '0';
		$from_date = explode("-", $from_date);
		$s_day =  $from_date[0];
		$s_month = $from_date[1];	
		$s_year = $from_date[2];
		$to_date = explode("-", $to_date);
		$e_day =  $to_date[0];
		$e_month = $to_date[1];	
		$e_year = $to_date[2];	
		$file_name = '/var/www/report/export/html/'.$file_name.'.html';
		//$template=str_replace('plus','+',$template);
		//$template = $template.'-'.$plant;
		//$template = $template;
		
		if($type_value=='day_variable'){
		$interval1=$interval;
		$interval2='15';	
		}elseif($type_value=='historical'){
		$interval1='type_no';
		$interval2=$interval;	
		}
		$cmd = "HOME=/var/www DISPLAY=:0 S_CRON=0 CT={$CT} BLOCK={$block_sel} PLANT={$plant} TYPE={$interval1} SD={$s_day}/{$s_month}/{$s_year} ED={$e_day}/{$e_month}/{$e_year} SH={$SH} EH={$EH} SPL={$SPL} INTERVAL={$interval2} DDT2LO_LOAD=1 DDT2LO_SAVEHTML=1 DDT2LO_SAVEPDF=1 DDT2LO_SAVE=1 DDT2LO_QUIT=1 soffice --norestore --headless /var/www/report/export/ods/{$template}.ods";
		//echo $cmd;		      		
		exec($cmd);
		while (!file_exists($file_name)) sleep(1);
			if (file_exists($file_name)) {		
			echo $html = file_get_contents($file_name);
			}
	}	
	//-------------------dynamic check html---------------------------------------
	
	public function check_avaiable() {
		
		$file_name = $this->input->post('file_name',TRUE);
		
	if (file_exists($file_name)) {
		echo "Found";
	}	 	
	else {
		echo "The file $file_name does not exist - Call Reporting Package Manager";
	}
	
	}
	
	//----------------------------------------------------------------------------
	
		
	public function download_zip() {
		$date_zip = $this->input->post('date',TRUE);	
		echo $date_zip;
		echo $path = "/var/www/report/export/Schedule_Report/05-11-2015/";
		$this->load->library('zip');									
		$this->zip->read_dir($path);
		// Download the file to your desktop. Name it "my_backup.zip"
		$this->zip->download('my_backup.zip'); 
	}	
	
	
	//----------------------------------------------------------------------------


	public function inverter_graph()
	{		
	$type = $this->input->post('type',TRUE);
	$from_date = $this->input->post('from_date',TRUE);
	$to_date = $this->input->post('to_date',TRUE);
	$plant = $this->input->post('plant',TRUE);
	
	$from_date1 = $from_date;
	
		$from_date = explode("-", $from_date);
		$s_day =  $from_date[0];
		$s_month = $from_date[1];	
		$s_year = $from_date[2];
		
		
		$to_date = explode("-", $from_date1);
		$e_day =  $to_date[0];
		$e_month = $to_date[1];	
		$e_year = $to_date[2];	
		
		$date_today = $s_day.'/'.$s_month.'/'.$s_year;

	$json=file_get_contents("http://localhost/Bahera/ScadaApi/report_inverter?sd=".$date_today);
    $data =  json_decode($json);
	foreach ($data as $key=>$stand) 
		$block[] = $stand[0];			
		
	$block = array_unique($block); 		
	ksort($block);
	$max = sizeof($block);	
	
	$data1=0;
	$data2=0;
	$val = ''; $i="1";
	$k=0;	
	
//if($plant == 'plant1')
//{
	
		foreach($block as $block_value){ $k++;
		foreach ($data as $key=>$stand){  $i++; 
			if($stand[0] == $block_value){ $data2 = 0; 
				if($stand[2] == 'EAE_DAY') 	
					if($k <= 14){
						
						if($stand[4] == 'NaN')  
							$val = 0;
						else
							$val = number_format($stand[4], 3);
							$data1 .= $val.'&';
						
					}
				
			} 
				
				
		}  $data1 .='_'; 
	}$val .= $data1;
//}

	$val = rtrim($val, '_');		
	$val = rtrim($val, '&');
	
$val = str_replace("&_","_",$val);



$test = explode("_", $val); $value2='';
foreach($test as &$value)
{							$value1='';
    $value = explode('&', $value);  $sum = 0; 
    foreach($value as &$inner_value) 
    {
       $sum += $inner_value;	   
	   $sum1 =$sum;
    } 	$value1 .=$sum1.', '; 	$value2 .= $value1;
}

	$value2 = rtrim($value2, ', ');

echo $value2;	
	die;		
	
	}	
	
	//----------------------------------------------------------------------------


	public function block_graph()
	{		
	$type = $this->input->post('type',TRUE);
	$from_date = $this->input->post('from_date',TRUE);
	$to_date = $this->input->post('to_date',TRUE);
	$plant = $this->input->post('plant',TRUE);
	
	$from_date1 = $from_date;
	
		$from_date = explode("-", $from_date);
		$s_day =  $from_date[0];
		$s_month = $from_date[1];	
		$s_year = $from_date[2];
		
		
		$to_date = explode("-", $from_date1);
		$e_day =  $to_date[0];
		$e_month = $to_date[1];	
		$e_year = $to_date[2];	
		
		$date_today = $s_day.'/'.$s_month.'/'.$s_year;
		
		$end_today = $e_day.'/'.$e_month.'/'.$e_year;
	$json=file_get_contents("http://localhost/Bahera/ScadaApi/report_kv?&sd=".$date_today.'&ed='.$end_today);
	
    $data =  json_decode($json);

	
	foreach ($data as $key=>$stand) 
		$block[] = $stand[0];			

		
	$block = array_unique($block); 		
	ksort($block);

	

	
	$max = sizeof($block);	
	
	$data1=0;
	$data2=0;
	$val = ''; $i="1";
	$k=0;	
	

	
	foreach($block as $block_value){
		if (substr($block_value, 0, 5) === 'Block')
			foreach ($data as $key=>$stand){  $i++; 
				if($stand[0] == $block_value){ 
					if($stand[2] == 'EAE') 						
							$data1 .= number_format($stand[4], 3).'&';					
					
				
			} 								
		}  $data1 .='_'; 
	}$val .= $data1;
	
	
	$val = rtrim($val, '_');		
	$val = rtrim($val, '&');

$val = str_replace("&",", ",$val);	

$val = str_replace("&_","_",$val);

echo $val;

			
	die;		
	
	}		
	
	//----------------------------------------------------------------------------

}
