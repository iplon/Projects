<?php
include_once("config.php");
class calc_dc_energy extends config{
	
	public function __construct(){
		parent::__construct();
		$this->caldcenergy();
	}
	
	//## Fetch MIN Dc Energy ##//
	public function firstDcEnergy($blk,$dev,$st,$sp,$table)
	{
		$value=0;
		$sclqry="select MinEnergy as value from ".$table." where ts='".$st."' and Block='".$blk."' and Device='".$dev."' and MinEnergy!='nan' and MinEnergy >0 limit 0,1";
		//echo $sclqry."<br>";
		$sq=mysql_query($sclqry);
		$numq=mysql_num_rows($sq);
		if($numq!=0)
		{
			$fetchv=mysql_fetch_assoc($sq);
			$value=$fetchv['value'];
		}
		else
		{
			$sclqry="select ts,value+0.0 as value from scada_latest_igate_data where ts >= '".$st."' and ts < '".$sp."' and blockname='".$blk."' and device_name='".$dev."' and field='EA+' and value!='nan' and value >0 limit 0,1";
			$sq=mysql_query($sclqry);
			$numq=mysql_num_rows($sq);
			if($numq!=0)
			{
				$fetchv=mysql_fetch_assoc($sq);
				$value=$fetchv['value'];
				$insq="Insert into inverter_dcframe_report (ReportDate,ts,Block,Device,MinEnergy) values (now(),'".$st."','".$blk."','".$dev."','".$value."') ON DUPLICATE KEY UPDATE MinEnergy='".$value."'";
				mysql_query($insq) or die(mysql_error());
			}
		}
		return $value;
		
	}
	
	//## Fetch Max Dc Energy ##//
	public function fetchDcframeEnergy($blk,$dev,$st,$sp,$table)
	{
		$value=0;
		$sclqry="select ts,value+0.0 as value from ".$table." where ts > '".$st."' and ts < '".$sp."' and blockname='".$blk."' and device_name='".$dev."' and field='EA+' and value!='nan' and value >0 limit 0,1";
		$sq=mysql_query($sclqry);
		$numq=mysql_num_rows($sq);
		if($numq!=0)
		{
			$fetchv=mysql_fetch_assoc($sq);
			$value=$fetchv['value'];
		}
		return $value;
		
	}
	
	public function caldcenergy()
	{
		$shr="";
		if((isset($_REQUEST['block']))&&($_REQUEST['block']!=''))
		{
			$blks=stripslashes(trim($_REQUEST['block']));
			$shr=" and blockname='".$blks."'";
		}
	
		$msg=array();
		$qry1="select blockname,device_name from device where type='Inverter'and status='1' $shr order by deviceid";
		$sq1=mysql_query($qry1);
		$num1=mysql_num_rows($sq1);
		if($num1>0)
		{
			while($fetch=mysql_fetch_array($sq1))
			{
				set_time_limit(60);
				$blk=$fetch['blockname'];
				$dvn=$fetch['device_name'];
				$minv=$this->firstDcEnergy($blk,$dvn,$this->startTime,$this->endTime,'inverter_dcframe_report');
				$max=$this->fetchDcframeEnergy($blk,$dvn,$this->startTime,$this->endTime,'scada_latest_igate_data');
				$engy=0;
				if(($max>=$minv)&&($minv>0))
				{
					$engy=$max-$minv;
					$insq="Update inverter_dcframe_report set MaxEnergy='".$max."',EnergyGeneration='".$engy."' where ts='".$this->startTime."' and Block='".$blk."' and Device='".$dvn."'";
					echo $insq."<br>";
					mysql_query($insq) or die(mysql_error());	
				}
			}
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

$dcenergy = new calc_dc_energy();	
?>