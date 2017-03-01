<?php
include_once("config.php");
class Create_deviceid extends config{
	public function __construct(){
		parent::__construct();
		$this->createdeviceid();
	}
	
	public function createdeviceid()
	  {
		$msg=array();
		/////Store device and its details
		$ins=mysql_query("select ip,format,blockname,device_name from scada_latest_igate_data where blockname!='' and device_name!='' and field!='' group by device_name order by id");
		$num=mysql_num_rows($ins);
		if($num!=0)
		{
			while($fetins=mysql_fetch_array($ins))
			{
				$fmt=$fetins['format'];
				$blk=$fetins['blockname'];
				$snm=$fetins['device_name'];
				$ip=$fetins['ip'];
					$arr=explode(".",$ip);
					$igateid=$arr[2].$arr[3];
					if(strlen($arr[3])==1)
					{
						$igateid=$arr[2]."0".$arr[3];
					}
							
					$type=$blk;
					if( preg_match( "/SMU/i", $snm) )
					{
						$type="Smu";
					}
					elseif ((preg_match("/INV/i", $snm)))
					{
						$type="Inverter";
					}
					elseif( preg_match( "/IO/i", $snm) )
					{
						$type="IO";
					}
					elseif(preg_match( "/HTP/i", $snm) || preg_match( "/SRP/i", $snm) || preg_match( "/EM/i", $snm))
					{
						$type="EM";
					}	
				 $msg[]="('".$igateid."','".$type."','".$blk."','2','".$snm."','-1','-1','1')";
			}
			
				$data=implode(",",$msg);
				$insq="insert Ignore into device (igate,type,blockname,capacity,device_name,parent,master,status) values  ".$data;
				echo $insq."<br>";
				mysql_query($insq) or die(mysql_error());
		}
		/*//Assign unique id for each data points
		$ins=mysql_query("select blockname,device_name,field from scada_latest_igate_data where blockname!='' and device_name!='' and field!='' group by blockname,device_name,field");
		$num=mysql_num_rows($ins);
		if($num!=0)
		{
			while($fetins=mysql_fetch_array($ins))
			{
				$blk=$fetins['blockname'];
				$dev=$fetins['device_name'];
				$fld=$fetins['field'];
				$msg2[]="('".$blk."','".$dev."','".$fld."','1')";
			}
				$data2=implode(",",$msg2);
				$insq2="Insert Ignore into fields (blockname,device_name,field,status) values  ".$data2;
				echo "<br><br><br>".$insq2."<br>";
				mysql_query($insq2) or die(mysql_error());
		}*/
				mysql_close($this->db);		
	}
}
$deviceid = new Create_deviceid();
?>