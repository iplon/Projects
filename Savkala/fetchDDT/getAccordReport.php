<?php
include_once("config.php");
class Getaccordreport extends config{
	public function __construct(){
		parent::__construct();
		$this->getaccordreport();
	}
public function getaccordreport()
	{
		$arrdv=explode("," , $this->incommers);
		$arrdisp=explode("," , $this->section);
		$arrfld=array("EAE");
		
		$lastup="select max(timeinhour) as mxts from accord_em_report where ReportDate='".$this->startTime."'";
		$lq=mysql_query($lastup);
		$ftchmx=mysql_fetch_array($lq);
		$numl=$ftchmx['mxts'];
		if($numl!='')
		{
		 $this->chr = $numl;	
		}
		if(($this->chr >=6)&&($this->chr < 19))
		{
			$startTime = mktime($this->chr, 0, 0, $this->slmnth, $this->sdd, $this->crtyr);
			for($i=0;$i<count($arrdv);$i++)
			{
				set_time_limit(60);
				for($j=0;$j<count($arrfld);$j++)
				{
					$sclqry="SELECT ts,blockname,field,(MAX(value)-MIN(value)) as value,HOUR(FROM_UNIXTIME(ts)) AS `hour`,device_name, MIN(value) AS minval FROM 1min_data_today  where ts >= ".$startTime." and ts < ".$this->endTime." and device_name ='".$arrdv[$i]."' and field = 'EAE' and value is not null group by HOUR(FROM_UNIXTIME(ts))"; 
					//echo $sclqry."<br>";
					$sq=mysql_query($sclqry) or die(mysql_error());
					$num=mysql_num_rows($sq);
					if($num!=0)
					{
						while($fetchv=mysql_fetch_array($sq))
						{
						$dvn=$arrdv[$i];
						$disp=$arrdisp[$i];
						$fld=$arrfld[$j];
						$lstts=$fetchv['ts'];
						$minval=$fetchv['minval'];
						if($minval==0){$val=0;}
						else{$val=$fetchv['value'];}
						
						$hr=$fetchv['hour'];
						$insq="REPLACE accord_em_report (ReportDate,Device,field,DisplayName,lastts,value,timeinhour) values ('".$this->startTime."','".$dvn."','".$fld."','".$disp."','".$lstts."','".$val."','".$hr."')";
						$in=mysql_query($insq);
						echo $insq."<br>";
						}
					}
					$sclqry="SELECT ts,Max(value+0.0) as value,HOUR(FROM_UNIXTIME(ts)) as hour FROM 1min_data_today where ts >= ".$startTime." and ts < ".$this->endTime." and device_name ='".$arrdv[$i]."' and field = 'PAC' and value is not null and value >0 group by HOUR(FROM_UNIXTIME(ts))";  
					//echo $sclqry."<br>";
					$sq=mysql_query($sclqry) or die(mysql_error());
					$num=mysql_num_rows($sq);
					if($num!=0)
					{
						while($fetchv=mysql_fetch_array($sq))
						{
						$dvn=$arrdv[$i];
						$disp=$arrdisp[$i];
						$fld='PAC';
						$lstts=$fetchv['ts'];
						$val=$fetchv['value'];
						$hr=$fetchv['hour'];
						$insq="update accord_em_report set peak_pac='".$val."' where ReportDate='".$this->startTime."' and Device= '".$dvn."' and timeinhour='".$hr."'";
						$in=mysql_query($insq);
						echo $insq."<br>";
						}
					}
				}
			}
			$msc=microtime(true)-$this->msc;
			echo $msc.' seconds'."<br>";
		}
		else
		{
			echo "Not loaded";
		}
		mysql_close($this->db);		
	}
}
$arrayYield = new Getaccordreport();
?>