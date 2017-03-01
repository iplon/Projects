<?php
include_once("config.php");
class HourlyInverterReport extends config{
	public function __construct(){
		parent::__construct();
		$this->hourlyInverterReport();
	}

public function hourlyInverterReport()
	  {
if(($this->chr >=6)&&($this->chr < 20))
{
$this->startTime = mktime(0, 0, 0,  $this->slmnth,  $this->sdd,  $this->crtyr);
$this->startTimeChr = mktime(6, 0, 0,  $this->slmnth,  $this->sdd,  $this->crtyr);
$this->endTime = mktime(20, 0, 0,  $this->slmnth,  $this->sdd,  $this->crtyr);

$msg=array();
$msg1=array();
$query2="SELECT ts,blockname,field,group_concat(value ORDER BY ts) as value,HOUR(FROM_UNIXTIME(ts)) AS `hour`,device_name as display FROM `inverterdata_15mints`
		WHERE ts >= $this->startTimeChr and ts < $this->endTime and (field='EAE') and
		(device_name='Inverter1' or device_name='Inverter2' or device_name='Inverter3' or device_name='Inverter4' or device_name='Inverter5' or device_name='Inverter6'
		or device_name='Inverter7')
		group by blockname,device_name,hour";
		echo $query2;
$ds2 = mysql_query($query2) or die(mysql_error());
        //echo "<br>" .$query2  . "<br>";

        $hur = 0;
        $disp = null;
        while ($row_ds2 = mysql_fetch_array($ds2)) {

			$blk=$row_ds2['blockname'];
			$fld=$row_ds2['field'];
			$vals = $row_ds2['value'];
			$arrv=array();
			$arrv=explode(",",$vals);
			$nvl=count($arrv)-1;
			$min=$arrv[0];
			$max=$arrv[$nvl];
			$value = 0;
			if($max>=$min)
			{
			  $value=$max-$min;
			}
			// if($value>4)
			// {
			 // $value = 0;
			// }
			$hur = $row_ds2['hour'];
			$disp = $row_ds2['display'];
			$sts = $row_ds2['ts'];

        $msg[]="('".$this->startTime."','".$blk."','".$disp."', '".$fld."','".$hur."','".$sts."','".$value."')";
        }
 //$query3="select a.blockname,a.field,a.value as val,HOUR(FROM_UNIXTIME(ts)) AS `hour`,a.ts FROM (SELECT ts,blockname,field,(0.0+value) as value FROM `inverterdata_15mints` WHERE ts >= $this->startTimeChr and ts < $this->endTime and (blockname='WS') and (device_name='WS') and (field='Solar_Radiation') order by ts desc) as a group by hour";
	$sclqryt="SELECT GROUP_CONCAT(`blk_dv_fld_id` ORDER BY blockname, device_name, field separator ',') FROM fields_num WHERE field='SOLAR_RADIATION' AND device_name='CR_WS'";
	$sql = mysql_query($sclqryt, $this->db);
	$sclqryt=mysql_result($sql,0);
	mysql_free_result($sql);

	$query3="SELECT a.blockname,a.field,b.value AS val,HOUR(FROM_UNIXTIME(b.insertedts)) AS `hour`,b.insertedts AS ts FROM fields_num AS a JOIN 1min_data_today AS b ON (a.blk_dv_fld_id=b.blk_dv_fld_id) WHERE a.blk_dv_fld_id IN ($sclqryt) AND b.insertedts>=$this->startTimeChr AND b.insertedts<$this->endTime GROUP BY HOUR(FROM_UNIXTIME(b.insertedts)) ORDER BY b.insertedts";
	$ds3 = mysql_query($query3) or die(mysql_error());
        //echo "<br>" .$query3  . "<br>";
        $value3 = 0;
        $hur3 = 0;
        $disp3 = 'Irradiation';
        while ($row_ds3 = mysql_fetch_array($ds3)) {

			$blk3=$row_ds3['blockname'];
			$fld3=$row_ds3['field'];
			$value3 = $row_ds3['val'];
			$hur3 = $row_ds3['hour'];
			$sts3 = $row_ds3['ts'];

        $msg1[]="('".$this->startTime."','".$blk3."','".$disp3."', '".$fld3."','".$hur3."','".$sts3."','".$value3."')";
        }
	$arrjoin=array_merge($msg,$msg1);
	$data1=implode(",",$arrjoin);
	$insq="replace hourly_compressedvalue (`ts`, `block`, `display`, `field`, `hour`, `hourts`, `value`) VALUES ".$data1;
	$in=mysql_query($insq);
	echo $insq.' seconds'."<br>";
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
}
else
{
	echo "Not loaded";
}
	mysql_close($this->db);
	}
}
$hourlyreport = new HourlyInverterReport();
?>
