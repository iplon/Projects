<?php
include_once("config.php");
class createFieldId extends config  {
	public function __construct()	{
		parent::__construct();
		$this->createFieldId();
	}

	public function createFieldId()
  {
    $msc=microtime(true);
		$msg1=array();
		$msg2=array();
		$msg3=array();
    $sclqry="SELECT blockname,device_name,field,format FROM scada_latest_igate_data WHERE blockname!='' AND device_name!='' AND field!='' AND format IN (0,1,10) AND idoffset !=0 AND blockname NOT LIKE '%/r%' AND device_name NOT LIKE '%/r%' AND field NOT LIKE '%/r%' AND blockname NOT LIKE '%.%' AND device_name NOT LIKE '%.%' AND field NOT LIKE '%.%' GROUP BY blockname,device_name,field ORDER BY format,field,device_name,blockname";
    $ins=mysql_query($sclqry);
    $num=mysql_num_rows($ins);
    $csql = "CREATE TABLE IF NOT EXISTS `fields` (
            `blk_dv_fld_id` INT(10) NOT NULL AUTO_INCREMENT,
            `blockname` VARCHAR(5) NOT NULL,
            `device_name` VARCHAR(30) NOT NULL,
            `field` VARCHAR(50) NOT NULL,
            `status` INT(2) NOT NULL,
            `format` INT(2) NOT NULL,
						`graph` INT(2) NOT NULL DEFAULT 0,
            PRIMARY KEY (`blk_dv_fld_id`),
            UNIQUE KEY `bdf` (`blockname`,`device_name`,`field`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1";
    //echo $csql;
    mysql_query($csql);
    $csql = "CREATE TABLE IF NOT EXISTS `fields_num` (
            `blk_dv_fld_id` INT(10) NOT NULL AUTO_INCREMENT,
            `blockname` VARCHAR(5) NOT NULL,
            `device_name` VARCHAR(30) NOT NULL,
            `field` VARCHAR(50) NOT NULL,
            `status` INT(2) NOT NULL,
            `format` INT(2) NOT NULL,
						`graph` INT(2) NOT NULL DEFAULT 0,
            PRIMARY KEY (`blk_dv_fld_id`),
            UNIQUE KEY `bdf` (`blockname`,`device_name`,`field`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1";
    //echo $csql;
    mysql_query($csql);
    $csql = "CREATE TABLE IF NOT EXISTS `fields_text` (
            `blk_dv_fld_id` INT(10) NOT NULL AUTO_INCREMENT,
            `blockname` VARCHAR(5) NOT NULL,
            `device_name` VARCHAR(30) NOT NULL,
            `field` VARCHAR(50) NOT NULL,
            `status` INT(2) NOT NULL,
            `format` INT(2) NOT NULL,
						`graph` INT(2) NOT NULL DEFAULT 0,
            PRIMARY KEY (`blk_dv_fld_id`),
            UNIQUE KEY `bdf` (`blockname`,`device_name`,`field`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1";
    //echo $csql;
    mysql_query($csql);

    if($num!=0)
    {
			$fields_oc=mysql_result(mysql_query("SELECT COUNT(*) FROM fields"),0);
			$fields_num_oc=mysql_result(mysql_query("SELECT COUNT(*) FROM fields_num"),0);
			$fields_text_oc=mysql_result(mysql_query("SELECT COUNT(*) FROM fields_text"),0);
      while($fetins=mysql_fetch_array($ins))
    	{
    		$blk=$fetins['blockname'];
    		$dev=$fetins['device_name'];
    		$fld=$fetins['field'];
    		$fmt=$fetins['format'];
    		$msg1[]="('".$blk."','".$dev."','".$fld."','".$fmt."','1')";
        if($fmt==10)
          $msg2[]="('".$blk."','".$dev."','".$fld."','".$fmt."','1')";
				else
          $msg3[]="('".$blk."','".$dev."','".$fld."','".$fmt."','1')";
    	}
    	$data1=implode(",",$msg1);
      $data2=implode(",",$msg2);
      $data3=implode(",",$msg3);
    	$insq1="INSERT IGNORE INTO fields (blockname,device_name,field,format,status) VALUES ".$data1;
    	mysql_query($insq1);
      $insq2="INSERT IGNORE INTO fields_text (blockname,device_name,field,format,status) VALUES ".$data2;
      mysql_query($insq2);
      $insq3="INSERT IGNORE INTO fields_num (blockname,device_name,field,format,status) VALUES ".$data3;
      mysql_query($insq3);
			$fields_nc=mysql_result(mysql_query("SELECT COUNT(*) FROM fields"),0);
			$fields_num_nc=mysql_result(mysql_query("SELECT COUNT(*) FROM fields_num"),0);
			$fields_text_nc=mysql_result(mysql_query("SELECT COUNT(*) FROM fields_text"),0);

			$create = "CREATE TABLE IF NOT EXISTS `latest_igate_data` (
			`blk_dv_fld_id` INT(10) NOT NULL DEFAULT 0,
			`ts` INT NOT NULL,
			`blockname` VARCHAR(5) NOT NULL,
			`device_name` VARCHAR(30) NOT NULL,
			`field` VARCHAR(50) NOT NULL,
			`format` INT(2) NOT NULL,
			`value` VARCHAR(64) NOT NULL,
			`graph` INT(2) NOT NULL DEFAULT 0,
			UNIQUE KEY `bdf` (`blockname`,`device_name`,`field`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
			mysql_query($create);

			mysql_query("TRUNCATE TABLE latest_igate_data");
			$insq="INSERT INTO latest_igate_data(blk_dv_fld_id,blockname,device_name,field,format,graph) SELECT blk_dv_fld_id,blockname,device_name,field,format,graph FROM fields_num ON DUPLICATE KEY UPDATE blk_dv_fld_id=VALUES(blk_dv_fld_id),format=VALUES(format)";
			$insertsq=mysql_query($insq);
			if(!$insertsq)
				echo mysql_error();
			$insq="INSERT INTO latest_igate_data(blk_dv_fld_id,blockname,device_name,field,format,graph) SELECT blk_dv_fld_id,blockname,device_name,field,format,graph FROM fields_text ON DUPLICATE KEY UPDATE blk_dv_fld_id=VALUES(blk_dv_fld_id),format=VALUES(format)";
			mysql_query($insq);
			$insq="INSERT INTO latest_igate_data(ts,blockname,device_name,field,value) SELECT ts,blockname,device_name,field,value FROM scada_latest_igate_data WHERE blockname!='' AND device_name!='' AND field!='' ON DUPLICATE KEY UPDATE ts=VALUES(ts),value=VALUES(value)";
			mysql_query($insq);
    }
		mysql_query("DROP TABLES fields_backup, fields_num_backup, fields_text_backup, latest_igate_data_backup");
    mysql_query("CREATE TABLE fields_backup ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_bin SELECT * FROM fields");
    mysql_query("CREATE TABLE fields_num_backup ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_bin SELECT * FROM fields_num");
    mysql_query("CREATE TABLE fields_text_backup ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_bin SELECT * FROM fields_text");
		mysql_query("CREATE TABLE latest_igate_data_backup ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_bin SELECT * FROM latest_igate_data");
		//$filename="/var/www/$this->plantname/fetchDDT/csv/fields_".date("Y-m-d_H:i:s").".csv";

		if ($fields_oc != $fields_nc)	{
			mysql_query("CREATE TABLE fields_".date("Y_m_d_H_i_s")." ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_bin SELECT * FROM fields");
			mysql_query("SELECT * INTO OUTFILE 'fields_".date("Y_m_d_H_i_s").".csv' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' FROM fields");
		}
		if ($fields_num_oc != $fields_num_nc)	{
    	mysql_query("CREATE TABLE fields_num_".date("Y_m_d_H_i_s")." ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_bin SELECT * FROM fields_num");
			mysql_query("SELECT * INTO OUTFILE 'fields_num_".date("Y_m_d_H_i_s").".csv' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' FROM fields_num");
		}
		if ($fields_text_oc != $fields_text_nc)	{
    	mysql_query("CREATE TABLE fields_text_".date("Y_m_d_H_i_s")." ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_bin SELECT * FROM fields_text");
			mysql_query("SELECT * INTO OUTFILE 'fields_text_".date("Y_m_d_H_i_s").".csv' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' FROM fields_text");
		}
		//mysql_query("CREATE TABLE latest_igate_data_".date("Y_m_d_H_i_s")." ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_bin SELECT * FROM latest_igate_data");

		echo "createFieldId\t".date("Y-m-d H:i:s")."\tInserted\tDatapoints\ttook\t";
		$msc=microtime(true)-$this->msc;
		echo $msc."\tseconds\t\n";
  }
}
$createFieldId = new createFieldId();
$createFieldId = null;
?>
