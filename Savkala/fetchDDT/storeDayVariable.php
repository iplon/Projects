<?php
include_once("config.php");
class StoreDayVariable extends config{
	public  $table="day_variable";
	public function __construct(){
		parent::__construct();
		$this->storedayvariable();
	}

public function storedayvariable()
	 {	
	 	$min = date('i');
		if(($this->chr <= 23)&&($min < 50))
{
		$msg=array();
		$slq = "SELECT a.blockname,a.device_name,a.field,a.value from scada_latest_igate_data AS a join day_variable_fields AS b ON(a.field=b.field) WHERE b.status='1' AND a.ts >= $this->startTime AND a.ts < $this->endTime GROUP BY a.field, a.device_name, a.blockname order by a.blockname,a.device_name,a.field";
		$sQuery=mysql_query($slq);
		$num=mysql_num_rows($sQuery);
		if($num >0)
		{
			while($fetch=mysql_fetch_array($sQuery)) 
			{		
				$blk=stripslashes(trim($fetch['blockname']));
				$dev=stripslashes(trim($fetch['device_name']));
				$fld=stripslashes(trim($fetch['field']));
				$value=stripslashes(trim(str_replace("'","",$fetch['value'])));
				
				if($value=='nan' || $value=='NaN' || $value=='0'){
					$slq1 = "SELECT value from day_variable WHERE ts = $this->startTime and block='".$blk."' and device='".$dev."' and field='".$fld."' and !value='0'";
					$sQuery1=mysql_query($slq1);
					$num1=mysql_num_rows($sQuery1);
						if($num1==0){
							$val='0';	
							$msg[]="('".$this->startTime."','".$blk."','".$dev."','".$fld."','".$val."')";
						}
						else{
							$fetch1=mysql_fetch_array($sQuery1);
							$val=stripslashes(trim(str_replace("'","",$fetch['value'])));
							$msg[]="('".$this->startTime."','".$blk."','".$dev."','".$fld."','".$val."')";
						}
					}
					else{
					$val=$value;
					$msg[]="('".$this->startTime."','".$blk."','".$dev."','".$fld."','".$val."')";
				}
				}
			$data=implode(",",$msg);
			$insqry="REPLACE ".$this->table." (ts,block,device,field,value) VALUES".$data;
			echo $insqry . '<br>';
			$qry=mysql_query($insqry) or die(mysql_error());
		}
				
		///////////All inveter generation//////////
		$slq2 = "SELECT blockname,device_name,field,SUM(value) AS value from scada_latest_igate_data WHERE device_name LIKE '%INV%' AND device_name NOT LIKE '%SMU%' AND field = 'EAE_DAY' AND ts >= $this->startTime AND ts < $this->endTime";
		$sQuery2=mysql_query($slq2);
		$num2=mysql_num_rows($sQuery2);
		if($num2 >0)
		{
			while($fetch=mysql_fetch_array($sQuery2)) 
			{	
				$val=stripslashes(trim(str_replace("'","",$fetch['value'])));
				$msg2[]="('".$this->startTime."','ALL_BLOCK','ALL_INV','EAE_DAY','".$val."')";
			}
			$data2=implode(",",$msg2);
			$insqry2="REPLACE ".$this->table." (ts,block,device,field,value) VALUES".$data2;
			echo $insqry2 . '<br>';
			mysql_query($insqry2) or die(mysql_error());
		}
		if($insqry)
		{
		  echo "Inserted...!";
		}
		else
		{
		  echo "Not Inserted...!";
		}
		$msc=microtime(true)-$this->msc;
		echo $msc.' seconds'."<br>";
		mysql_close($this->db);		
			}
	 }
}
$alarms = new StoreDayVariable();
?>