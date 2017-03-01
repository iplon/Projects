<?php
include_once("config.php");
class Fifo_email_alert extends config{
	public function __construct(){
		parent::__construct();
		$this->fifoemailalert();
	}


public function sent_mail($wch,$dp)
{
	$proxy_ins="http://pv-india.net/email_alert_2.php?wch=".$wch."&dp=".$dp; 
	$url = str_replace(" ","%20",$proxy_ins); // to properly format the url 
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,30);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

public function delete_directory($dirname) {
         if (is_dir($dirname))
           $dir_handle = opendir($dirname);
	 if (!$dir_handle)
	      return false;
	 while($file = readdir($dir_handle)) {
	       if ($file != "." && $file != "..") {
		     $dir_f=$dirname."/".$file;
	            if (!is_dir($dir_f))
				{
				  $fmtime=filemtime($dir_f);
				  $bfr=strtotime('-90 days');
				  if ($fmtime < $bfr) 
				  { 
					unlink($dir_f);
				   }
				}	 
				else
				{
				 $this->delete_directory($dirname.'/'.$file);
				}
	       }
	 }
	 closedir($dir_handle);
	 rmdir($dirname);
	 return true;
}

public function formatSize( $bytes )
{
        $types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
        return( round( $bytes, 2 ) . " " . $types[$i] );
}


public function fifoemailalert()
{
ob_start();
ob_get_clean();
$cur_date=date("Y-m-d");
$dir = '/var/www/csvbackup';

/* get disk space free (in bytes) */
$df = disk_free_space("/") + disk_free_space("/var");
/* and get disk space total (in bytes)  */
$dt = disk_total_space("/") + disk_total_space("/var");
/* now calculate the disk space used (in bytes) */
$du = $dt - $df;
/* percentage of disk used - this will be used to also set the width % of the progress bar */
$dp = sprintf('%.2f',($du / $dt) * 100);

/* formate the size from bytes to MB, GB, etc. */
$df = $this->formatSize($df);
$du = $this->formatSize($du);
$dt = $this->formatSize($dt);


$srchmnth=mktime(0,0,0,$this->slmnth,$this->sdd-90,$this->crtyr);
$plant_name = $this->plantname;
$server_name= gethostname();
$wch= $plant_name.' '.$server_name;
//$wch="Lomada Plant Data Server";
if($dp >=90)
{
    $sl="select id,status from email_alert where createdAt='".$cur_date."' and status=1";
	$sql=mysql_query($sl);
	$numq=mysql_num_rows($sql);
	if($numq==0)
	{
		$result=$this->sent_mail($wch,$dp);
		if($result=='1')
		{
			$msg1="Mail Sent";
			$in="Insert into email_alert (disk_usage_in_percn,createdAt,remarks,status) values ('".$dp."',now(),'".$msg1."',1)";
		}
		else
		{
			$msg1="Mail Not Sent";
			$in="Insert into email_alert (disk_usage_in_percn,createdAt,remarks,status) values ('".$dp."',now(),'".$msg1."',0)";
		}
		if($in!='')
		{
		 $insq=mysql_query($in);
		 echo $msg1;
		}
	}
	else
	{
	  echo "Today Mail Already sent";
	}
}
/*elseif($dp >96)
{
  $slq="SELECT TABLE_NAME,CREATE_TIME FROM  INFORMATION_SCHEMA.PARTITIONS WHERE UNIX_TIMESTAMP(CREATE_TIME)<='".$srchmnth."' and TABLE_SCHEMA = 'punjab'  AND (TABLE_NAME  like  TABLE_NAME  like '%1min_data%') and  TABLE_NAME  not like '%today%'  order by CREATE_TIME";
	$qry=mysql_query($slq) or die(mysql_error());
	$num=mysql_num_rows($qry);
	if($num)
	{
		while($fetch=mysql_fetch_array($qry))
		{
			$tbl=$fetch['TABLE_NAME'];
			//$drp="Drop Table ".$tbl;
			//$qrydrp=mysql_query($drp);
		}
	}
	//echo $this->delete_directory($dir);
}*/
else
{
 echo "Disc Usage is ".$dp;
}
	mysql_close($this->db);		
	}
}
$fifo = new Fifo_email_alert();
?>