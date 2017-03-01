<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Det_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
	public function getBlock()
    {
		$this->db->distinct();
        $this->db->select('blockname');
        $this->db->from('device');
		$this->db->order_by("blockname", "asc");
        $query = $this->db->get();
         foreach($query->result_array() as $row){
            $data[$row['blockname']]=$row['blockname'];
        }		
        return $data;
    }
	public function getAllBlock()
    {
		$this->db->distinct();
        $this->db->select('blockname');
        $this->db->from('device');
		$this->db->order_by("blockname", "asc");		
        $query = $this->db->get();         
         foreach($query->result_array() as $row){
            $data[$row['blockname']]=$row['blockname'];
        }		
        return $data;
    }
	public function getAllDevice()
    {
		$this->db->distinct();
        $this->db->select('device_name');
        $this->db->from('device');
		$this->db->order_by("device_name", "asc");		
        $query = $this->db->get(); 
		$this->db->last_query();        
         foreach($query->result_array() as $row){
            $data[$row['device_name']]=$row['device_name'];
        }		
        return $data;
    }		
	public function getAllfield()
    {
		$this->db->distinct();
        $this->db->select('field');
        $this->db->from('scada_latest_igate_data');
		$this->db->order_by("field", "asc");		
        $query = $this->db->get();         
		
         foreach($query->result_array() as $row){
            $data[$row['field']]=$row['field'];
        }		
        return $data;
    }	
//fill your 3rd dropdown 
    public function getCityByDevice($block)
    {	
		
$block1="";
foreach($block as $key => $value)
	$block1 = $block1."'".$value."',";		
	$block1= rtrim($block1, ',');	
	
		$this->db->distinct();
        $this->db->select('device_name');
        $this->db->from('device');
		
		if($block1 != "'all'")
			$this->db->where("blockname IN( ".$block1.")");		
		
		$this->db->order_by("device_name", "asc");		
        $query = $this->db->get();
		return $query->result();
    }
public function getCityByField($block=string,$device=string)
    {	
$block1="";
$a=explode(',',$block);
foreach($a as $v)
    $block1 .= "'".$v."',";
$block1= rtrim($block1, ',');	
$device1="";
foreach($device as $key => $dev_value)
	$device1 = $device1."'".$dev_value."',";
	$device1= rtrim($device1, ',');
	
		$this->db->distinct();
        $this->db->select('field');
        $this->db->from('scada_latest_igate_data');
		if($block1 != "'all'")					
		$this->db->where("blockname IN( ".$block1.")");
		if($device1 != "'all'")					
			$this->db->where("device_name IN( ".$device1.")");
		$this->db->order_by("field", "asc");
        $query = $this->db->get();
		return $query->result();
    }
	public function getAllBlockReset()
    {	
		$this->db->distinct();
        $this->db->select('blockname');
        $this->db->from('device');	
		$this->db->order_by("blockname", "asc");		
        $query = $this->db->get();
		return $query->result();
    }
	public function getAllDayField()
    {
		
		$this->db->distinct();
        $this->db->select('field');
        $this->db->from('day_variable_fields');
		$this->db->order_by("field", "asc");		
        $query = $this->db->get();         
         foreach($query->result_array() as $row){
            $data[$row['field']]=$row['field'];
        }		
        return $data;
    }
	public function getAllFav()
    {
        $this->db->select('*');
		$this->db->order_by("id", "desc");		
        $query = $this->db->get('favSelection');
		if ($query->num_rows() > 0)
			{  	
        return $query->result_array();
		}
    }
	
	public function deleteFav($id)
    {
        $this->db->where('id', $id);
		 $this->db->delete('favSelection');
        return 'Record Deleted, Please Reload Page';
    }
	
////////store fav select//////////
public function storefavo($block=string,$device=string,$field=string)
    {
$tbl = 'favSelection';	
$block="'".$block."'";
$device="'".$device."'";
$field="'".$field."'";
$sel="select id from ".$tbl." where block in ($block) and device in ($device) and field in ($field)" ;
$qry = $this->db->query($sel);
if($qry->num_rows ==0)
        {
$sql="replace into ".$tbl." (block,device,field)values($block,$device,$field)";
    $query = $this->db->query($sql);
		$result = 'Selection saved succesfuly';
	}
	else{
	$result = 'Selection already exit in the List';	
	}
	return $result;
	}	
	
	public function getTableDayVariable($date_from=string,$date_to=string)
    {
		$tbl = '1min_data_today';
		$startTime=strtotime($date_from);
		$endTime=strtotime($date_to);		
	
$sql = "SELECT FROM_UNIXTIME(ts) as ts,ts as ts1,block,device,field,value FROM day_variable where ts >= $startTime and ts <= $endTime order by block,device,field,ts";

    $query = $this->db->query($sql);
	return $query->result();	
	}		
