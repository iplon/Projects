<?php
ob_start();
include_once("config.php");
class ReadDDt extends config{
	public function __construct(){
		parent::__construct();
		$this->readDDt();
	}
	
 public function readDDt()
	{
$connect = mysql_connect($this->hostname,$this->username,$this->password,false,128);
if (!$connect) { 
    die('Could not connect to MySQL: ' . mysql_error()); 
} 
$cid =mysql_select_db($this->dbname,$connect);
$ct='"';
$ltr='\r\n';
$cSession = curl_init(); 
$filename="/var/www/".$this->plantname."/fetchDDT/csv/Scaback.csv";
$url="http://localhost:3000/scaback0001/listById";
curl_setopt($cSession,CURLOPT_URL,$url);
curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
curl_setopt($cSession,CURLOPT_HEADER, false); 
curl_setopt($cSession,CURLOPT_TIMEOUT,50);
$result=curl_exec($cSession);
curl_close($cSession);

$getfile=file_put_contents("csv/Scaback.csv", $result);
if($getfile)
{
	$qrylt="LOAD DATA LOCAL INFILE '".$filename."' REPLACE INTO TABLE scada_latest_igate_data fields terminated by ',' enclosed by '".$ct."' lines terminated by '".$ltr."' IGNORE 1 LINES (id, value, format, @ts, ip, path, blockname, idoffset, masterId, device_name, field) SET ts='".$this->nowtime."'";
	$ins=mysql_query($qrylt) or die(mysql_error());
	
	
	$msc=microtime(true)-$this->msc;
	echo $msc.' seconds'."<br>";
	if($ins)
	{
		echo "Inserted...!";
	}
	else
	{
		echo "Not Inserted...!";
	}
}
else
{
	echo "cant fetch value from DDT...!";
}
	 mysql_close($this->db);	
	}
}
$readDDt = new ReadDDt();
?>
