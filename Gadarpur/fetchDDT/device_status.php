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
$fields = array("Datetime","Block","Device","Type","Value");
for ( $i = 0; $i < count($fields); $i++ )
{
	$header .= $fields[$i] . "\t";
}
			
		$select="select FROM_UNIXTIME(a.ts) as datetime,a.blockname,a.device_name,b.type,a.value from scada_latest_igate_data as a join device as b on(a.device_name=b.device_name) WHERE a.field = 'COMMUNICATION_STATUS' AND (a.value = 1 OR a.value = 'NaN') order by b.type,a.blockname,a.device_name,a.field";
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

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$plantname."_Not_Communicated_Device_List.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
?>
