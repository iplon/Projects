<?php
include_once("config.php");
class SystemArchStatus extends config{
	
	public  $table="system_architecture";
	
	public function __construct(){
		parent::__construct();
		$this->systemArchStatus();
	}

public function systemArchStatus()
	 {
		 $slq = "Select * from ".$this->table." order by block,device,field";
		$sQuery=mysql_query($slq);
		$num=mysql_num_rows($sQuery);
		if($num >0)
		{
			while($fetch=mysql_fetch_array($sQuery)) 
			{
			$blk=stripslashes(trim($fetch['block']));
			$dev=stripslashes(trim($fetch['device']));
			$fld=stripslashes(trim($fetch['field']));
			//$val=stripslashes(trim($fetch['value']));
			$sol=stripslashes(trim($fetch['solved']));
			$ack=stripslashes(trim($fetch['ack']));
			$priority=stripslashes(trim($fetch['priority']));
			$sl=mysql_query("Select blockname,device_name,field,value from scada_latest_igate_data where blockname= '".$blk."' and device_name = '".$dev."' and field  = '".$fld."' and value!='' and value!='null'");
			$numq=mysql_num_rows($sl);
			if($numq>0)
			{				
				while($fetchq=mysql_fetch_array($sl))
				{
				    $blkname=stripslashes(trim($fetchq['blockname']));
					$devname=stripslashes(trim($fetchq['device_name']));
					$field=stripslashes(trim($fetchq['field']));
					$val=stripslashes(trim($fetchq['value']));
					if($val=='0'){
						$sol='yes';
						$ack='yes';
						$val=0;
					}
					elseif($val=='1'){
						if($sol=='yes' && $ack=='yes'){
							$sol='no';
							$ack='no';
							$val=2;
						}
						elseif($sol=='no' && $ack=='yes'){
							$sol='no';
							$ack='yes';
							$val=1;
						}
						elseif($sol=='yes' && $ack=='no'){
							$sol='yes';
							$ack='yes';
							$val=0;
						}
						elseif($sol=='no' && $ack=='no'){
							$sol='no';
							$ack='no';
							$val=2;
						}
					}
					elseif($val== 'NAN' || $val== 'NaN' || $val== 'nan'){
						$sol='yes';
						$ack='yes';
						$val='NaN';
						}
					else{
						$sol='yes';
						$ack='yes';
						$val='0';
						}
							
				$sl2=mysql_query("Select priority from priority where block= '".$blk."' and device = '".$dev."' and field  = '".$fld."' and priority!='' and priority!='null'");
				$numq3=mysql_num_rows($sl2);
				if($numq3>0)
				{				
				while($fetchq2=mysql_fetch_array($sl2))
				{
					$priority=stripslashes(trim($fetchq2['priority']));		
					$array_data[]="('".$blkname."','".$devname."','".$field."','".$val."','".$sol."','".$ack."','".$priority."')";
				}}
					}
			}		
		}
		
									
		$data=implode(",",$array_data);
		
		$insq="Replace ".$this->table." (block,device,field,value,solved,ack,priority) values" .$data;
		echo $insq;
		$qry=mysql_query($insq) or die(mysql_error());

		
	}
		mysql_close($this->db);		
			}
}
$alarms = new SystemArchStatus();
?>