<?php
include_once("config.php");
class GetPgrReport extends config{
	public function __construct(){
		parent::__construct();
		$this->getPgrReport();
	}

public function getPgrReport()
{
	$this->startTime = mktime(0, 0, 0,  $this->slmnth,  $this->sdd,  $this->crtyr);
	$this->startTimeChr = mktime($this->chr-1, 0, 0,  $this->slmnth,  $this->sdd,  $this->crtyr);
	$this->endTime = mktime($this->chr+1, 0, 0,  $this->slmnth,  $this->sdd,  $this->crtyr);

	//$dev=array('CR1_EM01','CR2_EM01','CR_EM');
	$dev=array_filter(array($this->lf));
	foreach($dev as $device){
		$fld=array("EAE_DAY","EAE","PAC");
		foreach($fld as $field){
			if($field=='EAE'){$cal='(MAX(ABS(value))-MIN(ABS(value)))';}
			else{$cal='MAX(ABS(value))';}
			//$hr=$this->chr-1;
			//$hour=array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
			$hour=array($this->chr-1,$this->chr);
			foreach($hour as $hr){
				$gap1='00_15';$gap2='15_30';$gap3='30_45';$gap4='45_59';
				$gaps=array($gap1,$gap2,$gap3,$gap4);
				foreach($gaps as $gapps){
					$betwn=explode('_',$gapps);
					if($betwn[1]=='59'){
						$hr2=$hr+1;
						$inc='OR (HOUR(FROM_UNIXTIME(`insertedts`)) = "'.$hr2.'" AND MINUTE(FROM_UNIXTIME(`insertedts`)) = 00)';}
					else{$inc='';}

						echo $sclqryt="SELECT GROUP_CONCAT(`blk_dv_fld_id` ORDER BY blockname, device_name, field separator ',') FROM fields_num WHERE field IN('".$field."') AND device_name IN('".$device."')";
						
						$sql = mysql_query($sclqryt, $this->db);
						$sclqryt=mysql_result($sql,0);
						mysql_free_result($sql);

						$sclqry="SELECT a.blockname,a.device_name,a.field,b.insertedts AS ts,($cal) AS value FROM fields_num AS a JOIN 1min_data_today AS b ON (a.blk_dv_fld_id=b.blk_dv_fld_id) WHERE b.blk_dv_fld_id IN($sclqryt) AND b.insertedts>=$this->startTimeChr AND b.insertedts<$this->endTime AND (((MINUTE(FROM_UNIXTIME(b.insertedts)) BETWEEN $betwn[0] and $betwn[1]) AND HOUR(FROM_UNIXTIME(b.insertedts))=$hr)$inc) ORDER BY FIELD (a.blk_dv_fld_id, $sclqryt),b.insertedts";
						//$sclqry="select blockname,device_name,field,insertedts as ts,($cal) AS value from 1min_data_today where `insertedts` >= $this->startTimeChr and `insertedts` <= $this->endTime AND field IN('".$field."') AND device_name IN('".$device."') and (((MINUTE(FROM_UNIXTIME(`insertedts`)) BETWEEN $betwn[0] and $betwn[1])  AND HOUR(FROM_UNIXTIME(`insertedts`)) = $hr) $inc ) and value NOT IN('NULL','NAN','nan') order by field,ts";
						echo "<br><br>".$sclqry."<br>";
						$sql = mysql_query($sclqry, $this->db);
						if(mysql_num_rows($sql) > 0)
						{
							while($row_ds2 = mysql_fetch_array($sql,MYSQL_ASSOC))
							{
								$ts = $row_ds2['ts'];
								$blk=$row_ds2['blockname'];
								$dev = $row_ds2['device_name'];
								$fld=$row_ds2['field'];
								$val = $row_ds2['value'];
								$msg[]="('".$ts."','".$blk."','".$dev."', '".$fld."','".$val."')";
							}
						}
					}
				}
			}
		}
	$data=implode(",",$msg);
	$insq="replace plant_generation_report (`ts`, `block`, `device`, `field`, `value`) VALUES ".$data;
	$in=mysql_query($insq);
	echo $insq."<br>";
	$msc=microtime(true)-$this->msc;
	echo $msc.' seconds'."<br>";
	if($in)
	{
		echo "sucessfully inserted...!";
	}
	else
	{
		echo "Not inserted...!";
	}

	mysql_close($this->db);
	}
}
$hourlyreport = new GetPgrReport	();
?>
