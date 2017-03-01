<?php
include_once("config.php");
class Calc_plant_ov extends config{
	public  $table="plant_ov_report";
	public function __construct(){
		parent::__construct();
		$this->calplantov();
	}
	
	public function calc($startTime,$blk,$dv)
	{
		$value=0;
		$sclqry3="select value from day_variable WHERE  ts=".$startTime." and block='".$blk."' and device='".$dv."' and field = 'EAE_DAY'";
		$ds3 = mysql_query($sclqry3); 	
		if(mysql_num_rows($ds3) > 0)
		{ 
			$row_ds3 = mysql_fetch_array($ds3);
			$value=$row_ds3['value'];
		}
		return $value;
	}
	public function fetchPr($startTime,$blk,$dv)
	{
		$value=0;
		$sclqry="select value from day_variable WHERE  ts=".$startTime." and block='".$blk."' and device='".$dv."' and field = 'PR_DAY'";
		$ds2 = mysql_query($sclqry); 	
		if(mysql_num_rows($ds2) > 0)
		{ 
			$row_ds2 = mysql_fetch_array($ds2);
			$value=$row_ds2['value'];
		}
		return $value;
	}
	public function calcpac($blk,$dv,$fld)
	{
			$value=0;
			$sclqry="select value from scada_latest_igate_data WHERE blockname='".$blk."' and device_name like '".$dv."' and field='".$fld."'";
			$ds2 = mysql_query($sclqry); 	
			if(mysql_num_rows($ds2) > 0)
			{ 
				$row_ds2 = mysql_fetch_array($ds2);
				$value=$row_ds2['value'];
			}
			return $value;
	}
	public function calplantov()
	{
		$numblk=$this->num_blocks;
		$msg=array();
		$prv="";
		$pr=0;
		$blocks=explode("," , $this->name_blocks);
	//	$yr=$this->calc($this->startTime,'WS','WS');

		for($i=0;$i<count($blocks);$i++)
		{
		set_time_limit(60);
		$blk=$blocks[$i];
		//$acee=$blk."_ACEE";
	//	$prv=$blk."_HTP_EM";
		$inv1=$blk."_INV1";
		$inv2=$blk."_INV2";
		$inv3=$blk."_INV3";
		$inv4=$blk."_INV4";
		$blk_em=$blk."_HTP_EM";
		
		$blk_i1_pac=$this->calcpac($blk,$inv1,'PAC');
		$blk_i2_pac=$this->calcpac($blk,$inv2,'PAC');
		$blk_i3_pac=$this->calcpac($blk,$inv3,'PAC');
		$blk_i4_pac=$this->calcpac($blk,$inv4,'PAC');
		$blk_elt=$this->calcpac($blk,$blk_em,'PAC');

		$blk_i1_gen=$this->calc($this->startTime,$blk,$inv1);
		$blk_i2_gen=$this->calc($this->startTime,$blk,$inv2);
		$blk_i3_gen=$this->calc($this->startTime,$blk,$inv3);
		$blk_i4_gen=$this->calc($this->startTime,$blk,$inv4);
		$blk_gen=$this->calc($this->startTime,$blk,$blk_em);
		
		$i1pr=$this->fetchPr($this->startTime,$blk,$inv1);
		$i2pr=$this->fetchPr($this->startTime,$blk,$inv2);
		$i3pr=$this->fetchPr($this->startTime,$blk,$inv3);
		$i4pr=$this->fetchPr($this->startTime,$blk,$inv4);
		 
		$blk_pr=$this->fetchPr($this->startTime,$blk,$blk_em);
		
		if(preg_match( "/$blk/i", $this->mw1)){
		$blk_i2_pac="-";$blk_i3_pac="-";$blk_i4_pac="-";
		$blk_i2_gen="-";$blk_i3_gen="-";$blk_i4_gen="-";
		$i2pr="-";$i3pr="-";$i4pr="-";
		}
		if(preg_match( "/$blk/i", $this->mw2)){
		$blk_i3_pac="-";$blk_i4_pac="-";
		$blk_i3_gen="-";$blk_i4_gen="-";
		$i3pr="-";$i4pr="-";
		}
		if(preg_match( "/$blk/i", $this->mw3)){
		$blk_i4_pac="-";
		$blk_i4_gen="-";
		$i4pr="-";
		}
		$insq="Replace ".$this->table." (ts,blockname,inv1_pac,inv2_pac,inv3_pac,inv4_pac,elite_pac,inv1_gen,inv2_gen,inv3_gen,inv4_gen,elite_gen,inv1_pr,inv2_pr,inv3_pr,inv4_pr,blk_pr) values ('".$this->startTime."','".$blk."','".$blk_i1_pac."','".$blk_i2_pac."','".$blk_i3_pac."','".$blk_i4_pac."','".$blk_elt."','".$blk_i1_gen."','".$blk_i2_gen."','".$blk_i3_gen."','".$blk_i4_gen."','".$blk_gen."','".$i1pr."','".$i2pr."','".$i3pr."','".$i4pr."','".$blk_pr."')";
		echo $insq."<br>";
		$iqry= mysql_query($insq) or die(mysql_error());
		}

		$msc=microtime(true)-$this->msc;
		echo $msc.' seconds'."<br>";
		mysql_close($this->db);
		}
		
	}
$plantov = new calc_plant_ov();
?>