//--------------------------------------------------------------------------------------------------------------

	public function getDataDayVariable($date_from=string)
    {		
$test = explode(' ',$date_from);
$date_to = $test[0];		
$date_to = $date_to.' 23';
$startTime=strtotime($date_from);
$endTime=strtotime($date_to);
$sql="select FROM_UNIXTIME(ts) as ts,ts,block,device,field,value from day_variable WHERE (ts BETWEEN $startTime AND $endTime) order by block,device,field,ts";
    $query = $this->db->query($sql);
	return $query->result();
	}	
	
	
	
	public function getGraphData($block=string,$device=string,$field=string,$date_from=string,$date_to=string)
    {
	$startTime=strtotime($date_from);
	$endTime=strtotime($date_to) + 3599;
	$block1=""; $device1 = ""; $field1 = "";
	if($block=='all'){
		$blockfil= '';
	}
	else{
	$a=explode(',',$block);
	foreach($a as $v1)
		$block1 .= "'".$v1."',";	
	$blockname= rtrim($block1, ',');
	$blockfil= "and blockname IN($blockname)";	
	}
	
	if($device=='all'){
		$devicefil= '';
	}
	else{
	$b=explode(',',$device);
	foreach($b as $v2)
		$device1 .= "'".$v2."',";	
	$devicename= rtrim($device1, ',');	
	$devicefil= "and device_name IN($devicename)";	
	}
	if($field=='all'){
		$fieldfil= '';
	}
	else{
	$c=explode(',',$field);
	foreach($c as $v3)
		$field1 .= "'".$v3."',";	
	$fieldname= rtrim($field1, ',');
	$fieldfil= "and field IN($fieldname)";	
	}	
	
$test = explode(' ',$date_from);
$date_from = $test[0];
$test1 = explode(' ',$date_to);
$date_to = $test1[0];
$orderdate = explode('/', $date_from);
$syear_num = $orderdate[0];
$smonth_num = $orderdate[1];
$orderdate = explode('/', $date_to);
$eyear_num = $orderdate[0];
$emonth_num = $orderdate[1];
$smonthName = date("M", mktime(0, 0, 0, $smonth_num, 10));
$emonthName = date("M", mktime(0, 0, 0, $emonth_num, 10));
$c_month = date('M');
$today = date("Y/m/d");
if($today == $date_from && $today == $date_to){
$month_one = date('M_Y', mktime(0, 0, 0, date('m'), 1, date('Y')));
$month_one = '1min_data_today';	
$sql="SELECT FROM_UNIXTIME(insertedts) AS ts,insertedts AS ts1,blockname,device_name,field,value FROM ".$month_one." WHERE ts BETWEEN $startTime AND $endTime $blockfil $devicefil $fieldfil order by blockname,device_name,field,ts";
}
else{
if($smonthName == $c_month){
$month_one = date('M_Y', mktime(0, 0, 0, date('m'), 1, date('Y')));
$month_two = '';
$month_one = '1min_data';
$sql="select FROM_UNIXTIME(insertedts) as ts,insertedts as ts1,blockname,device_name,field,value from ".$month_one." WHERE ts BETWEEN $startTime AND $endTime $blockfil $devicefil $fieldfil order by blockname,device_name,field,ts";
}
else{
$month_one = date('M_Y', $startTime);
$month_two = date('M_Y', $endTime);
$month_one_table = '1min_data_'.$month_one;
if($emonthName == $c_month){
	$month_two_table = '1min_data';}
else{
	$month_two_table = '1min_data_'.$month_two;
}
if($month_one_table==$month_two_table){
	$sql="SELECT FROM_UNIXTIME(insertedts) AS ts,insertedts AS ts1,blockname,device_name,field,value FROM $month_one_table
WHERE ts BETWEEN $startTime AND $endTime $blockfil $devicefil $fieldfil ORDER BY blockname,device_name,field,ts";
}
else{
 $sql="select FROM_UNIXTIME(insertedts) as ts,insertedts as ts1,blockname,device_name,field,value from $month_one_table t1
where t1.ts >= $startTime $blockfil $devicefil $fieldfil
union
select FROM_UNIXTIME(insertedts) as ts,insertedts as ts1,blockname,device_name,field,value FROM $month_two_table t2
where t2.ts <= $endTime $blockfil $devicefil $fieldfil order by blockname,device_name,field,ts";
}

}
}	
//echo $sql; exit;
    $query = $this->db->query($sql);
	return $query->result();
	}
}
?>