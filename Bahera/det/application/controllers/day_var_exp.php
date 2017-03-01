<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class day_var_exp extends CI_Controller {

	function __construct() {
        parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->library('session');
     }
		

    public function index()
    {
		error_reporting(0); 
	$connect = mysqli_connect('localhost','root','iplon321','lomada');
	date_default_timezone_set('Asia/Kolkata');  
	$header ="";
	
	///from date
	$ts_seg1=$this->uri->segment(3);
	$ts_str1=str_split($ts_seg1);
	$year1=$ts_str1[0].$ts_str1[1].$ts_str1[2].$ts_str1[3];
	$month1=$ts_str1[4].$ts_str1[5];
	$day1=$ts_str1[6].$ts_str1[7];
	$ts1 = mktime(0, 0, 0, $month1, $day1 , $year1);
	
	
	///to date
	$ts_seg2=$this->uri->segment(4);
	$ts_str2=str_split($ts_seg2);
	$year2=$ts_str2[0].$ts_str2[1].$ts_str2[2].$ts_str2[3];
	$month2=$ts_str2[4].$ts_str2[5];
	$day2=$ts_str2[6].$ts_str2[7];
	$ts2 = mktime(0, 0, 0, $month2, $day2 , $year2);
	
	$field=str_replace(",","','",$this->uri->segment(5));
	if($field==''){$in='NOT IN';}else{$in='IN';}
	$fields = array("Datetime","Block","Device","Field","Value");
	for ( $i = 0; $i < count($fields); $i++ )
	{
		$header .= $fields[$i] . "\t";
	}
	$data = '';
	 $select="select FROM_UNIXTIME(ts,'%Y-%m-%d') AS datetime,block,device,field, value from day_variable where ts >= $ts1 and ts <= $ts2 and field $in ('".$field."') order by ts,block,device,field";
		$export = mysqli_query ($connect,$select);
		while( $row = mysqli_fetch_row( $export ) )
		{
			$line = '';
			foreach( $row as $value )
			{                                            
				if ( ( !isset( $value ) ) || ( $value == "" ) )
				{
				$value = "\t";
			}
			else
			{
				$value = str_replace( '"' , '""' , $value );
				$value = '"' . $value . '"' . "\t";
			}
				$line .= $value;
			}
			$data .= trim( $line ) . "\n";
		}
		$data = str_replace( "\r" , "" , $data );

	
if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

if($ts1==$ts2){
$file_name='Day_Variables_'.$year1.'_'.$month1.'_'.$day1.'.xls';
}else{
$file_name='Day_Variables_'.$year1.'_'.$month1.'_'.$day1.'_to_'.$year2.'_'.$month2.'_'.$day2.'.xls';	
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
    }
	

		
}

?>	
