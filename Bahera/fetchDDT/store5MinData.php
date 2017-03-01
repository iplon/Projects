<?php
include_once("config.php");
class Store5MinData extends config{
		public function __construct(){
		parent::__construct();
		$this->store5MinData();
	}

 public function store5MinData()
	{
		$lst_day=date("t");
		$min = date('i');
		$this->now = mktime($this->chr, $min, 0,  $this->slmnth,  $this->sdd,  $this->crtyr)-60;
		$format=1;
		$msg=array();
		$msg1=array();
		$sqlqry="select ts,blockname,device_name,field,value,format from scada_latest_igate_data where ts >= $this->startTime and ts < $this->endTime";
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
				$val=str_replace("'","",$val);
				if($format!==10)
				{
				  $val=str_ireplace("nan","NULL",$val);
					if($val=='NULL')
					{
					$msg[]="('".$ts."','".$blk."','".$dve."','".$fld."','".$val."','".$this->now."')";
					}
					else
					{
					$msg[]="('".$ts."','".$blk."','".$dve."','".$fld."','".$val."','".$this->now."')";	
					}
				}
			}
			$data=implode(",",$msg);
		/*	$insq2="Replace into 5min_data (ts,blockname,device_name,field,value,insertedts) values  ".$data;
			echo $insq."<br>";
			$insertsq2=mysql_query($insq2);
			if(!$insertsq2){echo mysql_error();}*/
			
			if(($this->chr=='23')&&($min>='55'))
			{
				$trc="truncate table 5min_data_today";
				$trnt=mysql_query($trc) or die(mysql_error());
			}
			else
			{	
				$insq="Replace into 5min_data_today (ts,blockname,device_name,field,value,insertedts) values  ".$data;
				$insertsq=mysql_query($insq);
				if(!$insertsq){echo mysql_error();}
				echo '<br>'.$insq;
				if(($this->chr=='00')&&($min<='20'))
				{
					mysql_query("OPTIMIZE TABLE 5min_data_today");
					mysql_query("FLUSH TABLE 5min_data_today");
				}
			}
		}
		if($insertsq)
		{
		  echo "<br>Inserted...!";
		}
		else
		{
		  echo "Not Inserted...!";
		}
		mysql_free_result($qry);
		$msc=microtime(true)-$this->msc;
		echo $msc.' seconds'."<br>";
	mysql_close($this->db);		
	}
}
$read5mindata = new Store5MinData();
?>
