<?php
include_once("config.php");
class Store1MinData extends config{
		public function __construct(){
		parent::__construct();
		$this->store1MinData();
	}
	
 public function store1MinData()
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
				if($format==10)
				{
					$msg1[]="('".$ts."','".$blk."','".$dve."','".$fld."','".$val."','".$this->now."')";
				}
				else
				{
					$val=str_ireplace("nan","NULL",$val);
					$msg[]="('".$ts."','".$blk."','".$dve."','".$fld."','".$val."','".$this->now."')";
				}
			}
			$data=implode(",",$msg);
			$insq="Replace into 1min_data (ts,blockname,device_name,field,value,insertedts) values  ".$data;
			//echo $insq."<br>";
			$insertsq=mysql_query($insq);
			if(!$insertsq){echo mysql_error();}
			
			$insq2="Replace into 1min_data_today (ts,blockname,device_name,field,value,insertedts) values  ".$data;
			$insertsq2=mysql_query($insq2);
			
			$data1=implode(",",$msg1);
			$insq1="Replace into 1min_data_text (ts,blockname,device_name,field,value,insertedts) values  ".$data1;
			$insertsq1=mysql_query($insq1);
			
			$insq3="Replace into 1min_data_text_today (ts,blockname,device_name,field,value,insertedts) values  ".$data1;
			mysql_query($insq3);
				
			/* csv file creation process will do here */
			if(($this->chr=='23')&&($min=='59'))
			{	
				//integer table//
				mysql_query("DROP TABLE 1min_data_today_csv");
				mysql_query("RENAME TABLE 1min_data_today TO 1min_data_today_csv");
				$create1 = "CREATE TABLE IF NOT EXISTS `1min_data_today` (
						`ts` int(14) NOT NULL,
						`blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
						`device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
						`field` varchar(50) CHARACTER SET latin1 NOT NULL,
						`value` varchar(100) CHARACTER SET latin1 NOT NULL,
						`insertedts` int(14) NOT NULL,
						PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
						KEY `blockname` (`blockname`),
						KEY `device_name` (`device_name`),
						KEY `field` (`field`),
  						KEY `insertedts` (`insertedts`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
				mysql_query($create1);
				//string table//
				mysql_query("DROP TABLE 1min_data_text_today_csv");
				mysql_query("RENAME TABLE 1min_data_text_today TO 1min_data_text_today_csv");
				$create2 = "CREATE TABLE IF NOT EXISTS `1min_data_text_today` (
						`ts` int(14) NOT NULL,
						`blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
						`device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
						`field` varchar(50) CHARACTER SET latin1 NOT NULL,
						`value` varchar(256) CHARACTER SET latin1 NOT NULL,
						`insertedts` int(14) NOT NULL,
						PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
						KEY `blockname` (`blockname`),
						KEY `device_name` (`device_name`),
						KEY `field` (`field`),
  						KEY `insertedts` (`insertedts`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
				mysql_query($create2);
			}
			else
			{				
				if(($this->chr=='00')&&($min=='15'))
				{
					//mysql_query("ANALYZE TABLE 1min_data_today");
					mysql_query("OPTIMIZE TABLE 1min_data_today");
					mysql_query("FLUSH TABLE 1min_data_today");
					mysql_query("OPTIMIZE TABLE 1min_data_text_today");
				}
				elseif(($this->sdd=='01')&&($this->chr=='00')&&($min=='10'))
				{
					mysql_query("OPTIMIZE TABLE 1min_data");
					mysql_query("FLUSH TABLE 1min_data");
				}
			}
			
			/* For FIFO Use*/
			if(($lst_day==$this->sdd)&&($this->chr=='23')&&($min=='55'))
			{
				/////////////////1min start///////////
				$renametbl="1min_data";
				$newname="1min_data_".date("M_Y");
				$renm="RENAME TABLE `" . $renametbl . "` TO `" . $newname . "`";
				$reqry=mysql_query($renm);
				if($renm)
				{
				$csql = "CREATE TABLE IF NOT EXISTS `1min_data` (
						`ts` int(14) NOT NULL,
						`blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
						`device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
						`field` varchar(50) CHARACTER SET latin1 NOT NULL,
						`value` varchar(100) CHARACTER SET latin1 NOT NULL,
						`insertedts` int(14) NOT NULL,
						PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
						KEY `ts` (`ts`),
						KEY `blockname` (`blockname`),
						KEY `device_name` (`device_name`),
						KEY `field` (`field`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";			
				$csql.=" PARTITION BY RANGE(ts)(";						
				$month =  $this->slmnth+1;
				$year = $this->crtyr;
				if($month==13){
					$month=1;
					$year = $this->crtyr+1;
				}
				$ts = mktime(0, 0, 0, $month, 01, $year);
				$mon_cnt=date('t' ,$ts);
				for($day=1; $day<=$mon_cnt; $day++)
				{
					$time=mktime(0, 0, 0, $month, $day, $year);          
					if (date('m', $time)==$month)       
					$list=$time+86400;
					$list2=$time;
					$date=date('d', $list2);
					$mon=date('M', $list2);
					$yr=date('y', $list2);
					if($day==$mon_cnt){$commo= ')';}else{$commo= ', ';}
					$csql.="PARTITION ".$date.$mon.$yr." VALUES LESS THAN (".$list.")".$commo."";
				}
				mysql_query($csql);
				}
				
				/////////////////1min done 1min text start///////////
				
				$renametbl1="1min_data_text";
				$newname1="1min_data_text_".date("M_Y");
				$renm1="RENAME TABLE `" . $renametbl1 . "` TO `" . $newname1 . "`";
				$reqry1=mysql_query($renm1);
				if($renm1)
				{
				$csql1 = "CREATE TABLE IF NOT EXISTS `1min_data_text` (
						`ts` int(14) NOT NULL,
						`blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
						`device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
						`field` varchar(50) CHARACTER SET latin1 NOT NULL,
						`value` varchar(256) CHARACTER SET latin1 NOT NULL,
						`insertedts` int(14) NOT NULL,
						PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";			
				$csql1.=" PARTITION BY RANGE(ts)(";						
				$month =  $this->slmnth+1;
				$year = $this->crtyr;
				if($month==13){
					$month=1;
					$year = $this->crtyr+1;
				}
				$ts = mktime(0, 0, 0, $month, 01, $year);
				$mon_cnt=date('t' ,$ts);
				for($day=1; $day<=$mon_cnt; $day++)
				{
					$time=mktime(0, 0, 0, $month, $day, $year);          
					if (date('m', $time)==$month)       
					$list=$time+86400;
					$list2=$time;
					$date=date('d', $list2);
					$mon=date('M', $list2);
					$yr=date('y', $list2);
					if($day==$mon_cnt){$commo= ')';}else{$commo= ', ';}
					$csql1.="PARTITION ".$date.$mon.$yr." VALUES LESS THAN (".$list.")".$commo."";
				}
				mysql_query($csql1);
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
$read5mindata = new Store1MinData();
?>