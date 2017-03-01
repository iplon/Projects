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

		$mysqlHostName =$this->hostname;
		$mysqlUserName =$this->username;
		$mysqlPassword =$this->password;
		$mysqlDatabaseName =$this->dbname;
		$mint=1;
		$tblname="1min_data_today_csv";
		$tblname2="1min_data_text_today_csv";
		$tblname3="day_variable";
		$typ="1Mints";
		$fold=date('d_m_Y',strtotime("-1 days"));
		$exp=explode('_',$fold);
		$startTimeYest = mktime(0, 0, 0,  $exp[1],  $exp[0],  $exp[2]);
$tmp = "/var/www/csvbackup";
                $cmnd="mkdir ".$tmp;
                $chmod="chmod -R 777 ".$tmp;
                if (!is_dir($tmp)) {
                        exec($cmnd);
                        exec($chmod);
echo "success";
                }

$tmp = $tmp."/".$typ;
                $cmnd="mkdir ".$tmp;
                $chmod="chmod -R 777 ".$tmp;
                if (!is_dir($tmp)) {
                        exec($cmnd);
                        exec($chmod);
                }

		$tmp = $tmp."/".$fold;
		$cmnd="mkdir ".$tmp;
		$chmod="chmod -R 777 ".$tmp;
		if (!is_dir($tmp)) {
			exec($cmnd);
			exec($chmod);
		}
		$path="var/www/csvbackup/".$typ."/".$fold;
			$sqlblk=mysql_query("select DISTINCT(blockname) AS blockname from device where blockname!='' order by blockname");
			$numblk=mysql_num_rows($sqlblk);
			if($numblk>0)
			{
				while($fetchblk=mysql_fetch_array($sqlblk))
				{
					$blk=$fetchblk['blockname'];
					$tbl=$fold."_".$this->dbname."_".$blk;
					$mysqlExportPath =$path.'/'.$tbl.'.csv';
					$mysqlExportPath=stripslashes(trim($mysqlExportPath));

					if(is_file($mysqlExportPath))
					unlink($mysqlExportPath);
					$sql="select FROM_UNIXTIME(ts) as DateTime,blockname,device_name,field,value from ".$this->dbname.".".$tblname." where ts >= ".$startTimeYest." and ts < ".$this->startTime." and blockname='".$blk."' order by ts";

					$command="mysql -h" .$mysqlHostName ." -u" .$mysqlUserName ." -p" .$mysqlPassword ." --quick -e \"".$sql."\" > /".$mysqlExportPath;
					echo'<br><br>'. $command;
					exec($command,$output=array(),$worked);

					//String table//
					$tbl1=$fold."_".$this->dbname."_".$blk."_text";
					$mysqlExportPath1 =$path.'/'.$tbl1.'.csv';
					$mysqlExportPath1=stripslashes(trim($mysqlExportPath1));

					if(is_file($mysqlExportPath1))
					unlink($mysqlExportPath1);

					$sql1="select FROM_UNIXTIME(ts) as DateTime,blockname,device_name,field,value from ".$this->dbname.".".$tblname2." where ts >= ".$startTimeYest." and ts < ".$this->startTime." and blockname='".$blk."' order by ts";

				$command1="mysql -h" .$mysqlHostName ." -u" .$mysqlUserName ." -p" .$mysqlPassword ." --quick -e \"".$sql1."\" > /".$mysqlExportPath1;
				exec($command1,$output1=array(),$worked1);
				}
				mysql_free_result($sqlblk);
			}
		$tmp2 = "/var/www/csvbackup/Day_variable";
        $cmnd2="mkdir ".$tmp2;
        $chmod2="chmod -R 777 ".$tmp2;
        if (!is_dir($tmp2)) {
        exec($cmnd2);
        exec($chmod2);
        }
				$mysqlExportPath2=$tmp2."/Day_variable_".$fold.".csv";

				$sql2="SELECT FROM_UNIXTIME(ts,'%Y-%m-%d') as DateTime, block as Block, device as Device, field as Field , value as Value FROM ".$this->dbname.".".$tblname3." where ts = ".$startTimeYest." order by block,device,field";

				$command2="mysql -h" .$mysqlHostName ." -u" .$mysqlUserName ." -p" .$mysqlPassword ." --quick -e \"".$sql2."\" > ".$mysqlExportPath2;
				echo $command2;
				exec($command2,$output2=array(),$worked2);
	}
}
$plantov = new Csv_process();
?>
