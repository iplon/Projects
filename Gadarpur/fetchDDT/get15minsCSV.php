<?php
include_once("config.php");
ini_set('display_errors', 1);
class Csv_process extends config{
	public function __construct(){
		parent::__construct();
		$this->csvprocess();
	}
public function csvprocess()
	{
		$month = date('M_Y');
		$date = date('d_m_Y');
		$plantname = $this->plantname;
		$mysqlHostName =$this->hostname;
		$mysqlUserName =$this->username;
		$mysqlPassword =$this->password;
		$mysqlDatabaseName =$this->dbname;
		$mint=1;
		$tblname="1min_data_today";
		$fold=date('d_m_Y_h',strtotime("0 days"));
		$typ="15MintsData";
		
		$exp=explode('_',$fold);
		$startTimeYest = mktime(0, 0, 0,  $exp[1],  $exp[0],  $exp[2]);
		
		$mints = array(17,32,47,2);
		
		
		foreach($mints as $min)
		{
			
			if(date('i')!= $min){
			//echo "success";		
			}
			else{
				if($min == 17)
				{
				$fold = $fold."_15_".date('A');	
				}
				elseif($min == 32){
				$fold = $fold."_30_".date('A');	
				}
				elseif($min == 47){
				$fold = $fold."_45_".date('A');	
				}
				elseif($min == 02){
				$fold = $fold."_".date('A');	
				}
				else{
				$fold = $fold."_".date('A').$min;		
				}
			$endtime =  time();
		$starttime = time()-(60*17);
				 $tmp = "/var/www/csvbackup/".$typ;
		$cmnd="mkdir ".$tmp; 
		$chmod="chmod -r 777 ".$tmp;
		if (!is_dir($tmp)) {
			exec($cmnd);
			exec($chmod);
		}
		
		$mysqlExportPath2=$tmp."/".$fold.".csv";
		
				$where = " where insertedts >= ".$starttime." and insertedts < ".$endtime." and 
				
				blockname IN('CR','WS') and device_name IN('CR_EM01','WS') and (field IN ('PAC','AMBIENT_TEMP','Solar_Radiation')) order by ts,device_name, field";
				echo $sql="select FROM_UNIXTIME(insertedts) as DateTime,field,value from ".$this->dbname.".".$tblname." $where";
					
				$command2="mysql -h" .$mysqlHostName ." -u" .$mysqlUserName ." -p" .$mysqlPassword ." --quick -e \"".$sql."\" > ".$mysqlExportPath2;
				echo $command2;
				exec($command2,$output2=array(),$worked2);
				
				$ftp_server = "data.reconnectenergy.com";
$ftp_username = "iplon_sol";
$ftp_userpass = 'ip3%$89%on';

$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

$file = $mysqlExportPath2;
$month = date('M_Y');
$date = date('d_m_Y');
$month_dir = "/IPLON/15MinsData/".$month;
if(!is_dir($month_dir)){
	ftp_mkdir($ftp_conn, $month_dir);
}
$date_dir = $month_dir."/".$date;
if(!is_dir($date_dir)){
	ftp_mkdir($ftp_conn, $date_dir);
}

//$ftpserverfile = $date_dir."/".$fold.".csv";
$ftpserverfile = $date_dir."/".$fold.".csv"; 
// $file = "/var/www/index.html";
// $ftpserverfile = "test.html";
ftp_pasv($ftp_conn, true);
// upload file
if (ftp_put($ftp_conn, $ftpserverfile, $file, FTP_ASCII))
  {
  echo "Successfully uploaded $file.";
  }
else
  {
  echo "Error uploading $file.";
  }

// close connection
ftp_close($ftp_conn);
				
			
			}
		}
		
		
		// print date('H:i');
		if(date('H:i')=="00:10"){
		$cmnd = "rm /var/www/csvbackup/15MintsData/*";
		exec($cmnd);
		
		}
		
	
	}		
}
$plantov = new Csv_process();
?>