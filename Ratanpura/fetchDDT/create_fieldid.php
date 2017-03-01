<?php
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
$msc=microtime(true);
$msg=array();
///Assign unique id for each data points
$ins=mysql_query("select blockname,device_name,field from scada_latest_igate_data where blockname!='' and device_name!='' and field!='' group by blockname,device_name,field");
$num=mysql_num_rows($ins);
if($num!=0)
{
	while($fetins=mysql_fetch_array($ins))
	{
		$blk=$fetins['blockname'];
		$dev=$fetins['device_name'];
		$fld=$fetins['field'];
		$msg2[]="('".$blk."','".$dev."','".$fld."')";
	}
		$data2=implode(",",$msg2);
		$insq2="Insert Ignore into fields (blockname,device_name,field) values  ".$data2;
		echo "<br><br><br>".$insq2."<br>";
		mysql_query($insq2) or die(mysql_error());
}
$msc=microtime(true)-$msc;
echo $msc.' seconds'."<br>";
mysql_close($connect);
?>