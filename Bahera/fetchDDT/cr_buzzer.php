<?php
ini_set('display_errors', 1);
include_once("config.php");
class Cr_buzzer extends config{
	
	public function __construct(){
		parent::__construct();
		$this->crbuzzer();
	}
/*### For Enable Control Room Buzzer ###*/
public function getFire()
	{
		$qy1="select alarm_field from alarm_fields where type = 'fire' and status = '1'";
		$qrysl= mysql_query($qy1);
		$numsl=mysql_num_rows($qrysl);
		if($numsl!=0)
		{
			while($ftq=mysql_fetch_assoc($qrysl, MYSQLI_ASSOC)){
				$fields[]=$ftq['alarm_field'];
			} 
			$fields = implode(',',$fields);
			return $fields = "'".str_replace(",","','",$fields)."'";
		}
		}
public function crbuzzer()
	{
$cSession = curl_init();
$qy1="select id from scada_latest_igate_data where device_name IN('CR_IO') and field='FIRE_ALARM_CMD' limit 1";
$qrysl= mysql_query($qy1);
$numsl=mysql_num_rows($qrysl);
if($numsl!=0)
{
	$ftq=mysql_fetch_array($qrysl);
	$id=$ftq['id'];
	$cSession = curl_init();
		$fire_fields=$this->getFire();
		$sqlqry2="select id from alarm where device_name like '%Io%' and field IN ($fire_fields) and altype='fire' and ack_datetime='null'";
	$qry2= mysql_query($sqlqry2);
	$num2=mysql_num_rows($qry2);
	if($num2>0)
	{
	 $url="http://localhost:3000/scaback0001/setProp?id=".$id."&val=1";
	}
	else{
	 $url="http://localhost:3000/scaback0001/setProp?id=".$id."&val=2";}
	}
	else{
	 $url="http://localhost:3000/scaback0001/setProp?id=".$id."&val=2";}
	echo $url;
	curl_setopt($cSession,CURLOPT_URL,$url);
	curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($cSession,CURLOPT_HEADER, false);
	curl_setopt($cSession,CURLOPT_TIMEOUT,30);
	$result=curl_exec($cSession);
	curl_close($cSession);
//}
mysql_close($this->db);		
	}
}
$crbuzzer = new Cr_buzzer();
?>