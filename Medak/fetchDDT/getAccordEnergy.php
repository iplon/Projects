<?php
include_once("config.php");
class GetAccordEnergy extends config{
	
	public  $table="Energy15MintsData";
	public  $tablefrm="scada_latest_igate_data";
	
	public function __construct(){
		parent::__construct();
		$this->getaccordenergy();
	}


function prevEnergy($startTime,$blk,$dv,$fld)
{
 $result=0;
 $sql=mysql_query("SELECT Value  FROM `Energy15MintsData` WHERE `Dayts` = '".$startTime."' AND `Block` = '".$blk."' AND `Device`='".$dv."' AND `Field`='".$fld."' AND `Type`='Energy' order by ts desc limit 0,1");
   if(mysql_num_rows($sql) >0)
   {
	   $fetch=mysql_fetch_array($sql);
	   $result=$fetch['Value'];
   }
   return $result;
}

function fetchMinEAPlus($startTime,$endtime,$blk,$dv,$fld,$ts,$nowtime)
{
 $minv=0;
 
  $sql=mysql_query("SELECT Value  FROM `Energy15MintsData` WHERE `Dayts` = '".$startTime."' AND `Block` = '".$blk."' AND `Device`='".$dv."' AND `Field`='".$fld."' AND `Type`='Min' and Value!=0 order by ts desc limit 0,1");
   if(mysql_num_rows($sql) >0)
   {
	   $fetch=mysql_fetch_array($sql);
	   $minv=$fetch['Value'];
   }
   else
   {
	
	$sqlm=mysql_query("SELECT value  FROM `scada_latest_igate_data` WHERE `ts`> '".$startTime."' and ts < '".$endtime."' AND `blockname`='".$blk."' AND `device_name`='".$dv."' AND `field`='".$fld."' and value!='nan' and value >0");
	$numsl=mysql_num_rows($sqlm);
	if($numsl>0)
	{
		$fetchmin=mysql_fetch_array($sqlm);
		$minv=$fetchmin['value'];
	}
	else
	{
		$ydate = mktime(0, 0, 0, $slmnth, $sdd-1, $crtyr);  
		$sqlys="SELECT Max(b.value) as value FROM fields as a join 1min_data as b on(a.blk_dv_fld_id=b.blk_dv_fld_id) where b.ts > ".$ydate." and b.ts < ".$startTime." and a.blockname='".$blk."' and a.device_name ='".$dv."' and a.field = '".$fld."' and b.value is not null and b.value >0";
		$fetchysmax=mysql_fetch_array($sqlys);
		$minv=$fetchysmax['value'];
	}
	
	mysql_query("insert into Energy15MintsData (Dayts,ts,Block,Device,Field,Type,Value,insertedts) values ('".$startTime."','".$ts."','".$blk."','".$dv."','".$fld."','Min','".$minv."','".$this->nowtime."')");
  }
  return $minv;
}
	
	public function getaccordenergy()
	  {
		$msg=array();
		$msg1=array();
		$sql=mysql_query("SELECT block,device,field,compresstype  FROM `AccordCalcFields` WHERE compresstype='Energy' and `status` = '1'");
		$numarr=mysql_num_rows($sql);
		if($numarr >0)
		{
			while($fetch=mysql_fetch_array($sql))
			{
				set_time_limit(60);
				$blk=$fetch['block'];
				$dv=$fetch['device'];
				$fld=$fetch['field'];
				$type=$fetch['compresstype'];
		
				$sqlqry="select ts,value from ".$this->tablefrm." where blockname='".$blk."' and device_name='".$dv."' and field='".$fld."' and value!='nan' and value >0";
				//echo $sqlqry."<br>";
				$qry= mysql_query($sqlqry);
				$num=mysql_num_rows($qry);
				if($num>0)
				{
					while($fetchv=mysql_fetch_array($qry))
					{
						$ts=$fetchv['ts'];
						$val=$fetchv['value'];
						if($type=='Energy')
						{
							$minenrgy=$this->fetchMinEAPlus($this->startTime,$this->endtime,$blk,$dv,$fld,$ts,$this->nowtime);
							if($val >= $minenrgy)
							{					
								$enrgy=$val-$minenrgy;
							}
							else
							{
								$enrgy=$this->prevEnergy($this->startTime,$blk,$dv,$fld);
							}
							 $msg[]="('".$this->startTime."','".$ts."','".$blk."','".$dv."','".$fld."','Energy','".$enrgy."','".$this->nowtime."')";
						}
					}
				}
				else
				{
					$prev=$this->prevEnergy($this->startTime,$blk,$dv,$fld);			
					$msg[]="('".$this->startTime."','".$this->nowtime."','".$blk."','".$dv."','".$fld."','Energy','".$prev."','".$this->nowtime."')";
				}
			}
		}
		$data=implode(",",$msg);
		$insq="Replace Energy15MintsData (Dayts,ts,Block,Device,Field,Type,Value,insertedts) values ".$data;
		echo $insq."<br>";
		mysql_query($insq) or die(mysql_error());
		$msc=microtime(true)-$this->msc;
		echo $msc.' seconds'."<br>";
		mysql_close($this->db);		
	}
}
$energy = new GetAccordEnergy();
?>
