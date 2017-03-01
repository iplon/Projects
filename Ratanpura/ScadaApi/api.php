<?php
	//ini_set('display_errors', 1);
	require_once("Rest.inc.php");
	
	class API extends REST {
	
		public $data = "";	
		private $db = NULL;
	
		public function __construct(){
			parent::__construct();				// Init parent contructor
			$this->getJsondata();				//  Get data from json
			$this->dbConnect();					// Initiate Database connection
						
		}
		
		/*
		 * Fetching data from json file
		*/
		public function getJsondata(){
				$string = file_get_contents("config.json");
				$json = json_decode($string, true);
				$this->hostname=$json['db_credential']['hostname'];
				$this->username=$json['db_credential']['username'];
				$this->password=$json['db_credential']['password'];
				$this->dbname=$json['db_credential']['dbname'];
				$this->name=$json['plant']['name'];
				$this->server1_ip=$json['server_ip']['server1_ip'];
				$this->server2_ip=$json['server_ip']['server2_ip'];
				$this->lf=$json['Energy_Meters']['lf'];
				$this->lf1=$json['Energy_Meters']['lf1'];
				$this->incommers=$json['Energy_Meters']['incommers'];
			}
			
		/*
		 *  Database connection - database credential is from json config file
		*/
		private function dbConnect(){
			$this->db = mysql_connect($this->hostname,$this->username,$this->password)  or die(mysql_error());
			if($this->db)
				mysql_select_db($this->dbname) or die(mysql_error());
		}
		
		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 */
		public function processApi(){
			$func = @strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);
				// If the method not exist with in this class, response would be "Page not found".
		}
		
		/* 
		 *	Simple login API
		 *  Login must be POST method
		 *  email : <USER EMAIL>
		 *  pwd : <USER PASSWORD>
		 */

	private function graph()
        {
           	date_default_timezone_set('Asia/Kolkata');  
			$slmnth=date("m"); $slmnthe=date("m");
			$crtyr=date("Y"); $crtyre=date("Y");
			$sdd=date("d"); $sdde=date("d"); 
			$today = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			$result = array();
			if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
			{ 
			$from=stripslashes(trim($_REQUEST['sd'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $from);
			}
			$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			if((isset($_REQUEST['ed']))&&($_REQUEST['ed']!='')) 
			{ 
			$to=stripslashes(trim($_REQUEST['ed'])); 
			list($sdde, $slmnthe, $crtyre) = explode("/",  $to);
			}else{
				if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
					{ 
						$from=stripslashes(trim($_REQUEST['sd'])); 
						list($sdde, $slmnthe, $crtyre) = explode("/",  $from);
					}
			}
			$endTime = mktime(0, 0, 0, $slmnthe, $sdde +1 , $crtyre);
			$where=""; 
			if(isset($_REQUEST['block'])) 
			{ 
				$blk=stripslashes(trim($_REQUEST['block'])); 
				if(($blk!='')&&($blk!='All')) 
				{ 
					$chkblk=str_replace(",","','",$blk); 
					$where.=" and blockname IN ('".$chkblk."')"; 
					$block="FIELD(blockname, '".$chkblk."')";
				}
			} 
			if(isset($_REQUEST['device'])) 
			{ 
				$dvfld=stripslashes(trim($_REQUEST['device'])); 
				if(($dvfld!='')&&($dvfld!='All')) 
				{ 
					$divchk=str_replace(",","','",$dvfld);
					$where.=" and device_name IN ('".$divchk."')"; 
					$device="FIELD(device_name, '".$divchk."')";
				}
			} 
			if(isset($_REQUEST['field'])) 
			{ 
				$fld=stripslashes(trim($_REQUEST['field'])); 
				if(($fld!='')&&($fld!='All')) 
				{ 
					$arrfld=str_replace(",","','",$fld); 
					$where.=" and field IN ('".$arrfld."')";
					$field="FIELD(field, '".$arrfld."')";
				}
			} 
			////first query/////
			$result1 = array();
			$startTime=mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			$month=date('m', $startTime);
			$year=date('Y', $startTime);
			if($startTime==$today)
			{
				$tbl="5min_data_today";
				$groupby='';
			}
			else
			{
			$groupby=' GROUP BY (12 * HOUR(FROM_UNIXTIME(ts)) + FLOOR(MINUTE(FROM_UNIXTIME(ts))/5)), DATE(FROM_UNIXTIME(ts)),field,device_name,blockname ';
				if(($month==date("m")) && ($year==date("Y")))
				{	
				  $tbl="1min_data";
				}
				else
				{
				  $tbl="1min_data_".date("M_Y",$startTime);
				}
			}
			$sclqry= '';
			if(($blk!='')&&($dvfld!='')&&($fld!=''))
			{
				$sclqry.=" select blockname,device_name,field,ts,value from $tbl where ts  >= $startTime and ts  < $endTime $where $groupby ";			
			////second query////
			$result2 = array();
			if($slmnthe!==$slmnth)
			{
			$startTime=mktime(0, 0, 0, $slmnthe, 01, $crtyre);
			$month=date('m', $startTime);
			$year=date('Y', $startTime);
			if($startTime==$today)
			{
				$tbl="5min_data_today";
				$groupby='';
			}
			else
			{
				$groupby=' GROUP BY (12 * HOUR(FROM_UNIXTIME(ts)) + FLOOR(MINUTE(FROM_UNIXTIME(ts)))), DATE(FROM_UNIXTIME(ts)),field,device_name,blockname ';
				if(($month==date("m")) && ($year==date("Y")))
				{	
				  $tbl="1min_data";
				}
				else
				{
				  $tbl="1min_data_".date("M_Y",$startTime);
				}
			}
				$sclqry.=" UNION select blockname,device_name,field,ts,value from $tbl where ts  >= $startTime and ts  < $endTime $where $groupby order by $block, $device, $field,ts";

			}
			else{
			$sclqry.=" order by $block, $device, $field,ts";	
			}
			$sql = mysql_query($sclqry, $this->db); 
				if(mysql_num_rows($sql) > 0)
				{ 
					while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
					{ 
					 $result[]=array_values($rlt); 
					} 
				} 
			mysql_free_result($sql);
			}
				$this->response($this->json($result), 200); 
        }
		/*FLEXIBLE GRAPH START*/
		private function flexible()
        {
           	date_default_timezone_set('Asia/Kolkata');  
			$slmnth=date("m"); 
			$crtyr=date("Y"); 
			$sdd=date("d"); 
			$today = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			$yesterday=$today-86400 ;
			if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
			{ 
			$from=stripslashes(trim($_REQUEST['sd'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $from);
			}
			$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			if((isset($_REQUEST['ed']))&&($_REQUEST['ed']!='')) 
			{ 
			$to=stripslashes(trim($_REQUEST['ed'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $to);
			}
			$endTime = mktime(0, 0, 0, $slmnth, $sdd +1 , $crtyr);
			$where=""; 
			if(isset($_REQUEST['block'])) 
			{ 
				$blk=ucfirst(stripslashes(trim($_REQUEST['block']))); 
				if(($blk!='')&&($blk!='All')) 
				{ 
					$chkblk=str_replace(",","','",$blk); 
					$where.=" and (blockname IN ('".$chkblk."'))";
					$block="FIELD(blockname, '".$chkblk."')";
				}
				else{$block="blockname";}
			} 
			if(isset($_REQUEST['device'])) 
			{ 
				$dvfld=ucfirst(stripslashes(trim($_REQUEST['device']))); 
				if(($dvfld!='')&&($dvfld!='All')) 
				{ 
					$divchk=str_replace(",","','",$dvfld); 
					$where.=" and (device_name IN ('".$divchk."'))"; 
					$device="FIELD(device_name, '".$divchk."')";
				}
				else{$device="device_name";}
			} 
			if(isset($_REQUEST['field'])) 
			{ 
				$fld=ucfirst(stripslashes(trim($_REQUEST['field']))); 
				if(($fld!='')&&($fld!='All')) 
				{ 
					$arrfld=str_replace(",","','",$fld); 
					$where.=" and (field IN ('".$arrfld."'))";
					$field="FIELD(field, '".$arrfld."')";
				}
				else{$field="field";}
			}
			if(isset($_REQUEST['text'])) 
			{ 
				$text='_text';
			}
			else{$text='';}
			if(isset($_REQUEST['interval'])) 
			{
				$int=stripslashes(trim($_REQUEST['interval']));	
				if($int==5)
				{$sample=12;}
				elseif($int==10)
				{$sample=6;}
				elseif($int==15)
				{$sample=4;}
				elseif($int==30)
				{$sample=2;}
				elseif($int==60)
				{$sample=1;}
				$groupby="GROUP BY ($sample * HOUR(FROM_UNIXTIME(insertedts)) + FLOOR(MINUTE(FROM_UNIXTIME(insertedts))/ $int)), DATE(FROM_UNIXTIME(insertedts)),field,device_name,blockname";
			}
			else
			{
				$groupby='';
			}
			if($int==1)
				{$groupby="";}
			if($startTime==$today)
			{
				$tbl="1min_data".$text."_today";
			}
			elseif($startTime==$yesterday)
			{
				$tbl="1min_data".$text."_today_csv";
			}
			else
			{
				if(($slmnth==date("m")) && ($crtyr==date("Y")))
				{	
					$tbl="1min_data".$text."";
				}
				else
				{
				  $tbl="1min_data".$text."_".date("M_Y",$startTime);
				}
			}
			if(($blk!='')&&($dvfld!='')&&($fld!=''))
			{
				$result = array();
				$sclqry="select blockname,device_name,field,FROM_UNIXTIME(insertedts,'%Y-%m-%d %H:%i') AS ts,value from $tbl where ts >= $startTime and ts < $endTime $where $groupby order by $block, $device, $field,ts";
				$sql = mysql_query($sclqry, $this->db); 
				if(mysql_num_rows($sql) > 0)
				{ 
					while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
					{ 
					 $result[]=array_values($rlt); 
					} 
				} 
				mysql_free_result($sql);
				$this->response($this->json($result), 200); 
			}
        }
			private function smu_comm()
        {
           	date_default_timezone_set('Asia/Kolkata');  
			$slmnth=date("m"); 
			$crtyr=date("Y"); 
			$sdd=date("d"); 
			$today = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			$yesterday=$today-86400 ;
			if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
			{ 
			$from=stripslashes(trim($_REQUEST['sd'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $from);
			}
			$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			if((isset($_REQUEST['ed']))&&($_REQUEST['ed']!='')) 
			{ 
			$to=stripslashes(trim($_REQUEST['ed'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $to);
			}
			$endTime = mktime(0, 0, 0, $slmnth, $sdd +1 , $crtyr);
			$where=""; 
			if(isset($_REQUEST['block'])) 
			{ 
				$blk=ucfirst(stripslashes(trim($_REQUEST['block']))); 
				if(($blk!='')&&($blk!='All')) 
				{ 
					$chkblk=str_replace(",","','",$blk); 
					$where.=" and (blockname IN ('".$chkblk."'))";
					$block="FIELD(blockname, '".$chkblk."')";
				}
				else{$block="blockname";}
			} 
			if(isset($_REQUEST['device'])) 
			{ 
				$dvfld=ucfirst(stripslashes(trim($_REQUEST['device']))); 
				if(($dvfld!='')&&($dvfld!='All')) 
				{ 
					$divchk=str_replace(",","','",$dvfld); 
					$where.=" and (device_name IN ('".$divchk."'))"; 
					$device="FIELD(device_name, '".$divchk."')";
				}
				else{$device="device_name";}
			} 
				
			if($startTime==$today)
			{
				$tbl="1min_data_today";
			}
			elseif($startTime==$yesterday)
			{
				$tbl="1min_data".$text."_today_csv";
			}
			else
			{
				if(($slmnth==date("m")) && ($crtyr==date("Y")))
				{	
					$tbl="1min_data";
				}
				else
				{
				  $tbl="1min_data_".date("M_Y",$startTime);
				}
			}
			if(($blk!='')&&($dvfld!=''))
			{
				$result = array();
				 $sclqry="select blockname,device_name,field,FROM_UNIXTIME((insertedts),'%Y-%m-%d %H:%i') AS ts,value from $tbl where ts >= $startTime and ts < $endTime  AND device_name like '%SMU%' AND field = 'COMMUNICATION_HOUR' $where and MINUTE(FROM_UNIXTIME(insertedts)) = 59 order by $block, $device,ts";
				$sql = mysql_query($sclqry, $this->db) or die(mysql_error()); 
				if(mysql_num_rows($sql) > 0)
				{ 
					while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
					{ 
					 $result[]=array_values($rlt); 
					} 
				} 
				mysql_free_result($sql);
				$this->response($this->json($result), 200); 
			}
        }
	/*DAY VARIABLE START*/
	private function variable()
	{
		date_default_timezone_set('Asia/Kolkata'); 
		$slmnths=date("m");$slmnthe=date("m");
		$crtyrs=date("Y");$crtyre=date("Y");
		$sdds=date("d");$sdde=date("d");
		$where="";
		if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
		{ 
		$from=stripslashes(trim($_REQUEST['sd'])); 
		list($sdds, $slmnths, $crtyrs) = explode("/",  $from);
		}
		if((isset($_REQUEST['ed']))&&($_REQUEST['ed']!='')) 
		{ 
		$to=stripslashes(trim($_REQUEST['ed'])); 
		list($sdde, $slmnthe, $crtyre) = explode("/",  $to);
		}
		if(isset($_REQUEST['block'])) 
		{ 
			$blk=stripslashes(trim(strtolower($_REQUEST['block']))); 
			if(($blk!='')&&($blk!='all')) 
			{ 
				$chkblk=str_replace(",","','",$blk); 
				$where.=" and block IN ('".$chkblk."')"; 
				$block="FIELD(block, '".$chkblk."')";
			}
			else{$block='block';}
		} 
		if(isset($_REQUEST['device'])) 
		{ 
			$dvfld=stripslashes(trim(strtolower($_REQUEST['device']))); 
			if(($dvfld!='')&&($dvfld!='all')) 
			{ 
				$divchk=str_replace(",","','",$dvfld);
				$where.=" and device IN ('".$divchk."')"; 
				$device="FIELD(device, '".$divchk."')";
			}
			else{$device='device';}
		} 
		if(isset($_REQUEST['field'])) 
		{ 
			$fld=stripslashes(trim(strtolower($_REQUEST['field']))); 
			if(($fld!='')&&($fld!='all')) 
			{ 
				$arrfld=str_replace(",","','",$fld); 
				$where.=" and field IN ('".$arrfld."')";
				$field="FIELD(field, '".$arrfld."')";
			}
			else{$field='field';}
		} 
		if((isset($_REQUEST['type']))&&($_REQUEST['type']!=''))
		{
		 $tpe=strtolower(stripslashes(trim($_REQUEST['type'])));
		}
        
   if($tpe=="annual")
   {
	$startTime = mktime(0, 0, 0, 01, 01, $crtyrs);
	$endTime = mktime(0, 0, 0, $slmnthe, $sdde, $crtyre+1);
	$sclqry="SELECT block,device,field,YEAR(FROM_UNIXTIME(ts)) AS ts,SUM(value) AS value FROM day_variable where ts >= $startTime and ts < $endTime $where group by device,field, year(FROM_UNIXTIME(ts)) order by $block, $device, $field, ts";
   }
   elseif($tpe=="year")
   {
	$startTime = mktime(0, 0, 0, 01, 01, $crtyrs);
	$endTime = mktime(0, 0, 0, $slmnthe, $sdde, $crtyre+1);
	$sclqry="SELECT block,device,field,FROM_UNIXTIME(ts, '%Y-%m') AS ts,SUM(value) AS value FROM day_variable where ts >= $startTime and ts < $endTime $where group by device,field, month(FROM_UNIXTIME(ts)) order by $block, $device, $field, ts";
   }
   elseif($tpe=="month")
   {
	$startTime = mktime(0, 0, 0, $slmnths, 01, $crtyrs);
	$endTime = mktime(0, 0, 0, $slmnthe+1, $sdde, $crtyre);
	$sclqry="SELECT block,device,field,FROM_UNIXTIME(ts, '%Y-%m-%d') AS ts,value FROM day_variable where ts >= $startTime and ts < $endTime $where order by $block, $device, $field, ts";
   }
   elseif($tpe=="week")
	   {
	$startTime = mktime(0, 0, 0, $slmnths, $sdds-6, $crtyrs);
	$endTime = mktime(0, 0, 0, $slmnths, $sdds, $crtyrs);
	$sclqry="SELECT block,device,field,DATE(FROM_UNIXTIME(ts)) AS ts,value FROM day_variable where ts >= $startTime and ts < $endTime order by $block, $device, $field, ts";
	   }
   else
   {
	$startTime = mktime(0, 0, 0, $slmnths, $sdds, $crtyrs);
	$endTime = mktime(0, 0, 0, $slmnthe, $sdde+1, $crtyre);
	$sclqry="SELECT block,device,field,FROM_UNIXTIME(ts) AS ts,value FROM day_variable where ts >= $startTime and ts < $endTime $where order by $block, $device, $field,ts";
   }
	$result = array();
	$sql = mysql_query($sclqry, $this->db);
	if(mysql_num_rows($sql) > 0)
	{
		while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
		{
		$result[]=array_values($rlt);
		}
	}
	$this->response($this->json($result), 200);
	}
	/*DAY VARIABLE END*/
	
	private function revenue()
	{
		date_default_timezone_set('Asia/Kolkata'); 
		$slmnths=date("m");$slmnthe=date("m");
		$crtyrs=date("Y");$crtyre=date("Y");
		$sdds=date("d");$sdde=date("d");
		$where="";
		if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
		{ 
		$from=stripslashes(trim($_REQUEST['sd'])); 
		list($sdds, $slmnths, $crtyrs) = explode("/",  $from);
		}
		if(isset($_REQUEST['plant'])) 
		{ 
			$dvfld=stripslashes(trim(strtolower($_REQUEST['plant']))); 
			if(($dvfld!='')&&($dvfld!='all')) 
			{ 
				$divchk=str_replace(",","','",$dvfld);
				$device=" and plant IN ('".$divchk."')"; 
			}
		} else{
		$device='';
		}
		$result1 = array();$result2 = array();$result = array();
	$startTimeyr = mktime(0, 0, 0, 01, 01, $crtyrs);
	$startTime = mktime(0, 0, 0, $slmnths, 01, $crtyrs);
	$disp = mktime(0, 0, 0, $slmnths, 01, $crtyrs);
	$endTime = mktime(0, 0, 0, $slmnthe+1, $sdde, $crtyre);
	
	
	 $scl1="SELECT plant,'CR_EM','EAE_DAY',FROM_UNIXTIME(ts, '%Y-%m-%d') AS ts,cross_export FROM abt_revenue where ts >= $startTime and ts < $endTime $device order by ts";
	$scl1 = mysql_query($scl1, $this->db);
	if(mysql_num_rows($scl1) > 0)
	{
		while($rlt1 = mysql_fetch_array($scl1,MYSQL_ASSOC))
		{
		$result1[]=array_values($rlt1);
		}
	}
	
	 $scl2="SELECT plant,'CR_EM','EAI_DAY',FROM_UNIXTIME(ts, '%Y-%m-%d') AS ts,import FROM abt_revenue where ts >= $startTime and ts < $endTime $device order by ts";
	$scl2 = mysql_query($scl2, $this->db);
	if(mysql_num_rows($scl2) > 0)
	{
		while($rlt2 = mysql_fetch_array($scl2,MYSQL_ASSOC))
		{
		$result2[]=array_values($rlt2);
		}
	}
	
	$scl3="SELECT plant,'CR_EM','EAN_DAY',FROM_UNIXTIME(ts, '%Y-%m-%d') AS ts,net_export FROM abt_revenue where ts >= $startTime and ts < $endTime $device order by ts";
	$scl3 = mysql_query($scl3, $this->db);
	if(mysql_num_rows($scl3) > 0)
	{
		while($rlt3 = mysql_fetch_array($scl3,MYSQL_ASSOC))
		{
		$result3[]=array_values($rlt3);
		}
	}
	$scl4="SELECT plant,'CR_EM','CUF_DAY',FROM_UNIXTIME(ts, '%Y-%m-%d') AS ts,cuf FROM abt_revenue where ts >= $startTime and ts < $endTime $device order by ts";
	$scl4 = mysql_query($scl4, $this->db);
	if(mysql_num_rows($scl4) > 0)
	{
		while($rlt4 = mysql_fetch_array($scl4,MYSQL_ASSOC))
		{
		$result4[]=array_values($rlt4);
		}
	}
	$scl5="SELECT plant,'CR_EM','REVENUE_DAY',FROM_UNIXTIME(ts, '%Y-%m-%d') AS ts,revenue_cost FROM abt_revenue where ts >= $startTime and ts < $endTime $device order by ts";
	$scl5 = mysql_query($scl5, $this->db);
	if(mysql_num_rows($scl5) > 0)
	{
		while($rlt5 = mysql_fetch_array($scl5,MYSQL_ASSOC))
		{
		$result5[]=array_values($rlt5);
		}
	}
	$field = array('EAE_DAY'=>'cross_export','CUF'=>'cuf');
	foreach($field as $fld2 => $fld){
		if(date('m')==$slmnths && date('Y')==$crtyrs){
			$lst_day=date('d');
			}else{
		$lst_day=date('t' , $startTime);
			}
		for($day=1; $day<=$lst_day; $day++)
			{
			$startTime = mktime(0, 0, 0, 01, 01, 2016);
			$endTime = mktime(0, 0, 0, $slmnthe, $day, $crtyre);
			$cnt="SELECT ts FROM abt_revenue where ts = $endTime";
			$sq = mysql_query($cnt, $this->db);
			if(mysql_num_rows($sq) > 0)
			{
	 $sclqry1="SELECT plant,'HIGH_$fld2','$fld2',FROM_UNIXTIME($endTime, '%Y-%m-%d') AS ts,$fld FROM abt_revenue where ts >= $startTime and ts <= $endTime $device order by $fld desc limit 0,1";
	$sql1 = mysql_query($sclqry1, $this->db);
	if(mysql_num_rows($sql1) > 0)
	{
		while($rlt1 = mysql_fetch_array($sql1,MYSQL_ASSOC))
		{
		$result6[]=array_values($rlt1);
		}
	}}}}
	
	$list=array();
	$field = array('EAE_DAY'=>'cross_export','CUF_DAY'=>'cuf');
	foreach($field as $fld2 => $fld){
		if(date('m')==$slmnths && date('Y')==$crtyrs){
			$lst_day=date('d');
			}else{
		$lst_day=date('t' , $startTime);
			}
		for($day=1; $day<=$lst_day; $day++)
			{
				
			$startTime = mktime(0, 0, 0, 01, 01, 2016);
			$endTime = mktime(0, 0, 0, $slmnthe, $day, $crtyre);
			$cnt="SELECT ts FROM abt_revenue where ts = $endTime";
			$sq = mysql_query($cnt, $this->db);
			if(mysql_num_rows($sq) > 0)
			{
			$sclqry2="SELECT plant,'CR_EM_$fld','$fld2',FROM_UNIXTIME($endTime, '%Y-%m-%d') AS ts1, FROM_UNIXTIME(ts, '%Y-%m-%d') AS ts FROM abt_revenue where ts >=$startTime and ts <=$endTime $device order by $fld desc limit 0,1";
			$sql2 = mysql_query($sclqry2, $this->db);
			if(mysql_num_rows($sql2) > 0)
			{
				while($rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC))
				{
				$result7[]=array_values($rlt2);
				}
			}	
			}
			}
	}
	$result=array_merge($result1,$result2,$result3,$result4,$result6,$result7,$result5);
	//$result=array_merge($result6);
	$this->response($this->json($result), 200);
	}
	/*STATION REPORT START*/
	private function station()
	{
		date_default_timezone_set('Asia/Kolkata'); 
		$slmnths=date("m");	$slmnthe=date("m");
		$crtyrs=date("Y");	$crtyre=date("Y");
		$sdds=date("d");	$sdde=date("d");
		$where="";
		if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
		{ 
		$from=stripslashes(trim($_REQUEST['sd'])); 
		list($sdds, $slmnths, $crtyrs) = explode("/",  $from);
		}
		if((isset($_REQUEST['ed']))&&($_REQUEST['ed']!='')) 
		{ 
		$to=stripslashes(trim($_REQUEST['ed'])); 
		list($sdde, $slmnthe, $crtyre) = explode("/",  $to);
		}
		if(isset($_REQUEST['block'])) 
		{ 
			$blk=stripslashes(trim(strtolower($_REQUEST['block']))); 
			if(($blk!='')&&($blk!='all')) 
			{ 
				$chkblk=str_replace(",","','",$blk); 
				$where.=" and block IN ('".$chkblk."')";
				$where1.=" and blockname IN ('".$chkblk."')"; 
				$block="FIELD(block, '".$chkblk."')";
			}
			else{$block='block';}
		} 
		if(isset($_REQUEST['device'])) 
		{ 
			$dvfld=stripslashes(trim(strtolower($_REQUEST['device']))); 
			if(($dvfld!='')&&($dvfld!='all')) 
			{ 
				$divchk=str_replace(",","','",$dvfld);
				$where.=" and device IN ('".$divchk."')"; 
				$where1.=" and device_name IN ('".$divchk."')"; 
				$device="FIELD(device, '".$divchk."')";
			}
			else{$device='device';}
		} 
		if(isset($_REQUEST['field'])) 
		{ 
			$fld=stripslashes(trim(strtolower($_REQUEST['field']))); 
			if(($fld!='')&&($fld!='all')) 
			{ 
				$arrfld=str_replace(",","','",$fld); 
				$where.=" and field IN ('".$arrfld."')";
				$field="FIELD(field, '".$arrfld."')";
			}
			else{$field='field';}
		} 
		if((isset($_REQUEST['type']))&&($_REQUEST['type']!=''))
		{
		 $tpe=strtolower(stripslashes(trim($_REQUEST['type'])));
		}
		
		if($tpe=="month")
		{
			$startTime = mktime(0, 0, 0, $slmnths, 01, $crtyrs);
			$endTime = mktime(0, 0, 0, $slmnthe+1, 01, $crtyre);
		}
		elseif($tpe=="year")
		{
			$startTime = mktime(0, 0, 0, 01, 01, $crtyrs);
			$endTime = mktime(0, 0, 0, $slmnthe, $sdde, $crtyre+1);
		}
		else
		{
			$startTime = mktime(0, 0, 0, $slmnths, $sdds, $crtyrs);
			$endTime = mktime(0, 0, 0, $slmnthe, $sdde+1, $crtyre);
		}
  		$result = array();
		$sclqry="SELECT block,device,field,FROM_UNIXTIME($startTime) AS ts, CASE  
		WHEN field LIKE '%AVG%' THEN AVG(ABS(value))
		WHEN field LIKE '%MAX%' THEN MAX(ABS(value))
		WHEN field LIKE '%MIN%' THEN MIN(ABS(value))
		WHEN field LIKE '%PR%' THEN AVG(ABS(value))
		WHEN field LIKE '%CUF%' THEN AVG(ABS(value))
		ELSE SUM(value) END 'ABS(value)'
		FROM `day_variable` WHERE ts >= $startTime and ts < $endTime $where group by block,device,field order by $block, $device, $field, ts";
		$sql = mysql_query($sclqry, $this->db) or die(mysql_error());
		if(mysql_num_rows($sql) > 0)
		{
			while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
			{
			$result1[]=array_values($rlt);
			}
		}
		$sclqry1="select blockname,device_name,field,FROM_UNIXTIME($startTime) AS ts, value FROM scada_latest_igate_data where ts!='' $where1 AND field IN('EAE','EAI') order by field";
			$sql1= mysql_query($sclqry1, $this->db);
			if(mysql_num_rows($sql1) > 0)
			{
				while($rlt1 = mysql_fetch_array($sql1,MYSQL_ASSOC)){
				 $result2[]=array_values($rlt1);
				}
			}
			$result=array_merge($result1,$result2);
		$this->response($this->json($result), 200);
	}
	/*STATION REPORT END*/
		
		private function report_inverter()
		{
		//$msc=microtime(true);
		date_default_timezone_set('Asia/Kolkata'); 
		$slmnth=date("m");
		$crtyr=date("Y");
		$sdd=date("d");
		$today = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
		if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
			{ 
			$from=stripslashes(trim($_REQUEST['sd'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $from);
			}
		$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
		$where="";
		$where1="";
		$tpe="";
		$result1 = array();
		$result2 = array();
		$result3 = array();
		$result4 = array();
		if(isset($_REQUEST['block']))
		{
			$blk=ucfirst(stripslashes(trim($_REQUEST['block'])));
			if(($blk!='')&&($blk!='All'))
			{
				$chkblk=str_replace(",","','",$blk);
				$where.=" and (blockname IN ('".$chkblk."'))";
				$where1.=" and (block IN ('".$chkblk."'))";
			}
		}
		if((isset($_REQUEST['type']))&&($_REQUEST['type']!=''))
		{
		  $tpe=strtolower(stripslashes(trim($_REQUEST['type'])));
		}
		if($tpe=="month")
		{
			$sdd='01';
			$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			$endTime = mktime(0, 0, 0, $slmnth+1, $sdd, $crtyr);
			$sclqry="SELECT block,device,field,DATE(FROM_UNIXTIME(ts)) AS ts,value FROM day_variable where ts >= $startTime and ts < $endTime AND block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' $where1 order by ts,block,device";
	
			$sql = mysql_query($sclqry, $this->db);
			if(mysql_num_rows($sql) > 0)
			{
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
				{
					$result1[]=array_values($rlt);
				}
			}

  			$sclqry1="SELECT block,device,'MAX',DATE(FROM_UNIXTIME(ts)) AS ts,MAX(ABS(value)) AS value FROM day_variable where ts >= $startTime and ts < $endTime AND block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' $where1 GROUP BY device,block ORDER BY ts,block,device";
			$sql1 = mysql_query($sclqry1, $this->db);
			if(mysql_num_rows($sql1) > 0)
			{
				while($rlt1 = mysql_fetch_array($sql1,MYSQL_ASSOC))
				{
					$result2[]=array_values($rlt1);
				}
			}
			$sclqry3="SELECT block,device,'MIN',DATE(FROM_UNIXTIME(ts)) AS ts,MIN(ABS(value)) AS value FROM day_variable where ts >= $startTime and ts < $endTime AND block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' $where1 GROUP BY device,block ORDER BY ts,block,device";
			$sql3 = mysql_query($sclqry3, $this->db);
			if(mysql_num_rows($sql3) > 0)
			{
				while($rlt3 = mysql_fetch_array($sql3,MYSQL_ASSOC))
				{
					$result3[]=array_values($rlt3);
				}
			}
			$sclqry2="SELECT block,device,'TOTAL',DATE(FROM_UNIXTIME(ts)) AS ts,SUM(ABS(value)) AS value FROM day_variable where ts >= $startTime and ts < $endTime AND block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' and value!='nan' $where1 GROUP BY device,block ORDER BY ts,block,device";
			$sql2 = mysql_query($sclqry2, $this->db);
			if(mysql_num_rows($sql2) > 0)
			{
				while($rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC))
				{
					$result4[]=array_values($rlt2);
				}
			}
		}
		elseif($tpe=="year")
		{
			$slmnth='01';
			$sdd='01';
			$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			$endTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr+1);
			$sclqry="SELECT block,device,field,FROM_UNIXTIME(ts,'%Y-%m') AS ts,SUM(ABS(value)) AS value FROM day_variable where ts >= $startTime and ts < $endTime AND block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' $where1 group by MONTH(FROM_UNIXTIME(ts)),device,block order by ts,block,device";
	
			$sql = mysql_query($sclqry, $this->db);
			if(mysql_num_rows($sql) > 0)
			{
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
				{
					$result1[]=array_values($rlt);
				}
			}
 	 		$sclqry1="SELECT block,device,'MAX',FROM_UNIXTIME(ts,'%Y') AS ts,MAX(ABS(value)) AS value FROM day_variable where ts >= $startTime and ts < $endTime AND block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' $where1 GROUP BY MONTH(FROM_UNIXTIME(ts)),device,block ORDER BY ts,block,device";
			$sql1 = mysql_query($sclqry1, $this->db);
			if(mysql_num_rows($sql1) > 0)
			{
				while($rlt1 = mysql_fetch_array($sql1,MYSQL_ASSOC))
				{
					$result2[]=array_values($rlt1);
				}
			}
			$sclqry3="SELECT block,device,'MIN',FROM_UNIXTIME(ts,'%Y') AS ts,MIN(ABS(value)) AS value FROM day_variable where ts >= $startTime and ts < $endTime AND block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' $where1 GROUP BY MONTH(FROM_UNIXTIME(ts)),device,block ORDER BY ts,block,device";
			$sql3 = mysql_query($sclqry3, $this->db);
			if(mysql_num_rows($sql3) > 0)
			{
				while($rlt3 = mysql_fetch_array($sql3,MYSQL_ASSOC))
				{
					$result3[]=array_values($rlt3);
				}
			}
			$sclqry2="SELECT block,device,'TOTAL',FROM_UNIXTIME(ts,'%Y') AS ts,SUM(ABS(value)) AS value FROM day_variable where ts >= $startTime and ts < $endTime AND block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' and value!='nan' $where1 GROUP BY device,block ORDER BY ts,block,device";
			$sql2 = mysql_query($sclqry2, $this->db);
			if(mysql_num_rows($sql2) > 0)
			{
				while($rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC))
				{
					$result4[]=array_values($rlt2);
				}
			}
		}
		elseif($tpe=="tilldate")
		{
			$sclqry="SELECT block,device,field,FROM_UNIXTIME(ts,'%Y') AS ts,SUM(ABS(value)) AS value FROM day_variable where block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' and value!='nan' $where1 group by YEAR(FROM_UNIXTIME(ts)),device,block order by ts,block,device";
	
			$sql = mysql_query($sclqry, $this->db);
			if(mysql_num_rows($sql) > 0)
			{
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
				{
					$result1[]=array_values($rlt);
				}
			}
 	 		$sclqry1="SELECT block,device,'MAX',FROM_UNIXTIME(ts,'%Y-%m') AS ts,MAX(ABS(value)) AS value FROM day_variable where block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' $where1  ORDER BY ts,block,device";
			$sql1 = mysql_query($sclqry1, $this->db);
			if(mysql_num_rows($sql1) > 0)
			{
				while($rlt1 = mysql_fetch_array($sql1,MYSQL_ASSOC))
				{
					$result2[]=array_values($rlt1);
				}
			}
			$sclqry3="SELECT block,device,'MIN',FROM_UNIXTIME(ts,'%Y-%m') AS ts,MIN(ABS(value)) AS value FROM day_variable where block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' $where1 ORDER BY ts,block,device";
			$sql3 = mysql_query($sclqry3, $this->db);
			if(mysql_num_rows($sql3) > 0)
			{
				while($rlt3 = mysql_fetch_array($sql3,MYSQL_ASSOC))
				{
					$result3[]=array_values($rlt3);
				}
			}
			$sclqry2="SELECT block,device,'TOTAL',FROM_UNIXTIME(ts,'%Y-%m') AS ts,SUM(ABS(value)) AS value FROM day_variable where block NOT LIKE 'ALL_BLOCK' and field='EAE_DAY' AND device LIKE '%_INV%' and value!='nan' $where1 GROUP BY device,block ORDER BY ts,block,device";
			$sql2 = mysql_query($sclqry2, $this->db);
			if(mysql_num_rows($sql2) > 0)
			{
				while($rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC))
				{
					$result4[]=array_values($rlt2);
				}
			}
		}
		else
		{	
			if($startTime==$today)
			{
				$tbl="1min_data_today";
			}
			else
			{
				if(($slmnth==date("m")) && ($crtyr==date("Y")))
				{	
					$tbl="1min_data";
				}
				else
				{
				  $tbl="1min_data_".date("M_Y",$startTime);
				}
			}
			$startTime6 = mktime(6, 0, 0, $slmnth, $sdd, $crtyr);
			$endTime7 = mktime(19, 0, 0, $slmnth, $sdd, $crtyr);
			$sclqry="select blockname,device_name,field,FROM_UNIXTIME(insertedts,'%Y-%m-%d %H:%i') AS ts,value from inverterdata_15mints where insertedts >= $startTime6 and insertedts <= $endTime7 and device_name like '%Inverter%' and field='PAC' $where order by blockname,device_name,insertedts";
			$sql = mysql_query($sclqry, $this->db);
			if(mysql_num_rows($sql) > 0)
			{
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
				{
					$result1[]=array_values($rlt);
				}
			}
			$sclqry1="SELECT block,device,field,FROM_UNIXTIME(ts,'%Y-%m-%d %H:%i') AS ts,value FROM day_variable where ts = $startTime and field='PAC_MAX' AND device LIKE '%_INV%' $where1 order by block,device";
			$sql1 = mysql_query($sclqry1, $this->db);
			if(mysql_num_rows($sql1) > 0)
			{
				while($rlt1 = mysql_fetch_array($sql1,MYSQL_ASSOC))
				{
					$result2[]=array_values($rlt1);
				}
			}
			$sclqry2="SELECT block,device,field,FROM_UNIXTIME(ts,'%Y-%m-%d %H:%i') AS ts,value FROM day_variable where ts = $startTime AND block NOT LIKE 'ALL_BLOCK' AND field='EAE_DAY' AND device LIKE '%_INV%' $where1 order by block,device";
			$sql2 = mysql_query($sclqry2, $this->db);
			if(mysql_num_rows($sql2) > 0)
			{
				while($rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC))
				{
					$result3[]=array_values($rlt2);
				}
			}
			}
		$result=array();
		$result=array_merge($result1,$result2,$result3,$result4);
		$this->response($this->json($result), 200);
		}
		/* Alarm Acknowledgement start */
		private function clear_alarmhistory()
		{
			$where="";
			date_default_timezone_set('Asia/Kolkata');  
			$slmnth=date("m"); 
			$crtyr=date("Y"); 
			$sdd=date("d"); 
			$arratpe="";
			
			if((isset($_REQUEST['date']))&&($_REQUEST['date']!='')) 
			{ 
				$sdd=stripslashes(trim($_REQUEST['date'])); 
			} 
			if((isset($_REQUEST['month']))&&($_REQUEST['month']!='')) 
			{ 
				$slmnth=stripslashes(trim($_REQUEST['month'])); 
			} 
			if((isset($_REQUEST['year']))&&($_REQUEST['year']!='')) 
			{ 
				$crtyr=stripslashes(trim($_REQUEST['year'])); 
			} 
			$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr); 
			$srdate=$crtyr."-".$slmnth."-".$sdd;
			
			if((isset($_REQUEST['alarmid'])) &&($_REQUEST['alarmid']!=''))
			{ 
				$alarmId=ucfirst(stripslashes(trim($_REQUEST['alarmid']))); 
				if($alarmId!='All') 
				{ 
					$chkid=str_replace(",","','",$alarmId); 
					$where.=" and id IN ('".$chkid."')";
				} 
			}
			if((isset($_REQUEST['alarmtype']))&&($_REQUEST['alarmtype']!=''))
			{
				$type = stripslashes(trim($_REQUEST['alarmtype']));
				$where.=" and altype='".$type."'"; 
			}
			if($type!='')
			{
				$insertQuery = "Update `alarm` set status='1',reset_datetime=NOW() where solved_datetime!='0000-00-00 00:00:00' $where";
				$inslt=mysql_query($insertQuery) or die(mysql_error());
				if($inslt)
				{
					echo "Sucess";
				}
				else
				{
					echo "Fail";
				}
			}
			else
			{
				echo "Please select alarm type";
			}
		}
		
  private function add_event()
		{
			$blk="";
			$device="";
			$fld="";
			$value="";
			if(isset($_REQUEST['block'])) 
			{ 
				$blk=stripslashes(trim($_REQUEST['block'])); 
			}
			if(isset($_REQUEST['device'])) 
			{ 
				$device=stripslashes(trim($_REQUEST['device'])); 
				
			}
			if(isset($_REQUEST['field'])) 
			{ 
				$fld=stripslashes(trim($_REQUEST['field'])); 
			}
			if(isset($_REQUEST['value'])) 
			{ 
				$value=ucfirst(stripslashes(trim($_REQUEST['value']))); 
			}
			if(($blk!='')&&($device!='')&&($fld!='')&&($value!=''))
			{
				$ts=time();		
				if(preg_match("/Io/i", $device))
				{
					echo $insertQuery = "insert into events (date,time,ts,type,block,device_name,field,altype,error_txt,source) values (now(),now(),'".$ts."','IO','".$blk."','".$device."','".$fld."','event','".$value."','SCADA')";
					
					$inslt=mysql_query($insertQuery) or die(mysql_error());
					if($inslt)
					{
						echo "Sucess";
					}
					else
					{
						echo "Fail";
					}
				}
				else
				{
					echo "Device name is wrong..!";
				}
			}
			else
			{
				echo "some information missing..!";
			}
		}

		private function acknowledge()
		{
			$alarmId="";
			$ackDate="";
			$solveDate="";
			$remark="Null";
			$operator="Null";
			if(isset($_REQUEST['alarmid'])) 
			{ 
				$alarmId=stripslashes(trim($_REQUEST['alarmid'])); 
			}
			if(isset($_REQUEST['ackdate']))
			{
				$ackDate = stripslashes(trim($_REQUEST['ackdate']));
			}
			if(isset($_REQUEST['solvedate']))
			{
				$solveDate = stripslashes(trim($_REQUEST['solvedate']));
				
			}
			if(isset($_REQUEST['remark']))
			{
				$remark = stripslashes(trim($_REQUEST['remark']));
			}
			if(isset($_REQUEST['operator']))
			{
				$operator = stripslashes(trim($_REQUEST['operator']));
			}
			if(isset($_REQUEST['priority'])) 
			{ 
				$prty=ucfirst(stripslashes(trim($_REQUEST['priority'])));
				 if(($prty!='')&&($prty!='All')) 
				{ 
					$pri=str_replace(",","','",$prty); 
					$priority=" and priority='".$pri."'";
					$prirty="&priority='".$pri."'";
				}
			}
			else{
				$priority="";
				$prirty="";
			}
			$tpe = 'Alarm';
			$altpe = '';
			if(isset($_REQUEST['type']))
			{
				$tpe = ucfirst(stripslashes(trim($_REQUEST['type'])));
			}
			if(isset($_REQUEST['altype']))
			{
				$altpe = ucfirst(stripslashes(trim($_REQUEST['altype'])));
			}
			if($alarmId!='')
			{
				$nowtime=time();
				
				if($tpe=='Alarm')
				{
					if($remark!='Null')
					{
						$getdt=date('Y-m-d H:i:s');
						$insertQuery = "Update `alarm` set `remark`='".$remark."',added_datetime='".$nowtime."' where id='".$alarmId."'";
					}
					else
					{
						if(ucfirst($alarmId)=='All')
						{
					$insertQuery = "Update `alarm` set ack_datetime='".$ackDate."',added_datetime='".$nowtime."' where ack_datetime='Null' and altype='".$altpe."'$priority";
						  ///sys arch ack//
						 $updateQuery2 = "Update `system_architecture` SET value='1', ack='yes' WHERE value =2 $priority";
						}
						else
						{
							$insertQuery = "Update `alarm` set ack_datetime='".$ackDate."',added_datetime='".$nowtime."' where id='".$alarmId."'";
							
							///sys arch ack end//
							$sl=mysql_query("select block,device_name,field from `alarm` where id='".$alarmId."'");
							$numq=mysql_num_rows($sl);
							if($numq>0)
							{
								$fetchq=mysql_fetch_array($sl);
								$block=$fetchq['block'];
								$device=$fetchq['device_name'];
								$field=$fetchq['field'];
								$updateQuery2 = "Update `system_architecture` SET value='1', ack='yes' WHERE value =2 and block='".$block."' and device='".$device."' and field='".$field."' ";
							///sys arch ack end//
							}	
						}
					}
					echo '<br>'.$updateQuery2.'<br>';
					$updlt=mysql_query($updateQuery2);
				////buzzer controll start////
				$qy1="select id from scada_latest_igate_data where blockname IN('CR1','CR2') and device_name IN('CR1_IO','CR2_IO') and field='FIRE_ALARM_CMD' limit 1";
				$qrysl= mysql_query($qy1);
				$numsl=mysql_num_rows($qrysl);
				if($numsl!=0)
				{
					$ftq=mysql_fetch_array($qrysl);
					$id=$ftq['id'];
					$cSession = curl_init(); 
					$sqlqry="select id from alarm where device_name like '%Io%' and field IN ('INR_SMKD_OPTD','FCP1_OPTD','FCP2_OPTD','SMKD_OPTD_CTRL_ROOM','SMKD_OPTD_PANEL_ROOM','SMKD_OPTD_FCBC_ROOM','SMKD_OPTD_BAT_ROOM','SMKD_OPTD_LOBBY','WMCP_ON') and altype='fire' and ack_datetime='null'";
					$qry= mysql_query($sqlqry);
					$num=mysql_num_rows($qry);
					if($num>0)
					{
					 $url="http://localhost:3000/scaback0001/setProp?id=".$id."&val=1";
					}
					else
					{
					 $url="http://localhost:3000/scaback0001/setProp?id=".$id."&val=2";
					}
					echo $url;
					curl_setopt($cSession,CURLOPT_URL,$url);
					curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
					curl_setopt($cSession,CURLOPT_HEADER, false);
					curl_setopt($cSession,CURLOPT_TIMEOUT,30);
					$result=curl_exec($cSession);
					if($result){echo "<br>setProp Passed";}else{echo "<br>setProp Not Passed";}
					curl_error($cSession);
					curl_close($cSession);
				}
				////buzzer controll end////				
				}
				elseif($tpe=='Event')
				{
					$insertQuery = "Update `events` set `remark`='".$remark."',remarkts=now() where id='".$alarmId."'";
				}
				echo '<br>'.$insertQuery.'<br>';
				$inslt=mysql_query($insertQuery);
				
				if($inslt){
					echo "<br>Success<br>";}
				else{
					echo "Fail";}
					///Acknowledge to other servers start////
					$plant=$this->name;
				if(!isset($_REQUEST['request']))
				{
					if(ucfirst($alarmId)=='All')
					{
						$ip=array($this->server1_ip,$this->server2_ip);
						foreach($ip as $ipaddr)
						{
							$send = curl_init();
							echo '<br>'. $ack = str_replace(" ","%20","http://$ipaddr/$plant/ScadaApi/acknowledge?alarmid=All&ackdate=$ackDate&type=$tpe&altype=$altpe$prirty&request=server");
							curl_setopt($send,CURLOPT_URL,$ack);
							curl_setopt($send,CURLOPT_RETURNTRANSFER,true);
							curl_setopt($send,CURLOPT_HEADER, false);
							curl_setopt($send,CURLOPT_TIMEOUT,30);
							$result=curl_exec($send);
							if($result){echo "<br>Ack requested to $ipaddr<br>";}else{echo "<br>Ack not requested to $ipaddr";}
							echo curl_error($send);
							curl_close($send);
						}
					}
					else{
						if($altpe=='Fire'){
						$sqlqry="select id from alarm where device_name like '%Io%' and field IN ('INR_SMKD_OPTD','INR_FCP_OPTD','KIOSK1_SMKD1_OPTD','KIOSK1_SMKD2_OPTD','KIOSK2_SMKD1_OPTD','KIOSK2_SMKD2_OPTD') and altype='fire' and ack_datetime='null'";
					$qry= mysql_query($sqlqry);
					$num=mysql_num_rows($qry);
					if($num==0)
					{
						$ip=array($this->server1_ip,$this->server2_ip);
						foreach($ip as $ipaddr)
						{
							$send = curl_init();
							echo $ack = str_replace(" ","%20","http://$ipaddr/$plant/ScadaApi/acknowledge2?alarmid=All&ackdate=$ackDate&type=alarm&altype=fire&request=server");
							curl_setopt($send,CURLOPT_URL,$ack);
							curl_setopt($send,CURLOPT_RETURNTRANSFER,true);
							curl_setopt($send,CURLOPT_HEADER, false);
							curl_setopt($send,CURLOPT_TIMEOUT,30);
							$result=curl_exec($send);
							if($result){echo "<br>Ack requested to $ipaddr<br>";}else{echo "<br>Ack not requested to $ipaddr";}
							curl_error($send);
							curl_close($send);
						}
						}
						}
					}
				}
				///Acknowledge to other servers end////
			}
			else
			{
				echo "Alarm Id is Empty..!";
			}
		}
		/*end*/
		private function smucomparison_remarks()
		{
			$ts="";
			$blk="";
			$device="";
			$display="";
			$cdate="";
			$operator="";
			$type="";
			if(isset($_REQUEST['ts'])) 
			{ 
				$ts=stripslashes(trim($_REQUEST['ts'])); 
			}
			
			if(isset($_REQUEST['device']))
			{
				$device = stripslashes(trim($_REQUEST['device']));
			}
			if(isset($_REQUEST['cdate']))
			{
				$cdate = stripslashes(trim($_REQUEST['cdate']));
				$arr=explode("-",$cdate);
				$arryear=$arr[0];
				$arrmon=$arr[1];
				$arrdt=$arr[2];
			}
			
			if(isset($_REQUEST['intrvl']))
			{
				$int = stripslashes(trim($_REQUEST['intrvl']));
			}
			/*if(isset($_REQUEST['operator']))
			{
				$operator = stripslashes(trim($_REQUEST['operator']));
			}*/
			if(($ts!='')&&($cdate!='')&&($int!='')&&($device!=''))
			{
				$dt=$arrdt+$int;
				$duedate=date("Y-m-d" ,mktime(0,0,0,$arrmon,$dt,$arryear));
                $insertQuery = "update smucomparison_data set duration='".$int."',modulecldate='".$cdate."',moduleduedate='".$duedate."' where ts='".$ts."' and device_name='".$device."'";
				$inslt=mysql_query($insertQuery) or die(mysql_error());
				if($inslt)
				{
					echo "Success";
				}
				else
				{
					echo "Fail";
				}
			}
			else
			{
				echo "Give More Details..!";
			}
		}
		private function report_remarks()
		{
			$ts="";
			$blk="";
			$device="";
			$display="";
			$remark="";
			$operator="";
			$type="";
			if(isset($_REQUEST['ts'])) 
			{ 
				$ts=stripslashes(trim($_REQUEST['ts'])); 
			}
			/*if(isset($_REQUEST['block']))
			{
				$blk = stripslashes(trim($_REQUEST['block']));
			}*/
			if(isset($_REQUEST['device']))
			{
				$device = stripslashes(trim($_REQUEST['device']));
			}
			if(isset($_REQUEST['remark']))
			{
				$remark = stripslashes(trim($_REQUEST['remark']));
			}
			/*if(isset($_REQUEST['operator']))
			{
				$operator = stripslashes(trim($_REQUEST['operator']));
			}*/
			if(($ts!='')&&($device!=''))
			{
               $insertQuery = "update  inverter_dcframe_report set remark='".$remark."',remarkdate=now() where ts='".$ts."' and Device='".$device."'";
				$inslt=mysql_query($insertQuery) or die(mysql_error());
				if($inslt)
				{
					echo "Success";
				}
				else
				{
					echo "Fail";
				}
			}
			else
			{
				echo "Need More Info..!";
			}
		}
		
		private function report_day_generation()
	{
		date_default_timezone_set('Asia/Kolkata'); 
		$slmnth=date("m");
		$crtyr=date("Y");
		$sdd=date("d");
		$chr = date('H');

		if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
		{ 
			$from=stripslashes(trim($_REQUEST['sd'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $from);
		}
		$dt=$crtyr."-".$slmnth."-".$sdd;
		$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
		$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$blk='';
		$where="";
		if(isset($_REQUEST['block']))
		{
			$blk=ucfirst(stripslashes(trim($_REQUEST['block'])));
			if(($blk!='')&&($blk!='All'))
			{
				$chkblk=str_replace(",","','",$blk);
				$where.=" and (a.Block IN ('".$chkblk."'))";
			}
		}

		if(isset($_REQUEST['device']))
		{
			$dvfld=ucfirst(stripslashes(trim($_REQUEST['device'])));
			if(($dvfld!='')&&($dvfld!='All'))
			{
				$divchk=str_replace(",","','",$dvfld);
				$where.=" and (a.Device IN ('".$divchk."'))";
			}
		}
		
	$result = array();
	if($today==$startTime)
	{
	$sclqry="select a.Block,a.Device,CASE a.StartTime WHEN '0' THEN 'Null' ELSE a.StartTime END,CASE a.StopTime WHEN '0' THEN 'Null' ELSE a.StopTime END,a.TotalSMU,a.SmuConnected,a.EnergyGeneration,a.PeakPAC,a.remark,a.ts FROM inverter_dcframe_report as a where a.ReportDate='".$dt."' $where order by a.Block,LPAD(a.Device,20,0)";
	}
	else
	{
	$sclqry="select a.Block,a.Device,CASE a.StartTime WHEN '0' THEN 'Null' ELSE a.StartTime END,CASE a.StopTime WHEN '0' THEN 'Null' ELSE a.StopTime END,a.TotalSMU,a.SmuConnected,a.EnergyGeneration,a.PeakPAC,a.remark,a.ts FROM inverter_dcframe_report as a where a.ReportDate='".$dt."' $where order by a.Block,LPAD(a.Device,20,0)";	
	}
		$sql = mysql_query($sclqry, $this->db);
		if(mysql_num_rows($sql) > 0)
		{
			while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
			 $result[]=array_values($rlt);
			}
		}
		$this->response($this->json($result), 200);
	}
		private function report_kv()
	{
		date_default_timezone_set('Asia/Kolkata'); 
		$slmnth=date("m");
		$crtyr=date("Y");
		$sdd=date("d");
		if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
		{ 
			$from=stripslashes(trim($_REQUEST['sd'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $from);
		}
		$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
		$where="";
		$result1 = array(); $result2 = array();
		if(isset($_REQUEST['display']))
		{
			$blk=ucfirst(stripslashes(trim($_REQUEST['display'])));
			if(($blk!='')&&($blk!='All'))
			{
				$where.=" and (DisplayName='".$blk."')";
			}
		}
		$sclqry="select a.DisplayName,a.Device,'EAE',FROM_UNIXTIME(a.lastts,'%Y-%m-%d %H:%i') AS ts,a.value FROM accord_em_report as a where ReportDate='".$startTime."'  and field='EAE' and timeinhour >=6 and timeinhour <=19 $where order by Device,DisplayName,timeinhour";
		$sql = mysql_query($sclqry, $this->db);
		if(mysql_num_rows($sql) > 0)
		{
			while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
			 $result1[]=array_values($rlt);
			}
		}
		 $sclqry1="select block,display,field,FROM_UNIXTIME(hourts,'%Y-%m-%d %H:%i') AS ts,value FROM hourly_compressedvalue  where ts='".$startTime."' and display='Irradiation' and hour >=6 and hour <=19 order by block,display,hour";
		$sql1 = mysql_query($sclqry1, $this->db);
		if(mysql_num_rows($sql1) > 0)
		{
			while($rlt1 = mysql_fetch_array($sql1,MYSQL_ASSOC)){
			 $result2[]=array_values($rlt1);
			}
		}
		 $incommers=str_replace(",","','",$this->incommers);
		$sclqry3="SELECT block,device,field,FROM_UNIXTIME(ts,'%Y-%m-%d %06:%00') AS ts,value FROM day_variable where ts = $startTime and field IN('PAC_MAX','SOLAR_RADIATION_MAX') AND device IN('".$incommers."','WS') order by FIELD(device, '".$incommers."','WS')";
		$sql3 = mysql_query($sclqry3, $this->db);
		if(mysql_num_rows($sql3) > 0)
		{
			while($rlt3 = mysql_fetch_array($sql3,MYSQL_ASSOC)){
			 $result3[]=array_values($rlt3);
			}
		}
		$result=array_merge($result1,$result2,$result3);
		$this->response($this->json($result), 200);
	}
	
		private function report_inverter_hour()
	{
		date_default_timezone_set('Asia/Kolkata'); 
		$slmnth=date("m");
		$crtyr=date("Y");
		$sdd=date("d");

		if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
		{ 
			$from=stripslashes(trim($_REQUEST['sd'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $from);
		}
		$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);

		$blk='';
		$where="";
		
		if(isset($_REQUEST['display']))
		{
			$dvfld=ucfirst(stripslashes(trim($_REQUEST['display'])));
			if(($dvfld!='')&&($dvfld!='All'))
			{
				$divchk=str_replace(",","','",$dvfld);
				$where.=" and (display IN ('".$divchk."','WS'))";
			}
		}
		if(isset($_REQUEST['block']))
		{
			$blk=ucfirst(stripslashes(trim($_REQUEST['block'])));
			if(($blk!='')&&($blk!='All'))
			{
				$blkchk=str_replace(",","','",$blk);
				$where.=" and (block IN ('".$blkchk."','WS'))";
			}
		}		
		$result = array();
		$result1 = array();
		$result2 = array();
		
		$sclqry="select block,display,field,FROM_UNIXTIME(hourts,'%Y-%m-%d %H:%i') AS hourts,value FROM hourly_compressedvalue where ts='".$startTime."' $where order by `block`,`display`,`hour`";
		$sql = mysql_query($sclqry, $this->db);
		if(mysql_num_rows($sql) > 0)
		{
			while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
			 $result1[]=array_values($rlt);
			}
		}
$sclqry1="select 'All_Block','All_Inverter','Total',FROM_UNIXTIME(hourts,'%Y-%m-%d %H:%i') AS hourts,Sum(value) as value FROM hourly_compressedvalue where ts='".$startTime."' and block!='WS' and display like '%Inverter%' and field='EAE' group by field,hour order by `block`,`display`,`hour`";
		$sql1 = mysql_query($sclqry1, $this->db); 

		if(mysql_num_rows($sql1) > 0)
		{ 
			while($rlt1 = mysql_fetch_array($sql1,MYSQL_ASSOC))
			{ 
			 $result2[]=array_values($rlt1); 
			} 
		} 
		$result=array_merge($result1,$result2);
		$this->response($this->json($result), 200);

	}
	
		private function report_pgr()
        {
           	date_default_timezone_set('Asia/Kolkata');  
			$slmnth=date("m"); 
			$crtyr=date("Y"); 
			$sdd=date("d"); 
			$today = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
			{ 
			$from=stripslashes(trim($_REQUEST['sd'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $from);
			}
			$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			if((isset($_REQUEST['ed']))&&($_REQUEST['ed']!='')) 
			{ 
			$to=stripslashes(trim($_REQUEST['ed'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $to);
			}
			$endTime = mktime(0, 0, 0, $slmnth, $sdd +1 , $crtyr);
			$where=""; 
			if(isset($_REQUEST['block'])) 
			{ 
				$blk=ucfirst(stripslashes(trim($_REQUEST['block']))); 
				if(($blk!='')&&($blk!='All')) 
				{ 
					$chkblk=str_replace(",","','",$blk); 
					$where.=" AND (block IN ('".$chkblk."'))";
				}
			} 
			if(isset($_REQUEST['device'])) 
			{ 
				$dvfld=ucfirst(stripslashes(trim($_REQUEST['device']))); 
				if(($dvfld!='')&&($dvfld!='All')) 
				{ 
					$divchk=str_replace(",","','",$dvfld); 
					$where.=" AND (device IN ('".$divchk."'))";
				}
			} 
				$result = array();
				$sclqry="select block,device,field,FROM_UNIXTIME(ts,'%Y-%m-%d %H:%i') AS ts,value from plant_generation_report where ts >= $startTime and ts < $endTime $where order by field,ts";
				$sql = mysql_query($sclqry, $this->db) or die(mysql_error()); 
				if(mysql_num_rows($sql) > 0)
				{ 
					while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
					{ 
					 $result[]=array_values($rlt); 
					} 
				} 
				mysql_free_result($sql);
				$this->response($this->json($result), 200); 
        }
	private function data()
	{
		date_default_timezone_set('Asia/Kolkata'); 
		$blk=''; 
		$where=""; 
			if(isset($_REQUEST['block'])) 
			{ 
				$blk=ucfirst(stripslashes(trim($_REQUEST['block']))); 
				if(($blk!='')&&($blk!='All')) 
				{ 
					$chkblk=str_replace(",","','",$blk); 
					$where.=" and (a.blockname IN ('".$chkblk."'))";
					$block="FIELD(blockname, '".$chkblk."')";
				}
				else{$block="blockname";}
			} 
			if(isset($_REQUEST['device'])) 
			{ 
				$dvfld=ucfirst(stripslashes(trim($_REQUEST['device']))); 
				if(($dvfld!='')&&($dvfld!='All')) 
				{ 
					$divchk=str_replace(",","','",$dvfld); 
					$where.=" and (a.device_name IN ('".$divchk."'))"; 
					$device="FIELD(device_name, '".$divchk."')";
				}
				else{$device="device_name";}
			} 
			if(isset($_REQUEST['field'])) 
			{ 
				$fld=ucfirst(stripslashes(trim($_REQUEST['field']))); 
				if(($fld!='')&&($fld!='All')) 
				{ 
					$arrfld=str_replace(",","','",$fld); 
					$where.=" and (a.field IN ('".$arrfld."'))";
					$field="FIELD(field, '".$arrfld."')";
				}
				else{$field="field";}
			} 
			if(isset($_REQUEST['value'])) 
			{ 
				$value=ucfirst(stripslashes(trim($_REQUEST['value'])));  
				$where.=" and a.value ='".$value."'";
			} 
		$result = array();
		if(($blk!='')&&($dvfld!='')&&($fld!=''))
		{
			$sclqry="select a.blockname,a.device_name,a.field,a.value FROM scada_latest_igate_data as a where a.ts!='' $where order by $block, $device, $field";
			$sql = mysql_query($sclqry, $this->db);
			if(mysql_num_rows($sql) > 0)
			{
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
				 $result[]=array_values($rlt);
				}
			}
			mysql_free_result($sql);
			$this->response($this->json($result), 200);
		}
	}
	

	private function plantov_report()
        {
            date_default_timezone_set('Asia/Kolkata');  
			$slmnth=date("m"); 
			$crtyr=date("Y"); 
			$sdd=date("d"); 
			
			if((isset($_REQUEST['date']))&&($_REQUEST['date']!='')) 
			{ 
				$sdd=stripslashes(trim($_REQUEST['date'])); 
			} 
			if((isset($_REQUEST['month']))&&($_REQUEST['month']!='')) 
			{ 
				$slmnth=stripslashes(trim($_REQUEST['month'])); 
			} 
			if((isset($_REQUEST['year']))&&($_REQUEST['year']!='')) 
			{ 
				$crtyr=stripslashes(trim($_REQUEST['year'])); 
			} 
			$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr); 
			$endTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr); 
			
			$blk=''; 
			$where=""; 
			if(isset($_REQUEST['block'])) 
			{ 
				$blk=ucfirst(stripslashes(trim($_REQUEST['block']))); 
				if(($blk!='')&&($blk!='All')) 
				{ 
					$chkblk=str_replace(",","','",$blk); 
					$where.=" and (blockname IN ('".$chkblk."'))"; 
				} 
			} 
			$result = array();
			$sclqry="select Date(FROM_UNIXTIME(a.ts)),a.blockname,a.inv1_pac,a.inv2_pac,a.inv3_pac,a.inv4_pac,a.elite_pac,a.inv1_gen,a.inv2_gen,a.inv3_gen,a.inv4_gen,a.elite_gen,a.inv1_pr,a.inv2_pr,a.inv3_pr,a.inv4_pr,a.blk_pr FROM  (SELECT ts,blockname,inv1_pac,inv2_pac,inv3_pac,inv4_pac,elite_pac,inv1_gen,inv2_gen,inv3_gen,inv4_gen,elite_gen,inv1_pr,inv2_pr,inv3_pr,inv4_pr,blk_pr FROM `plant_ov_report` WHERE ts='".$startTime."' $where) as a  order by a.blockname"; 
			$sql = mysql_query($sclqry, $this->db); 
			if(mysql_num_rows($sql) > 0)
			{ 
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
				{ 
				 $result[]=array_values($rlt); 
				} 
			} 
		$this->response($this->json($result), 200); 
            
        }
	

	private function mainpage()
	{
		date_default_timezone_set('Asia/Kolkata');
        $slmnth=date("m");
		$crtyr=date("Y");
		$sdd=date("d");
		if((isset($_REQUEST['date']))&&($_REQUEST['date']!='')) 
		{ 
			$sdd=stripslashes(trim($_REQUEST['date'])); 
		} 
		if((isset($_REQUEST['month']))&&($_REQUEST['month']!='')) 
		{ 
			$slmnth=stripslashes(trim($_REQUEST['month'])); 
		} 
		if((isset($_REQUEST['year']))&&($_REQUEST['year']!='')) 
		{ 
			$crtyr=stripslashes(trim($_REQUEST['year'])); 
		}
		
		$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
		$yday = mktime(0, 0, 0, $slmnth, $sdd-1, $crtyr);
		
			$result = array(); $result0 = array();	$result1 = array();	$result2 = array();	$result3 = array();	$result4 = array();	$where='';
			if(isset($_REQUEST['block'])) 
			{ 
				$blk=ucfirst(stripslashes(trim($_REQUEST['block']))); 
				if(($blk!='')&&($blk!='All')) 
				{ 
					$chkblk=str_replace(",","','",$blk); 
					$where.=" and (blockname IN ('".$chkblk."'))";
					$block="FIELD(blockname, '".$chkblk."')";
				}
				else{$block="blockname";}
			} 
			if(isset($_REQUEST['device'])) 
			{ 
				$dvfld=ucfirst(stripslashes(trim($_REQUEST['device']))); 
				if(($dvfld!='')&&($dvfld!='All')) 
				{ 
					$divchk=str_replace(",","','",$dvfld); 
					$where.=" and (device_name IN ('".$divchk."'))"; 
					$device="FIELD(device_name, '".$divchk."')";
				}
				else{$device="device_name";}
			} 
			if(isset($_REQUEST['field'])) 
			{ 
				$fld=ucfirst(stripslashes(trim($_REQUEST['field']))); 
				if(($fld!='')&&($fld!='All')) 
				{ 
					$arrfld=str_replace(",","','",$fld); 
					$where.=" and (field IN ('".$arrfld."'))";
					$field="FIELD(field, '".$arrfld."')";
				}
				else{$field="field";}
			} 
		$result = array();
		if(($chkblk!='')&&($divchk!='')&&($arrfld!=''))
		{
			$sclqry="select blockname,device_name,field,value FROM scada_latest_igate_data as a where ts!='' $where order by $block, $device, $field";
			$sql = mysql_query($sclqry, $this->db);
			if(mysql_num_rows($sql) > 0)
			{
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
				 $result1[]=array_values($rlt);
				}
			}
		}
		$sclqry2="select a.blockname,a.device_name,a.field,a.value FROM scada_latest_igate_data as a where a.ts!='' and blockname='WS' and device_name='WS' and field='SOLAR_RADIATION_CUM'";
		$sql2 = mysql_query($sclqry2, $this->db);
		if(mysql_num_rows($sql2) > 0)
		{
			while($rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC)){
			 $result2[]=array_values($rlt2);
			}
		}
		$arrt=array("Fire","Process","System");
		foreach($arrt as $type)
		{
			$sclalrm="select 'Alarm','".$type."',count(id),IF(count(id) > '0', 1 ,0) as amountvalue FROM alarm where altype='".$type."' and ack_datetime='Null' and status='0'";
			$sqlalm = mysql_query($sclalrm, $this->db);
			while($rltalm = mysql_fetch_array($sqlalm,MYSQL_ASSOC)){
				 $result3[]=array_values($rltalm);
				}
		}
		$prt=array(3,2,1);
		foreach($prt as $type)
		{
			 $sclalrm2="select 'Alarm_prioirty','".$type."',count(id),IF(count(id) > '0', 1 ,0) as amountvalue FROM alarm where altype='process' and priority='".$type."' and ack_datetime='Null' and status='0'";
			$sqlalm2 = mysql_query($sclalrm2, $this->db);
			while($rltalm2 = mysql_fetch_array($sqlalm2,MYSQL_ASSOC)){
				 $result4[]=array_values($rltalm2);
				}
		}
		$energy_meters=array_filter(array($this->lf,$this->lf1,$this->lf2));
		$imp=implode(',',$energy_meters);
		$str=str_replace(",","','",$imp);
		$meters="'$str'";
		$sclqry5="SELECT 'Yesterday',device,field,value FROM `day_variable` WHERE ts='".$yday."' and device IN ($meters) and (field='EAE_DAY') order by device DESC"; 
		$sql5 = mysql_query($sclqry5, $this->db); 
		if(mysql_num_rows($sql5) > 0)
		{ 
			while($rlt5 = mysql_fetch_array($sql5,MYSQL_ASSOC))
			{ 
			 $result5[]=array_values($rlt5); 
			} 
		} 
			$result=array_merge($result2,$result3,$result4,$result5,$result1);
			$this->response($this->json($result), 200);
		
	}
	private function alarm() 
        { 
			//$msc=microtime(true); 
			date_default_timezone_set('Asia/Kolkata');  
			$slmnth=date("m"); 
			$crtyr=date("Y"); 
			$sdd=date("d"); 
			$arratpe="";
			
			$st=0;
			$lmt=100;
			if((isset($_REQUEST['st']))&&($_REQUEST['st']!='')) 
			{ 
				$st=stripslashes(trim($_REQUEST['st'])); 
			} 
			if((isset($_REQUEST['lmt']))&&($_REQUEST['lmt']!='')) 
			{ 
				$lmt=stripslashes(trim($_REQUEST['lmt'])); 
			}
			$where="";
			$where1="";
			if((isset($_REQUEST['adate']))&&($_REQUEST['adate']!='')) 
			{ 
				$adt=stripslashes(trim($_REQUEST['adate']));
				$where.=" and ack_datetime like '%".$adt."%'";
			} 
			if((isset($_REQUEST['sdate']))&&($_REQUEST['sdate']!='')) 
			{ 
				$sdt=stripslashes(trim($_REQUEST['sdate']));
				$where.=" and solved_datetime like '%".$sdt."%'";
			} 
			if((isset($_REQUEST['cdate']))&&($_REQUEST['cdate']!='')) 
			{ 
				$cdt=stripslashes(trim($_REQUEST['cdate'])); 
				$where.=" and Concat(date,' ',time) like '%".$cdt."%'";
				$where1.=" and Concat(date,' ',time) like '%".$cdt."%'";
			} 
			if((isset($_REQUEST['etxt']))&&($_REQUEST['etxt']!='')) 
			{ 
				$txt=stripslashes(trim($_REQUEST['etxt']));
				$where.=" and error_txt like '%".$txt."%'";
				$where1.=" and error_txt like '%".$txt."%'";
			} 
			if((isset($_REQUEST['remark']))&&($_REQUEST['remark']!='')) 
			{ 
				$rmk=stripslashes(trim($_REQUEST['remark']));
				$where.=" and remark like '%".$rmk."%'";
				$where1.=" and remark like '%".$rmk."%'";
			} 
			
			$blk=''; 
			$whereh="";
			if(isset($_REQUEST['block'])) 
			{ 
				$blk=ucfirst(stripslashes(trim($_REQUEST['block']))); 
				if(($blk!='')&&($blk!='All')) 
				{ 
					$chkblk=str_replace(",","','",$blk); 
					$where.=" and block IN ('".$chkblk."')";
					$where1.=" and block IN ('".$chkblk."')"; 
				} 
			} 
			
			if(isset($_REQUEST['device'])) 
			{ 
				$dvfld=ucfirst(stripslashes(trim($_REQUEST['device']))); 
				if(($dvfld!='')&&($dvfld!='All')) 
				{ 
					$divchk=str_replace(",","','",$dvfld); 
					$where.=" and device_name IN ('".$divchk."')";
					$where1.=" and device_name IN ('".$divchk."')"; 
				} 
			} 
			if(isset($_REQUEST['field'])) 
			{ 
				$fld=ucfirst(stripslashes(trim($_REQUEST['field'])));
				 if(($fld!='')&&($fld!='All')) 
				{ 
					$arrfld=str_replace(",","','",$fld); 
					$where.=" and field IN ('".$arrfld."')";
					$where1.=" and field IN ('".$arrfld."')";
				}
			} 
			
			if(isset($_REQUEST['type'])) 
			{ 
				$tpe=ucfirst(stripslashes(trim($_REQUEST['type'])));
				 if(($tpe!='')&&($tpe!='All')) 
				{ 
					$arrtpe=str_replace(",","','",$tpe); 
					$where.=" and type='".$arrtpe."'";
				}
			}
			if(isset($_REQUEST['alarmtype'])) 
			{ 
				$atpe=ucfirst(stripslashes(trim($_REQUEST['alarmtype'])));
				 if(($atpe!='')&&($atpe!='All')) 
				{ 
					$arratpe=str_replace(",","','",$atpe); 
					$where.=" and altype='".$arratpe."'";
					
				}
			}
			if(isset($_REQUEST['priority'])) 
			{ 
				$prty=ucfirst(stripslashes(trim($_REQUEST['priority'])));
				 if(($prty!='')&&($prty!='All')) 
				{ 
					$priority=str_replace(",","','",$prty); 
					$where.=" and priority='".$priority."'";
					
				}
			}
			if((isset($_REQUEST['history']))&&($_REQUEST['history']!='')) 
			{ 
				$list=ucfirst(stripslashes(trim($_REQUEST['history'])));
				 if($list=='Yes') 
				{ 
					$whereh.=" and status='1'";
				}
				else
				{
					$whereh.=" and status='0'";
				}
			}
			else
			{
				$whereh.=" and status='0'";
			}
			
			$output = array();
			$result = array(); 
			$result1 = array(); 
			$result2 = array();
			if($arratpe=='Event')
			{
				$sTable="events";
				$as="'Null1','Null2','Null3','Null4','Null5','Null6','Null7','Null8'";
				$aColumns = array( 'id', 'datetime', 'type', 'block', 'device_name', 'field', 'error_txt','source');
				$sQuery = "SELECT SQL_CALC_FOUND_ROWS id,Concat(date,' ',time) as datetime,type,block,device_name,field,error_txt,source FROM  events where ts!='' $where1  order by id desc";
				$sQ = "SELECT COUNT(`id`),$as FROM $sTable where id!='' $whereh $where1";
			}
			else
			{
				$sTable="alarm";
				$as="'Null1','Null2','Null3','Null4','Null5','Null6','Null7','Null8','Null9','Null10'";
				$aColumns = array( 'id', 'datetime', 'type', 'block', 'device_name', 'field', 'error_txt','ack_datetime','solved_datetime','reset_datetime');
				$sQuery = "SELECT id,Concat(date,' ',time) as datetime,type,block,device_name,field,error_txt,ack_datetime,solved_datetime,reset_datetime FROM  alarm where ts!='' $where $whereh order by id desc";
				$sQ = "SELECT COUNT(`id`),$as FROM $sTable where id!='' $whereh $where";
			}
			
			if($lmt >=100000)
			{
				$QUERY_BATCH_SIZE = 10000;
				$offset = 0;
				$done = false;
				while(!$done){
					$sQuerytt = "SELECT Concat( '[',Concat(date,' ',time),',',device_name,',',field,',',error_txt,',',ack_datetime,',',solved_datetime,',',reset_datetime,']') as groupval FROM  alarm where ts!='' $where $whereh order by id desc";
				$queryString = $sQuerytt." limit $offset,$QUERY_BATCH_SIZE";
					if($result = mysql_query($queryString))
					{
						if(($numRows = mysql_num_rows($result)) && $numRows > 0)
						{
							while($rlt = mysql_fetch_assoc($result))
							{ 
							   $output[]=$rlt['groupval'];
							}
							$offset += $QUERY_BATCH_SIZE;
						} 
						else 
						{
							$done = true;
						}
					}
					mysql_free_result($result);
				}
			}
			else
			{
				
				$rResultTotal = mysql_query($sQ, $this->db); 
				$aResultTotal = mysql_fetch_array($rResultTotal,MYSQL_ASSOC);
				$result1[] = array_values($aResultTotal);
				
				$slqry=$sQuery." LIMIT $st,$lmt";
				$rResult = mysql_query($slqry, $this->db) or die(mysql_error());
				if(mysql_num_rows($rResult) > 0)
				{ 
					while($rlt = mysql_fetch_array($rResult,MYSQL_ASSOC))
					{ 
						$output[]=array_values($rlt); 
					} 
				} 
				mysql_free_result($rResult);
			}
			
			if($lmt >=100000)
			{
				$this->response($this->json($output), 200); 
			}
			else
			{
				$result2=array_merge($result1,$output);	
				$this->response($this->json($result2), 200); 
			}
             
        }
		
		private function alarm_audio()
	{
		date_default_timezone_set('Asia/Kolkata');
		$dtm=date("Y-m-d");
		
		$result=array();
		$result1=array();
		$result2=array();
		$query = 'SET GLOBAL group_concat_max_len=15000';
mysql_query($query);
		
		$sclalrm="select group_concat(b.id),'Process',count(b.id),IF(count(b.id) > '0', 1 ,0) as amountvalue FROM alarm_fields as a join alarm as b on(a.alarm_field=b.field) where b.date='".$dtm."' and b.altype='process' and a.type='process' and a.status='1' and a.audio_status='1'  and (b.error_txt!='Init' and b.error_txt!='Low_DC_Voltage') and b.reset='1'";
		$sqlalm = mysql_query($sclalrm, $this->db);
		while($rltalm = mysql_fetch_array($sqlalm,MYSQL_ASSOC)){
			$result1[]=array_values($rltalm);
		}
		
		$sclevnt="select group_concat(b.id),'Event',count(b.id),IF(count(b.id) > '0', 1 ,0) as amountvalue FROM alarm_fields as a join events as b on(a.alarm_field=b.field) where  b.date='".$dtm."' and b.altype='event' and a.type='event' and a.status='1' and a.audio_status='1' and b.error_txt='1' and b.reset='1'";
		$sqlevnt = mysql_query($sclevnt, $this->db);
		while($rltevnt = mysql_fetch_array($sqlevnt,MYSQL_ASSOC)){
			$result2[]=array_values($rltevnt);
		}
		
		$sclfire="select group_concat(b.id),'Fire',count(b.id),IF(count(b.id) > '0', 1 ,0) as amountvalue FROM alarm_fields as a join alarm as b on(a.alarm_field=b.field) where  b.date='".$dtm."' and b.altype='fire' and a.type='fire' and a.status='1' and a.audio_status='1' and b.reset='1'";
		$sqlfire = mysql_query($sclfire, $this->db);
		while($rltfire = mysql_fetch_array($sqlfire,MYSQL_ASSOC)){
			$result3[]=array_values($rltfire);
		}
		
		$result=array_merge($result1,$result2,$result3);
		$this->response($this->json($result), 200);

	}
	
	private function audio_reset()
		{
			date_default_timezone_set('Asia/Kolkata');
		$dtm=date("Y-m-d");
			
			$id="";
			$type="";
			$val="";
			if(isset($_REQUEST['id'])) 
			{ 
				$id=stripslashes(trim($_REQUEST['id'])); 
			}
			if(isset($_REQUEST['type']))
			{
				$type =  ucfirst(stripslashes(trim($_REQUEST['type'])));
			}
			if(isset($_REQUEST['val']))
			{
				$val = stripslashes(trim($_REQUEST['val']));
				
			}
			
			if($id!='' && !preg_match("/^null$/i", $id))
			{
				if(preg_match("/^all$/i", $id))
				{
						if($type=='Process')
						{
							$insertQuery = "Update `alarm` set `reset`='".$val."' where id IN (SELECT * FROM (select b.id FROM alarm_fields as a join alarm as b on(a.alarm_field=b.field) where b.date='".$dtm."' and b.altype='process' and a.type='process' and a.status='1' and a.audio_status='1'  and (b.error_txt!='Init' and b.error_txt!='Low_DC_Voltage') and b.reset='1') as p)";
						}
						elseif($type=='Event')
						{
							$insertQuery = "Update `events` set `reset`='".$val."' where id IN (SELECT * FROM (select b.id FROM alarm_fields as a join events as b on(a.alarm_field=b.field) where  b.date='".$dtm."' and b.altype='event' and a.type='event' and a.status='1' and a.audio_status='1' and b.error_txt='1' and b.reset='1') as p)";
						}
						elseif($type=='Fire')
						{
							$insertQuery = "Update `alarm` set `reset`='".$val."' where id IN (SELECT * FROM (select b.id FROM alarm_fields as a join alarm as b on(a.alarm_field=b.field) where b.date='".$dtm."' and b.altype='fire' and a.type='fire' and a.status='1' and a.audio_status='1' and b.reset='1') as p)";
						}
						else
						{
							$insertQuery='';
							$ermsg="some information missing..!";
						}
						//////resetting to other servers/////
						$plant=$this->name;
						if(!isset($_REQUEST['request']))
							{
								$ip=array($this->server1_ip,$this->server2_ip);
								foreach($ip as $ipaddr)
								{
									$send = curl_init();
									echo '<br>'. $ack = str_replace(" ","%20","http://$ipaddr/$plant/ScadaApi/audio_reset?type=$type&val=$val&id=all&request=server");
									curl_setopt($send,CURLOPT_URL,$ack);
									curl_setopt($send,CURLOPT_RETURNTRANSFER,true);
									curl_setopt($send,CURLOPT_HEADER, false);
									curl_setopt($send,CURLOPT_TIMEOUT,30);
									$result=curl_exec($send);
									if($result){echo "<br>Audio reset requested to $ipaddr<br>";}else{echo "<br>Audio reset not requested to $ipaddr<br>";}
									echo curl_error($send);
									curl_close($send);
								}
							}
					///////----/////////
				}
				else
				{
						if($type=='Process' || $type=='Fire')
						{
							$insertQuery = "Update `alarm` set `reset`='".$val."' where id IN (".$id.")";
						}
						elseif($type=='Event')
						{
							$insertQuery = "Update `events` set `reset`='".$val."' where id IN (".$id.")";
						}
						else
						{
							$insertQuery='';
							$ermsg="some information missing..!";
						}
					}
					if($insertQuery!='')
					{
						$inslt=mysql_query($insertQuery) or die(mysql_error());
						echo $insertQuery;
						if($inslt)
						{
							echo "Sucess";
						}
						else
						{
							echo "Fail";
						}
					}
					else
					{
					 echo $ermsg;
					}
			}
			else
			{
				echo "Alarm Id is Empty..!";
			}
		}
 
   private function smucomparison()
		{
			date_default_timezone_set('Asia/Kolkata'); 
			$slmnth=date("m");
			$crtyr=date("Y");
			$sdd=date("d");
			$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr); 
			$endTime = mktime(0, 0, 0, $slmnth, $sdd + 1, $crtyr); 
			$where="";
			$result=array();
			if(isset($_REQUEST['block']))
			{
				$blk=ucfirst(stripslashes(trim($_REQUEST['block'])));
				if(($blk!='')&&($blk!='All'))
				{
					$chkblk=str_replace(",","','",$blk);
					$where.=" and (blockname IN ('".$chkblk."'))";
				}
			}
			if(isset($_REQUEST['device']))
			{
				$dvfld=ucfirst(stripslashes(trim($_REQUEST['device'])));
				if(($dvfld!='')&&($dvfld!='All'))
				{
					$divchk=str_replace(",","','",$dvfld);
					$where.=" and (device_name IN ('".$divchk."'))";
				}
			}
			if(isset($_REQUEST['smustatus']))
			{
				$sts=ucfirst(stripslashes(trim($_REQUEST['smustatus'])));
				if(($sts!='')&&($sts!='All'))
				{
					$stsc=str_replace(",","','",$sts);
					$where.=" and (smustatus IN ('".$stsc."'))";
				}
			}
			$selectQuery = "select a.ts,a.device_name,b.module,a.smustatus,a.modulecldate,a.duration,a.moduleduedate from smucomparison_data AS a JOIN smustringconn AS b ON(a.device_name=b.device) where a.ts = '".$startTime."' $where order by a.blockname,a.device_name";
			$sql = mysql_query($selectQuery, $this->db);
			if(mysql_num_rows($sql) > 0)
			{
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
				{
					$result[]=array_values($rlt);
				}
			}
			$this->response($this->json($result), 200);
	     }
		 
private function systemarch()
	{	
		$blk=''; 
		$where=""; 
		if(isset($_REQUEST['block'])) 
		{ 
			$blk=ucfirst(stripslashes(trim($_REQUEST['block']))); 
			if(($blk!='')&&($blk!='All')) 
			{ 
				$chkblk=str_replace(",","','",$blk); 
				$where.=" and (block IN ('".$chkblk."'))";
				$block="FIELD(block, '".$chkblk."')";
			}
			else{$block="block";}
		} 
		if(isset($_REQUEST['device'])) 
		{ 
			$dvfld=ucfirst(stripslashes(trim($_REQUEST['device']))); 
			if(($dvfld!='')&&($dvfld!='All')) 
			{ 
				$divchk=str_replace(",","','",$dvfld); 
				$where.=" and (device IN ('".$divchk."'))"; 
				$device="FIELD(device, '".$divchk."')";
			}
			else{$device="device";}
		} 
		if(isset($_REQUEST['field'])) 
		{ 
			$fld=ucfirst(stripslashes(trim($_REQUEST['field']))); 
			if(($fld!='')&&($fld!='All')) 
			{ 
				$arrfld=str_replace(",","','",$fld); 
				$where.=" and (field IN ('".$arrfld."'))";
				$field="FIELD(field, '".$arrfld."')";
			}
			else{$field="field";}
		} 
		$result = array();
		if(($blk!='')&&($dvfld!='')&&($fld!=''))
		{
			$sclqry="select block,device,field,value FROM system_architecture where block!='' $where order by $block, $device, $field";
			$sql = mysql_query($sclqry, $this->db);
			if(mysql_num_rows($sql) > 0)
			{
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
				 $result[]=array_values($rlt);
				}
			}
			mysql_free_result($sql);
			$this->response($this->json($result), 200);
		}
	}
			 
private function systemarchitCR()
 {
  date_default_timezone_set('Asia/Kolkata'); 
  $where="";
  $result=array();
  $result1=array();$result2=array();$result3=array();
  $selectQuery1 ="select blockname,count(value) as  value from scada_latest_igate_data where device_name like 'CR_EM0%' and field ='COMMUNICATION_STATUS' and value NOT IN ('nan','NaN','Nan','1') group by blockname order by blockname";
  $sql1 = mysql_query($selectQuery1, $this->db);
  if(mysql_num_rows($sql1) > 0)
  {
   $rlt1= mysql_fetch_assoc($sql1,MYSQL_ASSOC);
   $blockname1 = $rlt1['blockname'];
   $crStatus1 = $blockname1.'1';
   $rlt1['value'];
   if($rlt1['value'] == 2)
   {
    $communStatus1 = 0;
   }
   else
   {
    $communStatus1 = 0;
   }
  }
  else {
   $communStatus1 =1;
  
  }

  $selectQuery2 ="select blockname,count(value) as  value from scada_latest_igate_data where device_name like 'ELITE_%' and field ='COMMUNICATION_STATUS' and value NOT IN ('nan','NaN','Nan','1') group by blockname order by blockname";
  $sql2 = mysql_query($selectQuery2, $this->db);
  if(mysql_num_rows($sql2) > 0)
  {
    $rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC);
    $blockname2 = $rlt2['blockname'];
    $crStatus2 = $blockname2.'2';
    if($rlt2['value'] == 7)
    {
     $communStatus2 = 0;
    }
    else
    {
     $communStatus2 = 0;
    }
  }
  else {
   $communStatus2 =1;
  
  }
  
  $selectQuery3 ="select blockname,device_name,value from scada_latest_igate_data where blockname IN ('CR','WS') and device_name IN('IO','CRP_IO','WS') and field ='COMMUNICATION_STATUS' order by blockname";
  $sql3 = mysql_query($selectQuery3, $this->db);
  if(mysql_num_rows($sql3) > 0)
  {
    while($rlt3 = mysql_fetch_array($sql3,MYSQL_ASSOC))
    {
    if($rlt3['device_name']=='CRP_IO')
    {
       if($rlt3['value']== 'nan' || $rlt3['value']== 'NaN' || $rlt3['value']== 'Nan' || $rlt3['value']== '1')
       {
		$communStatus3=1;
        }
     else
     {
      $communStatus3=0;
     }
    }
    if($rlt3['device_name']=='WS')
    {
       if($rlt3['value']== 'nan'|| $rlt3['value']== 'NaN' || $rlt3['value']== 'Nan' || $rlt3['value']== '1')
       {
		$communStatus4=1;
        }
     else
     {
		$communStatus4=0;
     }
    }  
    }  
  }
	if($communStatus1==1 && $communStatus2==1 && $communStatus3==1 && $communStatus4==1)
	{
		$crName ="CR";
		$communStatus=1;
	}
	else
	{
		$crName ="CR";
		$communStatus=0;
	}
	
	$result[] =array($crName, $communStatus); 
    $this->response($this->json($result), 200);    
 }
 
	private function mis_graph()
	{
		date_default_timezone_set('Asia/Kolkata'); 
		$slmnth=date("m");
		$crtyr=date("Y");
		$sdd=date("d");
		$today=mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
		if((isset($_REQUEST['date']))&&($_REQUEST['date']!=''))
		{
		 $sdd=stripslashes(trim($_REQUEST['date']));
		}
		if((isset($_REQUEST['month']))&&($_REQUEST['month']!=''))
		{
		 $slmnth=stripslashes(trim($_REQUEST['month']));
		}
		if((isset($_REQUEST['year']))&&($_REQUEST['year']!=''))
		{
		 $crtyr=stripslashes(trim($_REQUEST['year']));
		}
		
		if((isset($_REQUEST['type']))&&($_REQUEST['type']!=''))
		{
		 $tpe=strtolower(stripslashes(trim($_REQUEST['type'])));
		}
		$where="";
		if(isset($_REQUEST['device']))
		{
			$dvfld=ucfirst(stripslashes(trim($_REQUEST['device'])));
			if(($dvfld!='')&&($dvfld!='All'))
			{
				$divchk=str_replace(",","','",$dvfld);
				$where=" and (device_name IN ('".$divchk."','WS'))";
				$where1=" and (device IN ('".$divchk."','CR_WS'))";
			}
		}  
	
   if($tpe=="month")
   {
	$sdd='01';
	$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
	$endTime = mktime(0, 0, 0, $slmnth+1, $sdd, $crtyr);
	$sclqry="SELECT ts,device,field,value FROM `day_variable` WHERE ts >= $startTime and ts < $endTime and field IN('EAE_DAY','SOLAR_RADIATION_CUM','PR_DAY') $where1 order by FIELD(field, 'EAE_DAY','SOLAR_RADIATION_CUM','PR_DAY'),ts";
	
   }
   elseif($tpe=="year")
   {
	$slmnth='01';
	$sdd='01';
	$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
	$endTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr+1);
	 $sclqry="SELECT FROM_UNIXTIME(ts, '01-%m-%Y') as ts,device,field,CASE WHEN field LIKE 'PR_DAY' THEN AVG(ABS(value)) ELSE SUM(ABS(value)) END AS value FROM `day_variable` WHERE ts >= $startTime and ts < $endTime and field IN('EAE_DAY','SOLAR_RADIATION_CUM','PR_DAY') $where1  group by Month(FROM_UNIXTIME(ts)),field order by FIELD(field, 'EAE_DAY','SOLAR_RADIATION_CUM','PR_DAY'),ts";
   }
    elseif($tpe=="week")
   {
	   $startTime = mktime(0, 0, 0, $slmnth, $sdd-6, $crtyr);
		$endTime = mktime(0, 0, 0, $slmnth, $sdd+1, $crtyr);
		$sclqry="SELECT ts,device,field,value FROM `day_variable` WHERE ts >= $startTime and ts < $endTime and field IN('EAE_DAY','SOLAR_RADIATION_CUM','PR_DAY') $where1 order by FIELD(field, 'EAE_DAY','SOLAR_RADIATION_CUM','PR_DAY'),ts";
   }
   else
   {
	   $startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
		$endTime = mktime(0, 0, 0, $slmnth, $sdd+1, $crtyr);
		
		if($startTime==$today)
			{
				$tbl="5min_data_today";
				$groupby='';
			}
			else
			{	
				$groupby='GROUP BY (12 * HOUR(FROM_UNIXTIME(insertedts)) + FLOOR(MINUTE(FROM_UNIXTIME(insertedts))/5)),field';
				if(($slmnth==date("m")) && ($crtyr==date("Y")))
				{
					$tbl="1min_data";
				}
				else
				{
				  $tbl="1min_data_".date("M_Y",$startTime);
				}
			}
			
		$sclqry="select insertedts,device_name,field,value as value from ".$tbl." 
		where ts >= $startTime and ts < $endTime AND field IN ('EAE_DAY','SOLAR_RADIATION','PAC') and device_name IN ('CR_EM01','CR_WS') $groupby order by FIELD(field, 'PAC','SOLAR_RADIATION','EAE_DAY'),ts";
   }
   		$result = array();
		$sql = mysql_query($sclqry, $this->db);
		if(mysql_num_rows($sql) > 0)
		{
			while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
			{
			$result[]=array_values($rlt);
			}
		}
		$this->response($this->json($result), 200);
	}
	
	/*igate check*/
	private function systemarchit()
	{
		date_default_timezone_set('Asia/Kolkata'); 
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
		
		 $qry="select blockname,count(*) as 'errcount' from scada_latest_igate_data where  field='COMMUNICATION_STATUS' and device_name!='' and blockname!='/ram/' $shr group by blockname order by blockname";
		$sq=mysql_query($qry);
		$num=mysql_num_rows($sq);
		$result=array();
		if($num>0)
		{
			while($fetch=mysql_fetch_array($sq,MYSQL_ASSOC))
			{
				$blk=$fetch['blockname'];
				$errc=$fetch['errcount'];
				 $selectQuery = "select '".$blk."',CASE count(*) WHEN '".$errc."' THEN '1' ELSE '0' END from scada_latest_igate_data where blockname='".$blk."' and field ='COMMUNICATION_STATUS' and value='nan'";
				$sql= mysql_query($selectQuery, $this->db);
				if(mysql_num_rows($sql) > 0)
				{
					while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
					  $result[]=array_values($rlt);
					}
				}
			}
		}
		$this->response($this->json($result), 200);
	}
		
	
	/*MAINPAGE REPORT START*/
	private function report_mainpage()
		{
		date_default_timezone_set('Asia/Kolkata'); 
		$slmnth=date("m");
		$crtyr=date("Y");
		$sdd=date("d");
		$where="";
		$where1="";
		$result1 = array();
		if(isset($_REQUEST['block']))
		{
			$blk=ucfirst(stripslashes(trim($_REQUEST['block'])));
			if(($blk!='')&&($blk!='All'))
			{
				$chkblk=str_replace(",","','",$blk);
				$where.=" and (block IN ('".$chkblk."'))";
				$where1.=" and (block IN ('".$chkblk."','WS'))";
			}
		}
		if(isset($_REQUEST['device']))
		{
			$dvfld=ucfirst(stripslashes(trim($_REQUEST['device'])));
			if(($dvfld!='')&&($dvfld!='All'))
			{
				$divchk=str_replace(",","','",$dvfld);
				$where.=" and (device IN ('".$divchk."'))";
				$where1.=" and (device IN ('".$divchk."','WS'))";
			}
		}
		if((isset($_REQUEST['type']))&&($_REQUEST['type']!=''))
		{
		  $tpe=strtolower(stripslashes(trim($_REQUEST['type'])));
		}

		if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
			{ 
			$from=stripslashes(trim($_REQUEST['sd'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $from);
			}
			if($crtyr==date("Y")){
		$now = time();
     	$firstDay = mktime(0, 0, 0, 01, 01, $crtyr);
    	$dyYr= floor(($now - $firstDay)/(60*60*24));
			}
			else{$dyYr=365;}
		$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
		$endTime = mktime(0, 0, 0, $slmnth, $sdd+1, $crtyr);
		 $sclqry1="select 'Day',device,field,DATE(FROM_UNIXTIME(ts)) as ts,value FROM `day_variable` WHERE ts='".$startTime."' $where and `field`IN('CUF','EAE_DAY','EAI_DAY','EAN_DAY') order by FIELD(field, 'CUF','EAE_DAY','EAI_DAY','EAN_DAY')";	
		$sql1 = mysql_query($sclqry1, $this->db) or die(mysql_error());
		if(mysql_num_rows($sql1) > 0)
		{
			while($rlt1 = mysql_fetch_array($sql1,MYSQL_ASSOC)){
			 $result1[]=array_values($rlt1);
			}
		}
		$startTimeMon = mktime(0, 0, 0, $slmnth, 01, $crtyr);
		$endTimeMon = mktime(0, 0, 0, $slmnth+1, 01, $crtyr);
		
		$sclqry2="select 'Month',device,field,DATE(FROM_UNIXTIME($startTime)) as ts, CASE WHEN field = 'CUF' THEN (AVG(value)) ELSE sum(value) end as value FROM `day_variable` WHERE ts>='".$startTimeMon."' and ts<'".$endTimeMon."' $where and `field`IN('CUF','EAE_DAY','EAI_DAY','EAN_DAY') Group by field order by FIELD(field, 'CUF','EAE_DAY','EAI_DAY','EAN_DAY')";
		$sql2 = mysql_query($sclqry2, $this->db);
		if(mysql_num_rows($sql2) > 0)
		{
			while($rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC)){
			 $result2[]=array_values($rlt2);
			}
		}
		$startTimeYr = mktime(0, 0, 0, 01, 01, $crtyr);
		$endTimeYr = mktime(0, 0, 0, 01, 01, $crtyr+1);
		$sclqry3="select 'Year',device,field,DATE(FROM_UNIXTIME($startTime)) as ts, CASE WHEN field = 'CUF' THEN AVG(value) ELSE sum(value) end as value FROM `day_variable` WHERE ts>='".$startTimeYr."' and ts<'".$endTimeYr."' $where and `field`IN('CUF','EAE_DAY','EAI_DAY','EAN_DAY') Group by field order by FIELD(field, 'CUF','EAE_DAY','EAI_DAY','EAN_DAY')";
		$sql3 = mysql_query($sclqry3, $this->db);
		if(mysql_num_rows($sql3) > 0)
		{
			while($rlt3 = mysql_fetch_array($sql3,MYSQL_ASSOC)){
			 $result3[]=array_values($rlt3);
			}
		}
		$sclpac="select block,device,field,FROM_UNIXTIME(ts) as ts,value FROM `day_variable` WHERE ts='".$startTime."' $where1 and `field`IN('PAC_MAX','PR_DAY','SOLAR_RADIATION_CUM','SOLAR_RADIATION_MAX','SOLAR_RADIATION_AVG','AMBIENT_TEMP_AVG','OPERATIONAL_TIME') order by FIELD(field, 'PAC_MAX','PR_DAY','SOLAR_RADIATION_CUM','SOLAR_RADIATION_MAX','SOLAR_RADIATION_AVG','AMBIENT_TEMP_AVG','OPERATIONAL_TIME')";
		$sqlpac = mysql_query($sclpac, $this->db);
		if(mysql_num_rows($sqlpac) > 0)
		{
			while($rltpac = mysql_fetch_array($sqlpac,MYSQL_ASSOC))
			{
			$result4[]=array_values($rltpac);
			}
		}
		$result=array();
		$result=array_merge($result1,$result2,$result3,$result4);
		$this->response($this->json($result), 200);
		}
		/*MAINPAGE REPORT END*/
		/*REPORT PARAMETER START*/
		private function report_parameter() 
        { 
			date_default_timezone_set('Asia/Kolkata');  
			$slmnth=date("m"); 
			$crtyr=date("Y"); 
			$sdd=date("d"); 
			$today = mktime(0, 0, 0, $slmnth, $sdd, $crtyr);
			
			if((isset($_REQUEST['sd']))&&($_REQUEST['sd']!='')) 
		{ 
			$from=stripslashes(trim($_REQUEST['sd'])); 
			list($sdd, $slmnth, $crtyr) = explode("/",  $from);
		} 
			$startTime = mktime(0, 0, 0, $slmnth, $sdd, $crtyr); 
			$endTime = mktime(0, 0, 0, $slmnth, $sdd + 1, $crtyr); 
			
			$blk=''; 
			$where=""; 
			if(isset($_REQUEST['block'])) 
			{ 
				$blk=ucfirst(stripslashes(trim($_REQUEST['block']))); 
				if(($blk!='')&&($blk!='All')) 
				{ 
					$chkblk=str_replace(",","','",$blk); 
					$where.=" and (blockname IN ('".$chkblk."'))"; 
				} 
			} 
			
			if(isset($_REQUEST['device'])) 
			{ 
				$dvfld=ucfirst(stripslashes(trim($_REQUEST['device']))); 
				if(($dvfld!='')&&($dvfld!='All')) 
				{ 
					$divchk=str_replace(",","','",$dvfld); 
					$where.=" and (device_name IN ('".$divchk."'))"; 
				} 
			} 
			if(isset($_REQUEST['field'])) 
			{ 
				$fld=ucfirst(stripslashes(trim($_REQUEST['field']))); 
				if(($fld=='')||($fld=='All')) 
				{ 
					$where.=" and (field IN ('EAI','PAC','EAE','Solar_Radiation','Solar_Radiation_5min_AVG','AMBIENT_TEMP','Wind_Speed'))"; 
				} 
				else
				{
					$arrfld=str_replace(",","','",$fld); 
					$where.=" and (field IN ('".$arrfld."'))"; 
				}
			} 
			if($startTime==$today)
			{
				$tbl="5min_data_today";
			}
			else
			{
				if(($slmnth==date("m")) && ($crtyr==date("Y")))
				{
					$tbl="1min_data";
				}
				else
				{
				  $tbl="1min_data_".date("M_Y",$startTime);
				}
			}
			if($fld!='')
			{
				$result = array();
			$sclqry="select blockname,device_name,field,FROM_UNIXTIME(insertedts),round(value,3) as value from ".$tbl." where ts >= $startTime and ts < $endTime and (device_name IN ('$this->lf','WS')) $where GROUP BY ( 4 * HOUR(from_unixtime(insertedts)) + FLOOR( MINUTE(from_unixtime(insertedts)) / 15 )),field,device_name,blockname order by FIELD(field, 'EAI','PAC','EAE','Solar_Radiation','Solar_Radiation_5min_AVG','AMBIENT_TEMP','Wind_Speed'),insertedts,device_name,blockname";
				$sql = mysql_query($sclqry, $this->db) or die(mysql_error()); 
				if(mysql_num_rows($sql) > 0)
				{ 
					while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
					{ 
					 $result1[]=array_values($rlt); 
					} 
				} 
				$sclqry2="select blockname,device_name,field,FROM_UNIXTIME(insertedts),round(value,3) from ".$tbl." where ts >= $startTime and ts < $endTime and device_name = 'WS' and field = 'MODULE_TEMP_AVG' GROUP BY insertedts,field order by insertedts";
				$sql2 = mysql_query($sclqry2, $this->db); 
				if(mysql_num_rows($sql2) > 0)
				{ 
					while($rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC))
					{ 
					 $result2[]=array_values($rlt2); 
					} 
				}
				$result=array_merge($result1,$result2);
				mysql_free_result($sql);
				$this->response($this->json($result), 200); 
			}
        }
		/*REPORT PARAMETER END*/
		
		//	Encode array into JSON
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}
	
	// Initiiate Library
	$api = new API;
	$api->processApi();
?>