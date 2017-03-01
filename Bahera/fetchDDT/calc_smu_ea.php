<?php
include_once("config.php");
class Calc_smu_ea extends config{
	public function __construct(){
		parent::__construct();
		$this->calcsmuea();
	}
	
	public function calcsmuea()
	{	
		$msg=array();
		$slq = "SELECT blockname,device_name,field,value from scada_latest_igate_data WHERE ts >= $this->startTime AND ts < $this->endTime AND field = 'SMU_COMP' order by blockname,device_name";
		$sQuery=mysql_query($slq);
		$num=mysql_num_rows($sQuery);
		if($num >0)
		{
			while($fetch=mysql_fetch_array($sQuery)) 
			{		
				$blk=stripslashes(trim($fetch['blockname']));
				$dev=stripslashes(trim($fetch['device_name']));
				$fld=stripslashes(trim($fetch['field']));
				$val=stripslashes(trim(str_replace("'","",$fetch['value'])));
				$msg[]="('".$this->startTime."','".$blk."','".$dev."','".$val."')";
			}
			$data=implode(",",$msg);
			//$insqry="REPLACE ".$this->table." (ts,block,device,field,value) VALUES".$data;
			$insqry="REPLACE smucomparison_data (ts,blockname,device_name,smustatus) values $data";
			echo $insqry . '<br>';
			$qry=mysql_query($insqry) or die(mysql_error());
		} 			
mysql_close($this->db);	
}
}
$smuea = new Calc_smu_ea();
?>