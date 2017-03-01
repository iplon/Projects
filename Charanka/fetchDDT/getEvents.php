<?php
include_once("config.php");
class GetEvents extends config{
	
	public  $table="events";
	
	public function __construct(){
		parent::__construct();
		$this->getevents();
	}
public function source($blk,$dv,$fld)
	{
		$value=0;
		$sclqry3="select value from scada_latest_igate_data WHERE blockname='".$blk."' and device_name='".$dv."' and field = '".$fld."'";
		$ds3 = mysql_query($sclqry3); 	
		if(mysql_num_rows($ds3) > 0)
		{ 
			$row_ds3 = mysql_fetch_array($ds3);
			$value=$row_ds3['value'];
		}
		return $value;
	}
public function getevents()
	 {
		ob_start();
		$chkarr=array("No_Warning","No_error","0","nan","NaN");
		$msg=array();
		$type="";
		
		$slq = "Select a.ts,a.blockname,a.device_name,a.field,a.value,b.history_enable,b.alarm_type,b.type from scada_latest_igate_data as a join alarm_fields as b on(a.field=b.alarm_field) where  b.status='1' and b.type='event' and a.blockname!='' and a.device_name!='' and a.ts!='0' and a.value NOT IN ('nan','NaN','0','1')";
		$sQuery=mysql_query($slq);
		$num=mysql_num_rows($sQuery);
		if($num >0)
		{
			while($fetch=mysql_fetch_array($sQuery)) 
			{
					$devname=stripslashes(trim($fetch['device_name']));
					$ts=stripslashes(trim($fetch['ts']));
					$blk=stripslashes(trim($fetch['blockname']));
					$fld=stripslashes(trim($fetch['field']));
					$val=stripslashes(trim($fetch['value']));
					$type=stripslashes(trim($fetch['alarm_type']));
					$altype=stripslashes(trim($fetch['type']));
					$arr1 = array("ON_OFF","ON","OFF","CMD");
					$arr2 = array("SRC","SRC","SRC","SRC");
					$src=str_replace($arr1,$arr2,$fld);
					$source=$this->source($blk,$devname,$src);
						if (!in_array($val, $chkarr))
						{
							$test="select a.id from (select id,error_txt from ".$this->table." where type='".$type."' and block='".$blk."' and device_name='".$devname."' and field='".$fld."' and altype='event' and status='0' and source='".$source."' order by id desc limit 0,1) as a where a.error_txt='".$val."'";
							//echo $test."<br>";
							$sl=mysql_query($test);
							$numq=mysql_num_rows($sl);
							if($numq==0)
							{
							  $msg[]="(now(),now(),'".$ts."','".$type."','".$blk."','".$devname."','".$fld."','".$altype."','".$val."','".$source."')"; 
							}
							mysql_free_result($sl);
						}
				}
		   if(count($msg)>0)
		   {
				$data=implode(",",$msg);
				echo $insqry="insert IGNORE into ".$this->table." (date,time,ts,type,block,device_name,field,altype,error_txt,source) values ".$data;
				$qry=mysql_query($insqry) or die(mysql_error());
			}
				/* Maintain the data with 100000 */
				$chkNum='100000';
				$sQ = "SELECT COUNT(`id`) as tot FROM ".$this->table."";
				$rResult = mysql_query($sQ); 
				$aResult = mysql_fetch_array($rResult);
				$tRecord=$aResult['tot'];
				if($tRecord>$chkNum)
				{
					$lmt=$tRecord-$chkNum;
					$dlq="DELETE FROM ".$this->table." ORDER BY id LIMIT ".$lmt."";
					echo $dlq."<br>";
					$rdR = mysql_query($dlq); 
				}
				mysql_query("OPTIMIZE TABLE ".$this->table."");
				mysql_free_result($rResult);
			if($qry)
			{
				echo "sucessfully inserted...!";
			}
			else
			{
				echo "Not inserted...!";
			}
		}
		mysql_free_result($sQuery);
		$msc=microtime(true)-$this->msc;
		echo $msc.' seconds'."<br>";
		mysql_close($this->db);		
			}
}
$events = new GetEvents();
?>