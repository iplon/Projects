<?php
ini_set('display_errors', 1); 
// error_reporting(E_ALL);
include_once("config.php");
class GetAlarms extends config{
	
	public  $table="alarm";
	
	public function __construct(){
		parent::__construct();
		$this->getalarms();
	}

public function getalarms()
	 {
		ob_start();
		$chkarr=array("No_Warning","No_error","0","nan","NaN");
		$type="";
		$msg=array();
		$sql = "SELECT a.value FROM scada_latest_igate_data AS a JOIN alarm_fields AS b ON (a.field=b.alarm_field) 
		WHERE a.value NOT IN('0', '', 'NaN') AND b.status = '1' AND (b.type = 'process' OR b.type = 'fire')";
		
		$sQuery=mysql_query($sql);
		while($fetch=mysql_fetch_array($sQuery)) {
		
	$alarmStringAry[] = explode(",", $fetch['value']);
		}
		// print_r($alarmStringAry);
		// exit;
	foreach($alarmStringAry as $index=>$string){
					if(isset($string) && $string!=""){
						foreach($string as $key => $value){
							if(isset($value) && $value!=""){
							$slq = "Select a.ts,a.blockname,a.device_name,a.field,a.value,b.history_enable,b.alarm_type,b.type,b.priority from scada_latest_igate_data as a join 
							alarm_fields as b on(a.field=b.alarm_field) and ((b.alarm_text = '".$value."') OR (a.value = 1)) where b.status='1' and (b.type='process' or b.type='fire') 
							and a.blockname!='' and a.device_name!='' and a.ts!='0' and value NOT IN ('nan','NaN', '')";
							// echo $slq;
							// exit;
						}
					}
					// echo $slq;
				}
	}
	
	$slQuery=mysql_query($slq);
	if (!$slQuery) {
    die('Invalid query: ' . mysql_error());
}
else{
	echo "mysql query success:".$slQuery."\n";
}

	
	$num=mysql_num_rows($slQuery);
	// echo $num."\t";
	// exit();
	if($num >0)
		{
			while($fetch=mysql_fetch_array($sQuery)) 
			{
					$devname=stripslashes(trim($fetch['device_name']));
					$ts=stripslashes(trim($fetch['ts']));
					$blk=stripslashes(trim($fetch['blockname']));
					$fld=stripslashes(trim($fetch['field']));
					$val=stripslashes(trim(str_replace("'","",$fetch['value'])));
					$hist=stripslashes(trim($fetch['history_enable']));
					$type=stripslashes(trim($fetch['alarm_type']));
					$altype=stripslashes(trim($fetch['type']));
					$priority=stripslashes(trim($fetch['priority']));
						$date=date("Y-m-d", $ts);
						$time=date("H:i:s", $ts);
						if (!in_array($val, $chkarr))
						{
						  $sts=0;
						  if($hist=='1')
						  {
						   $sts=2;
						  }
						  $msg[]="(now(),now(),'".$ts."','".$type."','".$blk."','".$devname."','".$fld."','".$altype."','".$val."','".$sts."','".$priority."')";
						   
						}
						elseif (in_array($val, $chkarr))
						{
							$sl=mysql_query("select id,status from ".$this->table." where type='".$type."' and block='".$blk."' and device_name='".$devname."' and field='".$fld."' and altype='".$altype."' and solved_datetime='0000-00-00 00:00:00' and (status='0' or status='2')");
							$numq=mysql_num_rows($sl);
							if($numq>0)
							{
								$datetime=date("Y-m-d H:i:s", $ts);
						
								while($fetchq=mysql_fetch_array($sl))
								{
									$ids=$fetchq['id'];
									$stas=$fetchq['status'];
									if($stas==2)
									{
										$insqry="Update ".$this->table." set solved_datetime=now(),status=1 where id='".$ids."'";	
									}
									else
									{
										$insqry="Update ".$this->table." set solved_datetime=now() where id='".$ids."'";
									}
									$qry=mysql_query($insqry) or die(mysql_error());
								}
							}
							mysql_free_result($sl);
						}
			}
			
			$data=implode(",",$msg);
			echo $insqry="insert IGNORE into ".$this->table." (date,time,ts,type,block,device_name,field,altype,error_txt,status,priority) values ".$data;
			$qry=mysql_query($insqry) or die(mysql_error());
			if($qry)
			{
				/* Maintain the data with 100000 */
				$chkNum='100000';
				$sQ = "SELECT COUNT(`id`) as tot,altype FROM ".$this->table." where (altype='process' or altype='fire') group by altype";
				$rResult = mysql_query($sQ); 
				while($aResult = mysql_fetch_array($rResult))
				{
					$tRecord=$aResult['tot'];
					$atyp=$aResult['altype'];
					if($tRecord>$chkNum)
					{
						$lmt=$tRecord-$chkNum;
						$dlq="DELETE FROM ".$this->table." where altype='".$atyp."' ORDER BY id LIMIT ".$lmt."";
						echo $dlq."<br>";
						$rdR = mysql_query($dlq); 
					}
				}
				mysql_query("OPTIMIZE TABLE ".$this->table."");
				echo "sucessfully inserted...!";
				mysql_free_result($rResult);
			}
			else
			{
				echo "Not inserted...!";
			}
			
		}	
	mysql_free_result($sQuery);
		$dtm=date("Y-m-d");
		$cSession = curl_init();
			$qy1="select id from scada_latest_igate_data where blockname LIKE '%CR%' and field='ELEC_HOOTER1_CMD' limit 1";
			$qrysl= mysql_query($qy1);
			$numsl=mysql_num_rows($qrysl);
			if($numsl!=0)
			{
				$ftq=mysql_fetch_array($qrysl);
				$id=$ftq['id'];		
			}
		$audAlm="select b.id as count FROM alarm_fields as a join alarm as b on(a.alarm_field=b.field)
		where b.date='".$dtm."' and a.type='process' and a.status='1' and a.audio_status='1' and b.reset='1'";
		$sqlalm = mysql_query($audAlm);
		$numq=mysql_num_rows($sqlalm);
		if($numq>0){	
			$url="http://localhost:3000/scaback0001/setProp?id=".$id."&val=1";			
		}
		else{
			$url="http://localhost:3000/scaback0001/setProp?id=".$id."&val=2";
		}
				echo '<br><br>'.$url;
				curl_setopt($cSession,CURLOPT_URL,$url);
				curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($cSession,CURLOPT_HEADER, false);
				curl_setopt($cSession,CURLOPT_TIMEOUT,30);
				$result=curl_exec($cSession);
				if($result){echo "<br>Ack requested<br>";}else{echo "<br>Ack not requested";}
				curl_close($cSession);
			
		$msc=microtime(true)-$this->msc;
		echo $msc.' seconds'."<br>";
		mysql_close($this->db);			
}
}
$alarms = new GetAlarms();
?>
	
	
	
	
	
	
		