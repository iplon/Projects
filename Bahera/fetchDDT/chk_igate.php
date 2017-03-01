<?php
ob_start();
$msc=microtime(true);
include_once("config.php");
class Check_igate extends config{
	
	public function __construct(){
		parent::__construct();
		$this->checkigate();
	}
	
	public function checkigate()
	{
		$msg=array();
		$table="alarm";
		$devname="igate_or_fo_fault";
		$type="igate";
		$fld="COMMUNICATION_STATUS";
		$shr="";
		if(isset($_REQUEST['block'])) 
		{ 
			$blk=ucfirst(stripslashes(trim($_REQUEST['block']))); 
			if(($blk!='')&&($blk!='All')) 
			{ 
				$chkblk=str_replace(",","','",$blk); 
				$shr.=" and (blockname IN ('".$chkblk."'))"; 
			} 
		} 
	
	$qry="select blockname,count(*) as 'errcount' from scada_latest_igate_data where  field='".$fld."' and device_name!='' and blockname!='/ram/' $shr group by blockname order by blockname desc";
	$sq=mysql_query($qry);
	$num=mysql_num_rows($sq);
	$result=array();
	if($num>0)
	{
		while($fetch=mysql_fetch_array($sq))
		{
			$blk=$fetch['blockname'];
			$errc=$fetch['errcount'];
			
			$selectQuery = "select '".$blk."',CASE count(*) WHEN '".$errc."' THEN '1' ELSE '0' END as status from scada_latest_igate_data where blockname='".$blk."' and field ='".$fld."' and value='nan'";
			echo $selectQuery."<br>";
			$sql= mysql_query($selectQuery);
			if(mysql_num_rows($sql) > 0)
			{
				$rlt = mysql_fetch_array($sql);
				$result=$rlt['status'];
				$dsp=$blk."_".$devname;
				
				
				if($result=="1")
				{
				  $msg[]="(now(),now(),'".$this->nowtime."','".$type."','".$blk."','".$dsp."','".$fld."','system','nan')";
				}
				else
				{
					$sl=mysql_query("select id from ".$table." where type='".$type."' and block='".$blk."' and device_name='".$dsp."' and field='".$fld."' and altype='system' and solved_datetime='0000-00-00 00:00:00' and status='0'");
					$numq=mysql_num_rows($sl);
					if($numq>0)
					{
						$fetchq=mysql_fetch_array($sl);
						$ids=$fetchq['id'];
						echo $insqry="Update ".$table." set solved_datetime=now() where id='".$ids."'";
						$qry=mysql_query($insqry) or die(mysql_error());
					}
				}
			}
			flush();
		}
		
		if(count($msg) >0)
		{
			$data=implode(",",$msg);
			echo $insqry="insert IGNORE into ".$table." (date,time,ts,type,block,device_name,field,altype,error_txt) values ".$data;
			$qry1=mysql_query($insqry);
			if($qry1)
			{
				echo "sucessfully inserted...!";
			}
			else
			{
				echo "Not inserted...!";
			}
		}
	}
	mysql_close($this->db);
	$msc=microtime(true)-$this->msc;
	echo $msc.' seconds'."<br>";
	}
	
}

$chkigate =  new Check_igate();

?>