<?php
include_once("config.php");
class InverterDCframeReport extends config{
	public function __construct(){
		parent::__construct();
		$this->inverterDCframeReport();
	}

function fetchDcframeEnergy($blk,$dev,$st,$sp,$typ)
{
	$sclqry="select count(*) as value from scada_latest_igate_data where ts > '".$st."' and ts < '".$sp."' and blockname='".$blk."' and (device_name like '%".$dev."%') and (device_name like '%SMU%') and field='COMMUNICATION_STATUS'";
	
	if($typ=='status')
	{
		$sclqry=$sclqry." and value='0' and  value!='nan'";
	}
	$sq=mysql_query($sclqry);
	$fetchv=mysql_fetch_array($sq);
	return $fetchv['value'];
}

public function inverterDCframeReport()
	{
		ob_start();
		session_start();
		if(($this->chr >=7)&&($this->chr < 20))
		{
		$msg=array();
		$shr="";
			if((isset($_REQUEST['block']))&&($_REQUEST['block']!=''))
			{
				$blks=stripslashes(trim($_REQUEST['block']));
				$shr=" and blockname='".$blks."'";
			}
		$qry="select blockname,device_name from device where type='Inverter' and status='1' $shr order by blockname,device_name";
		$sq=mysql_query($qry);
		$num=mysql_num_rows($sq);
		if($num>0)
		{
			while($fetch=mysql_fetch_array($sq))
			{
				$blk=$fetch['blockname'];
				$dvn=$fetch['device_name'];
				
				//Log inverter Start time///
				$sclqry1="SELECT *  FROM scada_latest_igate_data where ts > ".$this->startTime." AND ts < ".$this->endTime." AND blockname='".$blk."' AND device_name ='".$dvn."' AND `field` IN ('START_TIME')";
				$sq1=mysql_query($sclqry1);
				$num1=mysql_num_rows($sq1);
				if($num1!=0)
				{
					$fetchv=mysql_fetch_assoc($sq1);
					$value=$fetchv['value'];
					$insq="Update inverter_dcframe_report set StartTime='".$value."' where ts='".$this->startTime."' and Block='".$blk."' and Device='".$dvn."'";
					echo $insq."<br>";
					mysql_query($insq);
				}
				//Log inverter Stop time///
				$sclqry2="SELECT *  FROM scada_latest_igate_data where ts > ".$this->startTime." AND ts < ".$this->endTime." AND blockname='".$blk."' AND device_name ='".$dvn."' AND `field` IN ('STOP_TIME')";
				$sq2=mysql_query($sclqry2);
				$num2=mysql_num_rows($sq2);
				if($num2!=0)
				{
					$fetchv=mysql_fetch_assoc($sq2);
					$value=$fetchv['value'];
					$insq="Update inverter_dcframe_report set StopTime='".$value."' where ts='".$this->startTime."' and Block='".$blk."' and Device='".$dvn."'";
					echo $insq."<br>";
					mysql_query($insq);
				}
				//Log peak PAC////
				$sclqry3="SELECT *  FROM scada_latest_igate_data where ts > ".$this->startTime." AND ts < ".$this->endTime." AND blockname='".$blk."' AND device_name ='".$dvn."' AND `field` IN ('PAC_MAX')";
				$sq3=mysql_query($sclqry3);
				$num3=mysql_num_rows($sq3);
				if($num3!=0)
				{
					$fetchv=mysql_fetch_assoc($sq3);
					$value=$fetchv['value'];
					$insq="Update inverter_dcframe_report set PeakPAC='".$value."' where ts='".$this->startTime."' and Block='".$blk."' and Device='".$dvn."'";
					//echo $insq."<br>";
					mysql_query($insq);
				}
				//Log Energy generation////
				$sclqry4="SELECT *  FROM scada_latest_igate_data where ts > ".$this->startTime." AND ts < ".$this->endTime." AND blockname='".$blk."' AND device_name ='".$dvn."' AND `field` IN ('EAE_DAY')";
				$sq4=mysql_query($sclqry4);
				$num4=mysql_num_rows($sq4);
				if($num4!=0)
				{
					$fetchv=mysql_fetch_assoc($sq4);
					$value=$fetchv['value'];
					$insq="Update inverter_dcframe_report set EnergyGeneration='".$value."' where ts='".$this->startTime."' and Block='".$blk."' and Device='".$dvn."'";
					//echo $insq."<br><br>";
					mysql_query($insq);
				}
				///log smu status//
				
		$cnt=$this->fetchDcframeEnergy($blk,$dvn,$this->startTime,$this->endTime,'num');
		$smusts=$this->fetchDcframeEnergy($blk,$dvn,$this->startTime,$this->endTime,'status');
		$insq="Insert into inverter_dcframe_report (ReportDate,ts,Block,Device,TotalSMU,SmuConnected) values (now(),'".$this->startTime."','".$blk."','".$dvn."','".$cnt."','".$smusts."') ON DUPLICATE KEY UPDATE SmuConnected='".$smusts."',TotalSMU='".$cnt."'";
		//echo $insq."<br>";
		mysql_query($insq) or die(mysql_error());
			 }
		   }
		   else{require_once("create_deviceid.php");}	
		}
		else
		{
		  echo "Not Inserted...! Times up";
		}
		mysql_close($this->db);		
	}
}
$dcframereport = new InverterDCframeReport();
?>