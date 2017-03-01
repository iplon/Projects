<?php
ob_start();
include_once("config.php");
class ReadDDt extends config	{
	public function __construct()	{
		parent::__construct();
		$this->readDDt();
	}

	public function readDDt()	{
		$connect = mysql_connect($this->hostname,$this->username,$this->password,false,128);
		if (!$connect)
    	die('Could not connect to MySQL: ' . mysql_error());
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
		//curl_close($cSession);

		$getfile=file_put_contents("csv/Scaback.csv", $result);
		if($getfile)	{
			$qrylt="LOAD DATA LOCAL INFILE '".$filename."' REPLACE INTO TABLE scada_latest_igate_data fields terminated by ',' enclosed by '".$ct."' lines terminated by '".$ltr."' IGNORE 1 LINES (id, value, format, @ts, ip, path, blockname, idoffset, masterId, device_name, field) SET ts='".$this->nowtime."'";
			$ins=mysql_query($qrylt) or die(mysql_error());

			$insq="INSERT INTO latest_igate_data(ts,blockname,device_name,field,format,value) SELECT ts,blockname,device_name,field,format,value FROM scada_latest_igate_data WHERE blockname!='' AND device_name!='' AND field!='' AND format IN (0,1,10) AND idoffset !=0 AND blockname NOT LIKE '%/r%' AND device_name NOT LIKE '%/r%' AND field NOT LIKE '%/r%' AND blockname NOT LIKE '%.%' AND device_name NOT LIKE '%.%' AND field NOT LIKE '%.%' ON DUPLICATE KEY UPDATE ts=VALUES(ts),value=VALUES(value)";
			$insertsq=mysql_query($insq);
			if(!$insertsq) {
				sleep(5);
				mysql_query("TRUNCATE TABLE scada_latest_igate_data");
				mysql_query("TRUNCATE TABLE latest_igate_data");
				$result=curl_exec($cSession);
				$getfile=file_put_contents("csv/Scaback.csv", $result);
				if($getfile)	{
					$qrylt="LOAD DATA LOCAL INFILE '".$filename."' REPLACE INTO TABLE scada_latest_igate_data fields terminated by ',' enclosed by '".$ct."' lines terminated by '".$ltr."' IGNORE 1 LINES (id, value, format, @ts, ip, path, blockname, idoffset, masterId, device_name, field) SET ts='".$this->nowtime."'";
					$ins=mysql_query($qrylt) or die(mysql_error());
				}
				if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'latest_igate_data'"))!=1)	{
					include_once("create_fieldid.php");
				}
				else {
					$insq="INSERT INTO latest_igate_data(ts,blockname,device_name,field,format,value) SELECT ts,blockname,device_name,field,format,value FROM scada_latest_igate_data WHERE blockname!='' AND device_name!='' AND field!='' AND format IN (0,1,10) AND idoffset !=0 AND blockname NOT LIKE '%/r%' AND device_name NOT LIKE '%/r%' AND field NOT LIKE '%/r%' AND blockname NOT LIKE '%.%' AND device_name NOT LIKE '%.%' AND field NOT LIKE '%.%' ON DUPLICATE KEY UPDATE ts=VALUES(ts),value=VALUES(value)";
					$insertsq=mysql_query($insq);
				}
			}
			echo "readDDt\t".date("Y-m-d H:i:s")."\tInserted\tDatapoints\ttook\t";
			$msc=microtime(true)-$this->msc;
			echo $msc."\tseconds\t\n";
		}
		else {
			echo "readDDt\t".date("Y-m-d H:i:s")."\tCant_Fetch_From_DDT\n";
	 	//mysql_close($this->db);
		}
		curl_close($cSession);
	}
}
$readDDt = new ReadDDt();
?>
