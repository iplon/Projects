<?php
include_once("config.php");
ini_set('display_errors', 1);
class Csv_process extends config{
	public function __construct(){
		parent::__construct();
		$this->csvprocess();
	}
public function csvprocess() {
	$lst_day=date("t");
	$min = date('i');
	$this->now = mktime($this->chr, $min, 0,  $this->slmnth,  $this->sdd,  $this->crtyr)-60;
	$sclqry="select DISTINCT FROM_UNIXTIME(insertedts,'%Y-%m-%d %H:%i') AS ts from 1min_data_today order by insertedts";
	$ts = mysql_query($sclqry, $this->db);
	$sclqry="select value from scada_latest_igate_data WHERE `blockname` = 'CR' AND `device_name` = 'WS' AND `field` = 'SOLAR_RADIATION'";
	$sr = mysql_query($sclqry, $this->db);
	$sclqry="select value from scada_latest_igate_data WHERE `blockname` = 'CR' AND `device_name` = 'WS' AND `field` = 'AMBIENT_TEMP'";
	$am = mysql_query($sclqry, $this->db);
	$sclqry="select value from scada_latest_igate_data WHERE `blockname` = 'CR' AND `device_name` = 'CR_EM01' AND `field` = 'PAC'";
	$pac = mysql_query($sclqry, $this->db);

	//$result[]=array("TS","SOLAR_RADIATION","AMBIENT_TEMP","PAC");
	$ts = $this->now;
	$tmpsr = mysql_fetch_array($sr,MYSQL_ASSOC);
	$tmpam = mysql_fetch_array($am,MYSQL_ASSOC);
	$tmppac = mysql_fetch_array($pac,MYSQL_ASSOC);
	$rlt['sr'] = $tmpsr['value'];
	$rlt['am'] = $tmpam['value'];
	$rlt['pac'] = $tmppac['value'];
	$rlt['sr'] = str_ireplace("nan","NULL",$rlt['sr']);
	$rlt['am'] = str_ireplace("nan","NULL",$rlt['am']);
	$rlt['pac'] = str_ireplace("nan","NULL",$rlt['pac']);
	$result[]=array_values($rlt);
	$tmprlt[] = "('".$ts."','".$rlt['sr']."','".$rlt['am']."','".$rlt['pac']."')";
	$data=implode(",",$tmprlt); 
	$sclqry="REPLACE INTO forecasting_CSV (insertedts,SOLAR_RADIATION,AMBIENT_TEMP,PAC) values ".$data;
	$sql = mysql_query($sclqry, $this->db); 
	//mysql_free_result($sql);
}
}
$plantov = new Csv_process();
?>