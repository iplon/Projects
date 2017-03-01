<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Det extends CI_Controller {

	function __construct() {
        parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('det_model');
		$this->load->model('login_model');
		$this->load->helper('form');
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
			
         $data['blockDrop'] = $this->det_model->getBlock();
		 
		 /*$data['allBlockDrop'] = $this->det_model->getAllBlock();
		 $data['allDeviceDrop'] = $this->det_model->getAllDevice();
		 $data['allFieldDrop'] = $this->det_model->getAllfield();*/
         $data['getAllDayField'] = $this->det_model->getAllDayField();
		 $data['getAllFav'] = $this->det_model->getAllFav();		 
         $this->load->view('det', $data);
		}
		else
			redirect(base_url());			
    }
	
	

    public function buildDropDevice()
    {
		$block = Array();		
      $block = $this->input->post('id',TRUE);

       $districtData['deviceDrop']=$this->det_model->getCityByDevice($block);
        
       $output = "<option value='all'>All</option>";
			
        foreach ($districtData['deviceDrop'] as $row)                    
			$output .= "<option value='".$row->device_name."'>".$row->device_name."</option>";
        
        echo  $output;
    }
	

	
    public function buildDropField()
    {
		$block = Array();
		$device = Array();      
	  $block = $this->input->post('block',TRUE);
	  $device = $this->input->post('device',TRUE);
        
       $districtData['fieldDrop']=$this->det_model->getCityByField($block,$device);
        
       //$output = null;
	   $output = "<option value='all'>All</option>";

        foreach ($districtData['fieldDrop'] as $row)
        {
			$output .= "<option value='".$row->field."'>".$row->field."</option>";
        }

        echo  $output;
    }
	
    public function buildTable()
    {
		$block = Array();
		$device = Array();
		$field = Array();
      
	  $block = $this->input->post('block',TRUE);
	  $device = $this->input->post('device',TRUE);
	  $field = $this->input->post('field',TRUE);
	  $date_from = $this->input->post('date_from',TRUE);
	  $date_to = $this->input->post('date_to',TRUE);
        
       $districtData['fieldDrop']=$this->det_model->getGraphData($block,$device,$field,$date_from,$date_to);
       
       $output = null;
		$output = "<table id='table_tbody_fill' class='table table-striped table-bordered' cellspacing='0' width='100%'>
					<thead><tr> <th>Date Time</th> <th>Block</th> <th>Device</th> <th>Field</th> <th>value</th> </tr></thead><tbody id='table_tbody'>";
        foreach ($districtData['fieldDrop'] as $row)
        {        
            $output .= "<tr>  <td>".$row->ts."</td>   <td>".$row->blockname."</td> <td>".$row->device_name."</td>  <td>".$row->field."</td>   <td>".$row->value."</td></tr>";
        }
			$output .='</tbody></table>';
        echo  $output;
    }
	
	public function storeFav()
    {	
		$block = Array();
		$device = Array();
		$field = Array();
		$block = $this->input->post('block',TRUE);
		$device = $this->input->post('device',TRUE);
		$field = $this->input->post('field',TRUE);
		$store=$this->det_model->storefavo($block,$device,$field);
		echo $store;	   
    }
	public function deleteFav()
    {	
		$id = $this->input->post('id',TRUE);
		$store=$this->det_model->deleteFav($id);
		echo $store;	   
    }
	
	public function getAllBlocks()
    {	
		$data['allBlockDrop'] = $this->det_model->getAllBlockReset();
		$output = "<option value='all'>All</option>";
        foreach ($data['allBlockDrop'] as $row)
        {
			$output .= "<option value='".$row->blockname."'>".$row->blockname."</option>";
        }
        echo  $output;   
    }
    public function buildExcel()
    {
		$block = Array();
		$device = Array();
		$field = Array();
      
	  $block = $this->input->post('block',TRUE);
	  $device = $this->input->post('device',TRUE);
	  $field = $this->input->post('field',TRUE);
	  $date_from = $this->input->post('date_from',TRUE);
	  $date_to = $this->input->post('date_to',TRUE);
        
       $districtData['fieldDrop']=$this->det_model->getGraphData($block,$device,$field,$date_from,$date_to);
        
       $output = null;	   
	   $output = "".'Date and Time'."\t"."".'Block'."\t"."".'Device'."\t".'Field'."\t"."".'Value'."\t\n";
        foreach ($districtData['fieldDrop'] as $row)
        {       
            $output .= "".$row->ts."\t"."".$row->blockname."\t"."".$row->device_name."\t".$row->field."\t"."".$row->value."\t\n";
		}
		
		echo  $output;
	}	
    public function buildTableDayVariable()
    {      
	  $date_from = $this->input->post('date_from',TRUE);
	  $date_to = $this->input->post('date_from',TRUE);
$test1 = explode(' ',$date_to);
$date_to = $test1[0]; 
$date_to = $date_to.' 23:00';
       $districtData['fieldDrop']=$this->det_model->getTableDayVariable($date_from,$date_to);
       $output = null;
	   $output = "<table id='table_tbody_fill' class='table table-striped table-bordered' cellspacing='0' width='100%'>
					<thead><tr> <th>Date & Time</th> <th>Block</th> <th>Device</th> <th>Field</th> <th>value</th> </tr></thead><tbody id='table_tbody'>";
        foreach ($districtData['fieldDrop'] as $row)
        {      
            $output .= "
						<tr>  <td>".$row->ts."</td>   <td>".$row->block."</td> <td>".$row->device."</td>  <td>".$row->field."</td>   <td>".$row->value."</td></tr>";
        }
			$output .='</tbody></table>';
        echo  $output;
	   
    }

    public function buildExcelDayVariable()
    {      
	  $date_from = $this->input->post('date_from',TRUE);
	  
$test = explode(' ',$date_from);
$date_to = $test[0];		
$date_to = $date_to.' 23';	  
       $districtData['fieldDrop']=$this->det_model->getTableDayVariable($date_from,$date_to);
       $output = null;	   
	   $output = "".'Date and Time'."\t"."".'Block'."\t"."".'Device'."\t".'Field'."\t"."".'Value'."\t\n";
        foreach ($districtData['fieldDrop'] as $row)
        {       
            $output .= "".$row->ts."\t"."".$row->block."\t"."".$row->device."\t".$row->field."\t"."".$row->value."\t\n";
		}
		
		echo  $output;
	}	
	
	
	
    public function buildGraph()
    {
		$block = Array();
		$device = Array();
		$field = Array();
      
	  $block = $this->input->post('block',TRUE);
	  $device = $this->input->post('device',TRUE);
	  $field = $this->input->post('field',TRUE);
	  $date_from = $this->input->post('date_from',TRUE);
	  $date_to = $this->input->post('date_to',TRUE);
	  //echo $date_to; exit;
        
       $districtData['fieldDrop']=$this->det_model->getGraphData($block,$device,$field,$date_from,$date_to);
	  // $countData = $this->det_model->getGraphCount($block,$device,$field,$date_from,$date_to);	
	  
	$output = null;	   
	$output_field = null;	

	$device=explode(',',$device);	
	$device_count = count($device);			
	foreach($device as $device_key){
	$device1 = $device_key;	
	
				$c=explode(',',$field);	
				$f = count($c);
				$j =0;
				foreach($c as $v){
				$field1 = $v;
				foreach ($districtData['fieldDrop'] as $row)
				{		
						$field_db = $row->field;
						$device_db = $row->device_name;
						if($device_db == $device1){
						if($field_db == $field1){
							$val = $row->value;
							if($val == 'NULL')
								$val = '0';
							$output_field .= "[".(($row->ts1+19800)*1000).', '.$val."],";											
						}
						}
				}
				$output_field= rtrim($output_field, ', '); $output_field .= '!';
				} 
				
				//$output_field= rtrim($output_field, ', '); $output_field .= '!';
				}
				
				$output_field= rtrim($output_field, ', ');

	$output = $output_field;
		
	echo  $output;
	}	
	

    public function excel()
    {
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('DET');
                //set cell A1 content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', 'DET Excel Sheet');
                $this->excel->getActiveSheet()->setCellValue('A4', 'S.No.');
                $this->excel->getActiveSheet()->setCellValue('B4', 'Country Code');
                $this->excel->getActiveSheet()->setCellValue('C4', 'Country Name');
                //merge cell A1 until C1
                $this->excel->getActiveSheet()->mergeCells('A1:C1');
                //set aligment to center for that merged cell (A1 to C1)
                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //make the font become bold
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
                $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       for($col = ord('A'); $col <= ord('C'); $col++){
                //set column dimension
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
                //retrive contries table data
                $rs = $this->db->get('countries');
                $exceldata="";
        //foreach ($rs->result_array() as $row){
			foreach ($districtData['fieldDrop'] as $row){
                $exceldata[] = $row;
        }
                //Fill data 
                $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
                 
                $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
                $filename='ExcelDemo.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
 
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');
                 
    }
		
}

?>	
