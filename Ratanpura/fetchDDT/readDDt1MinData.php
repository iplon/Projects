<?php
date_default_timezone_set('Asia/Kolkata');
$msc=microtime(true);
//include_once("db_connect.php");
$string = file_get_contents("data.json");
$json = json_decode($string, true);
$hostname=$json['db_credential']['hostname'];
$username=$json['db_credential']['username'];
$password=$json['db_credential']['password'];
$dbname=$json['db_credential']['dbname'];
$connect = mysql_connect($hostname,$username,$password);
if (!$connect) {die('Could not connect to MySQL: ' . mysql_error()); 
} 
$db =mysql_select_db($dbname,$connect);	
$nowtime=time();
$slmnth=date("m");
$crtyr=date("Y");
$sdd=date("d");
$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
$endTime = mktime(0, 0, 0, $slmnth, $sdd + 1, $crtyr);

function fetchFldIds($blk,$dev,$fld)
{
	$value=0;
	$sclqry="select blk_dv_fld_id from fields WHERE blockname='".$blk."' and device_name='".$dev."' and field='".$fld."'";
	$ds2 = mysql_query($sclqry); 	
	if(mysql_num_rows($ds2) > 0)
	{ 
		$row_ds2 = mysql_fetch_array($ds2);
		$value=$row_ds2['blk_dv_fld_id'];
	}
	else
	{
	require_once("create_fieldid.php");
	}
	return $value;
}

$lst_day=date("t");
$chr = date('H');
$min = date('i');
$format=1;
$msg=array();
$msg1=array();
$sqlqry="select ts,blockname,device_name,field,value,format from scada_latest_igate_data where ts >= $startTime and ts < $endTime";
$qry= mysql_query($sqlqry);
$num=mysql_num_rows($qry);
if($num>0)
{
	
	while($fetch=mysql_fetch_array($qry))
	{
		set_time_limit(60);
		$ts=$fetch['ts'];
		$blk=$fetch['blockname'];
		$dve=$fetch['device_name'];
		$fld=$fetch['field'];
		$val=$fetch['value'];
		$format=$fetch['format'];
		$blk_dv_fld_id=fetchFldIds($blk,$dve,$fld);
		if($format!=10)
		{
		  	$val=str_ireplace("nan","NULL",$val);
			if($val=='NULL')
			{
			$msg[]="('".$ts."','".$blk_dv_fld_id."',".$val.",'".$nowtime."')";
			}
			else
			{
			$msg[]="('".$ts."','".$blk_dv_fld_id."','".$val."','".$nowtime."')";	
			}
		}
	}
	
	$data=implode(",",$msg);
	$insq="Replace into 1min_data_unique (ts,blk_dv_fld_id,value,insertedts) values  ".$data;
	echo $insq."<br>";
	$insertsq=mysql_query($insq) or die(mysql_error());
	
	if(($chr=='23')&&($min>='55'))
	{
		$trc="truncate table 1min_data_today_unique";
		$trnt=mysql_query($trc) or die(mysql_error());
		
	}
	else
	{
		$insq2="Replace into 1min_data_today_unique (ts,blk_dv_fld_id,value,insertedts) values  ".$data;
		$insertsq2=mysql_query($insq2) or die(mysql_error());
		if(($chr=='00')&&($min<='15'))
		{
			mysql_query("ANALYZE TABLE 1min_data_today_unique");
			mysql_query("OPTIMIZE TABLE 1min_data_today_unique");
			mysql_query("FLUSH TABLE 1min_data_today_unique");
		}
	}
	
	/* For FIFO Use*/
	if(($lst_day==$sdd)&&($chr=='23')&&($min>='55'))
	{
		$renametbl="1min_data_unique";
		$newname="1min_data_unique_".date("M_Y");
		$renm="RENAME TABLE `" . $renametbl . "` TO `" . $newname . "`";
		$reqry=mysql_query($renm) or die(mysql_error());
		if($reqry)
		{
			$csql = "CREATE TABLE IF NOT EXISTS `1min_data_unique` (
			`ts` int(14) NOT NULL,
			`blk_dv_fld_id` int(10) NOT NULL,
			`value` double DEFAULT NULL,
			`insertedts` int(14) NOT NULL,
			PRIMARY KEY (`ts`,`blk_dv_fld_id`),
			KEY `insertedts` (`insertedts`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC";
			mysql_query($csql);
		}
	}
}
if($insertsq)
{
  echo "Inserted...!";
}
else
{
  echo "Not Inserted...!";
}
mysql_free_result($qry);
$msc=microtime(true)-$msc;
echo $msc.' seconds'."<br>";
mysql_close($connect);
?>