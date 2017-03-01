<?php
include_once("config.php");
class Get15mintsInverterData extends config{
	
	public  $table="inverterdata_15mints";
	public  $tablefrm="scada_latest_igate_data";
	public function __construct(){
		parent::__construct();
		$this->get15mintsInverterData();
	}


function fetchdata($tablefrm,$table,$ablk,$eldv,$nowtime)
{
	if($ablk=='WS')
	{
	 $sqlelqry="select ts,field,value from ".$tablefrm." where blockname='".$ablk."' and device_name='".$eldv."' and ((field='Ambient_Temperature') or (field='Solar_Radiation') or (field='Wind_Speed'))";
	}
	else
	{
	 $sqlelqry="select ts,field,value from ".$tablefrm." where blockname='".$ablk."' and device_name='".$eldv."' and (field='PAC')";
	}
	$qryel= mysql_query($sqlelqry);
	$numel=mysql_num_rows($qryel);
	if($numel>0)
	{
		while($fetchel=mysql_fetch_array($qryel))
			{
				
				$tsel=$fetchel['ts'];
				$fldel=$fetchel['field'];
				$valel=$fetchel['value'];
				mysql_query("Replace ".$this->table." (ts,blockname,device_name,field,value,insertedts) values ('".$tsel."','".$ablk."','".$eldv."','".$fldel."','".$valel."','".$this->nowtime."')");
			}
	}
}

function maxpac($startTime,$blk,$type,$fld)
{
   $sql=mysql_query("SELECT Value  FROM `invertermaxpac` WHERE `ts` = '".$startTime."' AND `Block` = '".$blk."' AND `Device`='".$type."' AND `Field`='".$fld."'");
   if(mysql_num_rows($sql) >0)
   {
	   $fetch=mysql_fetch_array($sql);
	   return $fetch['Value'];
   }
   else
   {
	   return "0";
   }
}

function fetchMinEAPlus($startTime,$blk,$dv,$fld)
{
   $val=0;
 
   $sql=mysql_query("SELECT SUM(EnergyGeneration) as value  FROM `inverter_dcframe_report` WHERE `ts` = '".$startTime."' AND `Block` = '".$blk."' AND `Device` like '%".$dv."%' and EnergyGeneration>0");
   if(mysql_num_rows($sql) >0)
   {
	   $fetch=mysql_fetch_array($sql);
	   $val=$fetch['value'];
   }
   return $val;
  
}

 public function get15mintsInverterData()
	{
		$arrBlk=explode("," , $this->name_blocks);
		$arrd=explode("," , $this->inv);
		$arrdevice=explode("," , $this->inverter);
		$numarr=count($arrBlk);
		if($numarr >0)
		{
			for($n=0;$n<$numarr;$n++)
			{
				set_time_limit(60);
				$ablk=$arrBlk[$n];
				for($i=0;$i<4;$i++)
				{
					$dv=$arrd[$i];
					$sqlqry="select ts,field,SUM(value+0.0)as value from ".$this->tablefrm." where blockname='".$ablk."' and device_name like '%".$dv."' and ((field='PAC') or (field='PDC') or (field='EAE') or (field='IDC') or (field='IGBT_TEMP') or (field='UDC')) group by field";
					//echo $sqlqry."<br>";
					$qry= mysql_query($sqlqry);
					$num=mysql_num_rows($qry);
					if($num>0)
					{
						while($fetch=mysql_fetch_array($qry))
						{
							
							$ts=$fetch['ts'];
							$fld=$fetch['field'];
							$val=$fetch['value'];
							$type=$arrdevice[$i];
							
							$insqry1=mysql_query("Replace ".$this->table." (ts,blockname,device_name,field,value,insertedts) values ('".$ts."','".$ablk."','".$type."','".$fld."','".$val."','".$this->nowtime."')");
							
	/*if($fld=='PAC')
	{	
		$mxp=$this->maxpac($this->startTime,$ablk,$type,$fld);
		if($val >= $mxp)
		{
		  mysql_query("Replace invertermaxpac (ts,pacTs,Block,Device,Field,Value) values ('".$this->startTime."','".$ts."','".$ablk."','".$type."','".$fld."','".$val."')");
		}
	}
	if($fld=='EAE')
	{
		$enrgy=$this->fetchMinEAPlus($this->startTime,$ablk,$dv,$fld);	
		mysql_query("Replace inverterenergy (ts,Block,Device,Field,Type,Value) values ('".$this->startTime."','".$ablk."','".$type."','".$fld."','Energy','".$enrgy."')");
	}*/
						}
					}
				}
				$eldv=$ablk."_HTP_EM";
				$this->fetchdata($this->tablefrm,$this->table,$ablk,$eldv,$this->nowtime);	
			}
		}
		$this->fetchdata($this->tablefrm,$this->table,'WS','WS',$this->nowtime);
		$sqlqry3="select ts,blockname,device_name,field,value from ".$this->tablefrm." where blockname='CR' and ((field='EAE') or (field='EAI') or (field='PAC'))";
		$qry3= mysql_query($sqlqry3);
		$num3=mysql_num_rows($qry3);
		if($num3>0)
		{
			while($fetchv=mysql_fetch_array($qry3))
			{
				$ts=$fetchv['ts'];
				$blk=$fetchv['blockname'];
				$dv=$fetchv['device_name'];
				$fld=$fetchv['field'];
				$val=$fetchv['value'];			
				mysql_query("Insert into inverterdata_15mints (ts,blockname,device_name,field,value,insertedts) values ('".$ts."','".$blk."','".$dv."','".$fld."','".$val."','".$this->nowtime."')");	
			}
		}
				$msc=microtime(true)-$this->msc;
				echo $msc.' seconds'."<br>";
				mysql_close($this->db);		
			}
}
$inverter15data = new Get15mintsInverterData();
?>