<?php
	$string = file_get_contents("data.json");
	$json = json_decode($string, true);
	$plantname=$json['plant']['name'];
	$hostname=$json['db_credential']['hostname'];
	$username=$json['db_credential']['username'];
	$password=$json['db_credential']['password'];
	$dbname=$json['db_credential']['dbname'];
	$connect = mysql_connect($hostname,$username,$password);
	if (!$connect) {die('Could not connect to MySQL: ' . mysql_error()); 
	} 
	$db =mysql_select_db($dbname,$connect);	
	date_default_timezone_set('Asia/Kolkata');  
	$slmnth=date("m"); 
	$crtyr=date("Y"); 
	$sdd=date("d"); 
	$arratpe="";
	$st=0;
	$lmt=100000;
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
		$pri=ucfirst(stripslashes(trim($_REQUEST['priority'])));
		 if(($pri!='')&&($pri!='All')) 
		{ 
			$priority=str_replace(",","','",$pri); 
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
			$whereh.="";
		}
	}
	else
	{
		$whereh.="";
	}
	$output = array();
	$result = array(); 
	$result1 = array(); 
	$result2 = array();
	if($arratpe=='Event')
	{
		$aColumns = array('Active At','Block','Equipment','Command Type','Source');
		$select = "SELECT Concat(date,' ',time) as datetime,block,field,error_txt,source FROM  events where ts!='' $where1  order by id desc  LIMIT $st,$lmt";
		$tt=$plantname."global_save_events_".date('d_M_Y').".xls";
		
	}
	else
	{
		$aColumns = array('Active At','Block','Equipment','Alarm Text','Alarm Code','Inactive At','Acknowledge','Reset');
		$select = "SELECT Concat(date,' ',time) as datetime,block,device_name,field,error_txt,solved_datetime,ack_datetime,reset_datetime FROM  alarm where ts!='' $where $whereh order by id desc LIMIT $st,$lmt";
		$tt=$plantname."_global_save_alarms_".date('d_M_Y').".xls";
	}
	
for ( $i = 0; $i < count($aColumns); $i++ )
{
$header .= $aColumns[$i] . "\t";
}

$export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );
while( $row = mysql_fetch_row( $export ) )
{
$line = '';
foreach( $row as $value )
{                                            
	if ( ( !isset( $value ) ) || ( $value == "" ) )
	{
	$value = "\t";
}
else
{
	$value = str_replace( '"' , '""' , $value );
	$value = '"' . $value . '"' . "\t";
}
	$line .= $value;
}
$data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );
	
if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}
mysql_free_result($export);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$tt");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
?>
