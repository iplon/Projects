<?php
include_once("config.php");
class GetSystemAlarms extends config{
	
	public  $table="alarm";
	
	public function __construct(){
		parent::__construct();
		$this->getsystemalarms();
	}
	
	
public function getsystemalarms()
	 {
ob_start();
$arrfield="COMMUNICATION_STATUS";
$type="";
$msg=array();
$fld=array('CHANNEL1_STATUS','CHANNEL2_STATUS','CHANNEL3_STATUS','COMMUNICATION_STATUS','CHANNEL4_STATUS','CHANNEL5_STATUS','FO1_LINK','FO2_LINK','iGATE1_LINK','iGATE2_LINK','IO_LINK');
 $fields=implode(',', $fld);
echo $slq = "Select ts,blockname,device_name,field,value from scada_latest_igate_data where  field IN ('COMMUNICATION_STATUS','FO1_LINK','FO2_LINK') and blockname!='' and device_name!='' and ts!='0'";

$sQuery=mysql_query($slq);
$num=mysql_num_rows($sQuery);
if($num >0)
{
		while($fetch=mysql_fetch_array($sQuery)) 
		{
			$devname=stripslashes(trim($fetch['device_name']));
			$ts=stripslashes(trim($fetch['ts']));
			$blk=stripslashes(trim($fetch['blockname']));
			$fld=stripslashes(trim($fetch['field']));
			$val=stripslashes(trim($fetch['value']));
			
				if (preg_match("/LINK/i", $fld)) {
				 $type="IO";
				}
				elseif (preg_match("/INV/i", $devname)) {
				 $type="Inverter";
				}
				elseif(preg_match("/SMU/i", $devname)){
				 $type="Smu";
				}
				elseif(preg_match("/IoModule/i", $devname)){
				 $type="IoModule";
				}
				elseif(preg_match("/CR_EM/i", $devname))
				{
				 $type ="CR_EM";
				}
				elseif(preg_match("/ELMEASURE/i", $devname))
				{
					$type ="Elmeasure";
				}
				elseif(preg_match("/CR_IO/i", $devname))
				{
					$type="CR_IO";
				}
				elseif(preg_match("/WS/i", $devname))
				{
					$type="WS";
				}
				
				if(($val=='1' && $fld=='COMMUNICATION_STATUS') || ($val=='2' && preg_match("/LINK/i", $fld)))
				{
					$msg[]="(now(),now(),'".$ts."','".$type."','".$blk."','".$devname."','".$fld."','system','".$val."')";
				}
				elseif($val=='0')
				{
					$sl=mysql_query("select id from ".$this->table." where type='".$type."' and block='".$blk."' and device_name='".$devname."' and field='".$fld."' and altype='system' and solved_datetime='0000-00-00 00:00:00' and status='0'");
					$numq=mysql_num_rows($sl);
					if($numq>0)
					{
						$fetchq=mysql_fetch_array($sl);
						$ids=$fetchq['id'];
						echo $insqry="Update ".$this->table." set solved_datetime=now() where id='".$ids."'";
						$qry=mysql_query($insqry) or die(mysql_error());
					}
					mysql_free_result($sl);
				}
		}
	
	$data=implode(",",$msg);
	echo $insqry="insert IGNORE into ".$this->table." (date,time,ts,type,block,device_name,field,altype,error_txt) values ".$data;
    $qry=mysql_query($insqry);
	if($qry)
	{
		/* Maintain the data with 100000 */
		$chkNum='100000';
		$sQ = "SELECT COUNT(`id`) as tot FROM ".$this->table." where altype='system'";
		$rResult = mysql_query($sQ); 
		$aResult = mysql_fetch_array($rResult);
		$tRecord=$aResult['tot'];
		if($tRecord>$chkNum)
		{
			$lmt=$tRecord-$chkNum;
			$dlq="DELETE FROM ".$this->table." where altype='system' ORDER BY id LIMIT ".$lmt."";
			echo $dlq."<br>";
			$rdR = mysql_query($dlq); 
		}
		mysql_free_result($rResult);
		echo "sucessfully inserted...!";
	}
	else
	{
		echo "Not inserted...!";
	}
  }
  
  
  /////*system architecture start*/////
		$slq = "Select block,device,field,value,solved,ack from system_architecture order by block,device,field";
		$sQuery=mysql_query($slq);
		$num=mysql_num_rows($sQuery);
		if($num >0)
		{
			while($fetch=mysql_fetch_array($sQuery)) 
			{
			$blk=stripslashes(trim($fetch['block']));
			$dev=stripslashes(trim($fetch['device']));
			$fld=stripslashes(trim($fetch['field']));
			$val=stripslashes(trim($fetch['value']));
			$sol=stripslashes(trim($fetch['solved']));
			$ack=stripslashes(trim($fetch['ack']));
			$sl=mysql_query("Select blockname,device_name,field,value from scada_latest_igate_data where blockname= '".$blk."' and device_name = '".$dev."' and field  = '".$fld."' and blockname!='' and device_name!='' and ts!='0'");
			$numq=mysql_num_rows($sl);
			if($numq>0)
			{				
				while($fetchq=mysql_fetch_array($sl))
				{
					$blkname=stripslashes(trim($fetchq['blockname']));
					$devname=stripslashes(trim($fetchq['device_name']));
					$field=stripslashes(trim($fetchq['field']));
					$val=stripslashes(trim(str_replace("'","",$fetchq['value'])));
					if($val=='0'){
						$sol='yes';
						$ack='yes';
						$val=='0';
					}
					/*elseif($val=='2'){
						$sol='no';
						$ack='yes';
						$val=='0';
					}*/
					elseif($val=='1' || $val=='nan' || $val=='NaN'){
						if($ack=='yes' && $sol='yes'){
							$sol='no';
							$ack='no';
							$val=='1';
						}
						elseif($ack=='yes' && $sol='no'){
							$sol='yes';
							$ack='no';
							$val=='2';
						}
					}
					$msg2[]="('".$blkname."','".$devname."','".$field."','".$val."','".$sol."','".$ack."')";
					}
				}		
			}
		$data2=implode(",",$msg2);
		$insq="Replace system_architecture (block,device,field,value,solved,ack) values".$data2;
		echo "<br>".$insq."<br>";
		$qry=mysql_query($insq) or die(mysql_error());
	}			 
  //////*system architecture end///
  
mysql_free_result($sQuery);
$msc=microtime(true)-$this->msc;
echo $msc.' seconds'."<br>";
	mysql_close($this->db);		
	}
}
$systemalarms = new GetSystemAlarms();
?>
