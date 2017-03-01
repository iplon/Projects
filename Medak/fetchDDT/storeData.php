<?php
include_once("config.php");
class storeData extends config	{
	public function __construct()	{
		parent::__construct();
		$this->storeData();
	}

	public function storeData()	{
		include_once("readDDt.php");
		$lst_day=date("t");
		$min = date('i');
		$this->now = mktime($this->chr, $min, 0,  $this->slmnth,  $this->sdd,  $this->crtyr)-60;
		$this->startCheck = $this->now - 300;
		$format=1;
		$data_num=array();
		$data_text=array();
		$data_graph=array();
		$sqlqry="SELECT blk_dv_fld_id,ts,blockname,device_name,field,format,value,graph FROM latest_igate_data WHERE ts >= $this->startCheck AND blockname!='' AND device_name!='' AND field!=''";
		$qry= mysql_query($sqlqry);
		$num=mysql_num_rows($qry);
		if($num>0)	{
			if ($min%5=='01')	{
				while($fetch=mysql_fetch_array($qry))	{
					set_time_limit(60);
					$blk_dv_fld_id=$fetch['blk_dv_fld_id'];
					$ts=$fetch['ts'];
					$blk=$fetch['blockname'];
					$dve=$fetch['device_name'];
					$fld=$fetch['field'];
					$format=$fetch['format'];
					$val=$fetch['value'];
					$val=str_replace("'","",$val);
					$graph=$fetch['graph'];
					if($format!=10)	{
						if (($val=="nan") || ($val=="inf"))
							$val="NULL";
						else
							$val=(float)$val;
						$data_num[]="('".$blk_dv_fld_id."','".$this->now."',".$val.")";
						if($graph==1)	{
							$data_graph[]="('".$blk_dv_fld_id."','".$this->now."',".$val.")";
						}
					}
					else {
						if ($val=="nan")
							$val="NULL";
						$data_text[]="('".$blk_dv_fld_id."','".$this->now."','".$val."')";
					}
				}
			}
			else {
				while($fetch=mysql_fetch_array($qry))	{
					set_time_limit(60);
					$blk_dv_fld_id=$fetch['blk_dv_fld_id'];
					$ts=$fetch['ts'];
					$blk=$fetch['blockname'];
					$dve=$fetch['device_name'];
					$fld=$fetch['field'];
					$format=$fetch['format'];
					$val=$fetch['value'];
					$val=str_replace("'","",$val);
					if($format!=10)	{
						if (($val=="nan") || ($val=="inf"))
							$val="NULL";
						else
							$val=(float)$val;
						$data_num[]="('".$blk_dv_fld_id."','".$this->now."',".$val.")";
					}
					else {
						if ($val=="nan")
							$val="NULL";
						$data_text[]="('".$blk_dv_fld_id."','".$this->now."','".$val."')";
					}
				}
			}

			$data=implode(",",$data_num);
			$insq="INSERT IGNORE 1min_data (blk_dv_fld_id,insertedts,value) VALUES ".$data;
			$insertsq1=mysql_query($insq);
			$insq="INSERT IGNORE 1min_data_today (blk_dv_fld_id,insertedts,value) VALUES ".$data;
			$insertsq2=mysql_query($insq);
			if ($min%5=='01')	{
				$data=implode(",",$data_graph);
				$insq="INSERT IGNORE 5min_data (blk_dv_fld_id,insertedts,value) VALUES ".$data;
				$insertsq5=mysql_query($insq);
				$insq="INSERT IGNORE 5min_data_today (blk_dv_fld_id,insertedts,value) VALUES ".$data;
				$insertsq6=mysql_query($insq);
			}
			$data=implode(",",$data_text);
			$insq="INSERT IGNORE 1min_data_text (blk_dv_fld_id,insertedts,value) VALUES ".$data;
			$insertsq3=mysql_query($insq);
			$insq="INSERT IGNORE 1min_data_text_today (blk_dv_fld_id,insertedts,value) VALUES ".$data;
			$insertsq4=mysql_query($insq);

			if((!$insertsq1) || (!$insertsq2) || (!$insertsq3) || (!$insertsq4))	{
				$create = "CREATE TABLE IF NOT EXISTS `1min_data` (
				`blk_dv_fld_id` INT(5) NOT NULL,
				`insertedts` INT(10) NOT NULL,
				`value` FLOAT DEFAULT NULL,
				PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin DELAY_KEY_WRITE=1 ROW_FORMAT=FIXED";
				$create.=" PARTITION BY RANGE(blk_dv_fld_id)(";
				$dpt=mysql_result(mysql_query("SELECT count(*) FROM fields_num"),0);
				$dpp=250;
		    $part=(int)($dpt/$dpp) + 2;
				for($start=1; $start<=$part; $start++)	{
					$ite=($start * $dpp);
					$create.="PARTITION P".$start." VALUES LESS THAN (".$ite.") ,";
				}
				$create=trim($create, ",");
				$create.=");";
				mysql_query($create);

				$create = "CREATE TABLE IF NOT EXISTS `5min_data` (
				`blk_dv_fld_id` INT(5) NOT NULL,
				`insertedts` INT(10) NOT NULL,
				`value` FLOAT DEFAULT NULL,
				PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin DELAY_KEY_WRITE=1 ROW_FORMAT=FIXED";
				$create.=" PARTITION BY RANGE(blk_dv_fld_id)(";
				$dpt=mysql_result(mysql_query("SELECT count(*) FROM fields_num"),0);
				$dpp=250;
		    $part=(int)($dpt/$dpp) + 2;
				for($start=1; $start<=$part; $start++)	{
					$ite=($start * $dpp);
					$create.="PARTITION P".$start." VALUES LESS THAN (".$ite.") ,";
				}
				$create=trim($create, ",");
				$create.=");";
				mysql_query($create);

				$create = "CREATE TABLE IF NOT EXISTS `1min_data_text` (
				`blk_dv_fld_id` INT(5) NOT NULL,
				`insertedts` INT(10) NOT NULL,
				`value` VARCHAR(64) DEFAULT NULL,
				PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC";
				mysql_query($create);

				$create = "CREATE TABLE IF NOT EXISTS `1min_data_today` (
				`blk_dv_fld_id` INT(5) NOT NULL,
				`insertedts` INT(10) NOT NULL,
				`value` FLOAT DEFAULT NULL,
				PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=FIXED";
				mysql_query($create);

				$create = "CREATE TABLE IF NOT EXISTS `1min_data_text_today` (
				`blk_dv_fld_id` INT(5) NOT NULL,
				`insertedts` INT(10) NOT NULL,
				`value` VARCHAR(64) DEFAULT NULL,
				PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=FIXED";
				mysql_query($create);

				$create = "CREATE TABLE IF NOT EXISTS `5min_data_today` (
				`blk_dv_fld_id` INT(5) NOT NULL,
				`insertedts` INT(10) NOT NULL,
				`value` FLOAT DEFAULT NULL,
				PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=FIXED";
				mysql_query($create);

				$sqlqry="SELECT blk_dv_fld_id,ts,blockname,device_name,field,format,value,graph FROM latest_igate_data WHERE ts >= $this->startCheck AND blockname!='' AND device_name!='' AND field!=''";
				$qry= mysql_query($sqlqry);
				$num=mysql_num_rows($qry);
				if($num>0)	{
					if ($min%5=='01')	{
						while($fetch=mysql_fetch_array($qry))	{
							set_time_limit(60);
							$blk_dv_fld_id=$fetch['blk_dv_fld_id'];
							$ts=$fetch['ts'];
							$blk=$fetch['blockname'];
							$dve=$fetch['device_name'];
							$fld=$fetch['field'];
							$format=$fetch['format'];
							$val=$fetch['value'];
							$val=str_replace("'","",$val);
							$graph=$fetch['graph'];
							if($format!=10)	{
								if (($val=="nan") || ($val=="inf"))
									$val="NULL";
								else
									$val=(float)$val;
								$data_num[]="('".$blk_dv_fld_id."','".$this->now."',".$val.")";
								if($graph==1)	{
									$data_graph[]="('".$blk_dv_fld_id."','".$this->now."',".$val.")";
								}
							}
							else {
								if ($val=="nan")
									$val="NULL";
								$data_text[]="('".$blk_dv_fld_id."','".$this->now."','".$val."')";
							}
						}
					}
					else {
						while($fetch=mysql_fetch_array($qry))	{
							set_time_limit(60);
							$blk_dv_fld_id=$fetch['blk_dv_fld_id'];
							$ts=$fetch['ts'];
							$blk=$fetch['blockname'];
							$dve=$fetch['device_name'];
							$fld=$fetch['field'];
							$format=$fetch['format'];
							$val=$fetch['value'];
							$val=str_replace("'","",$val);
							if($format!=10)	{
								if (($val=="nan") || ($val=="inf"))
									$val="NULL";
								else
									$val=(float)$val;
								$data_num[]="('".$blk_dv_fld_id."','".$this->now."',".$val.")";
							}
							else {
								if ($val=="nan")
									$val="NULL";
								$data_text[]="('".$blk_dv_fld_id."','".$this->now."','".$val."')";
							}
						}
					}
				}

				$data=implode(",",$data_num);
				$insq="INSERT IGNORE 1min_data (blk_dv_fld_id,insertedts,value) VALUES ".$data;
				$insertsq1=mysql_query($insq);
				$insq="INSERT IGNORE 1min_data_today (blk_dv_fld_id,insertedts,value) VALUES ".$data;
				$insertsq2=mysql_query($insq);
				if ($min%5=='01')	{
					$data=implode(",",$data_graph);
					$insq="INSERT IGNORE 5min_data (blk_dv_fld_id,insertedts,value) VALUES ".$data;
					$insertsq5=mysql_query($insq);
					$insq="INSERT IGNORE 5min_data_today (blk_dv_fld_id,insertedts,value) VALUES ".$data;
					$insertsq6=mysql_query($insq);
				}
				$data=implode(",",$data_text);
				$insq="INSERT IGNORE 1min_data_text (blk_dv_fld_id,insertedts,value) VALUES ".$data;
				$insertsq3=mysql_query($insq);
				$insq="INSERT IGNORE 1min_data_text_today (blk_dv_fld_id,insertedts,value) VALUES ".$data;
				$insertsq4=mysql_query($insq);

				if((!$insertsq1) || (!$insertsq2) || (!$insertsq3) || (!$insertsq4))	{
					echo mysql_error();
				}

				mysql_query("FLUSH TABLES 1min_data WITH READ LOCK");
				mysql_query("UNLOCK TABLES");
				mysql_query("FLUSH TABLES 1min_data_text WITH READ LOCK");
				mysql_query("UNLOCK TABLES");
				if ($min%5=='01')	{
					mysql_query("FLUSH TABLES 5min_data WITH READ LOCK");
					mysql_query("UNLOCK TABLES");
				}

				if (($this->chr=='01')&&($min=='00'))	{
					mysql_query("FLUSH TABLES");
				}

				/* csv file creation process will do here */
				if(($this->chr=='00')&&($min=='00'))	{
					mysql_query("TRUNCATE TABLE 5min_data_today");
					mysql_query("DROP TABLE 1min_data_today_csv");
					mysql_query("RENAME TABLE 1min_data_today TO 1min_data_today_csv");
					mysql_query("DROP TABLE 1min_data_today_text_csv");
					mysql_query("RENAME TABLE 1min_data_text_today TO 1min_data_text_today_csv");

					$create = "CREATE TABLE IF NOT EXISTS `1min_data_today` (
					`blk_dv_fld_id` INT(5) NOT NULL,
					`insertedts` INT(10) NOT NULL,
					`value` FLOAT DEFAULT NULL,
					PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=FIXED";
					mysql_query($create);

					$create = "CREATE TABLE IF NOT EXISTS `1min_data_text_today` (
					`blk_dv_fld_id` INT(5) NOT NULL,
					`insertedts` INT(10) NOT NULL,
					`value` VARCHAR(64) DEFAULT NULL,
					PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=FIXED";
					mysql_query($create);
				}

				/* For FIFO Use */
				if(($this->sdd=='01')&&($this->chr=='00')&&($min=='00'))	{
					$renametbl="1min_data";
					$newname="1min_data_".date("M_Y", strtotime("last month"));
					$renm="RENAME TABLE `" . $renametbl . "` TO `" . $newname . "`";
					$reqry=mysql_query($renm);
					$renametbl1="1min_data_text";
					$newname1="1min_data_text_".date("M_Y", strtotime("last month"));
					$renm1="RENAME TABLE `" . $renametbl1 . "` TO `" . $newname1 . "`";
					$reqry1=mysql_query($renm1);
					if($renm)	{
						$create = "CREATE TABLE IF NOT EXISTS `1min_data` (
						`blk_dv_fld_id` INT(5) NOT NULL,
						`insertedts` INT(10) NOT NULL,
						`value` FLOAT DEFAULT NULL,
						PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin DELAY_KEY_WRITE=1 ROW_FORMAT=FIXED";
						$create.=" PARTITION BY RANGE(blk_dv_fld_id)(";
						$dpt=mysql_result(mysql_query("SELECT count(*) FROM fields_num"),0);
						$dpp=250;
				    $part=(int)($dpt/$dpp) + 2;
						for($start=1; $start<=$part; $start++)
						{
							$ite=($start * $dpp);
							$create.="PARTITION P".$start." VALUES LESS THAN (".$ite.") ,";
						}
						$create=trim($create, ",");
						$create.=");";
						mysql_query($create);
					}
					if($renm1)	{
						$create = "CREATE TABLE IF NOT EXISTS `1min_data_text` (
						`blk_dv_fld_id` INT(5) NOT NULL,
						`insertedts` INT(10) NOT NULL,
						`value` VARCHAR(64) DEFAULT NULL,
						PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin DELAY_KEY_WRITE=1 ROW_FORMAT=FIXED";
						mysql_query($create);
					}
					mysql_query("FLUSH TABLES $newname WITH READ LOCK");
					mysql_query("OPTIMIZE TABLE $newname");
					mysql_query("ANALYZE TABLE $newname");
					mysql_query("UNLOCK TABLE");
					mysql_query("FLUSH TABLES $newname1 WITH READ LOCK");
					mysql_query("OPTIMIZE TABLE $newname1");
					mysql_query("ANALYZE TABLE $newname1");
					mysql_query("UNLOCK TABLES");
				}

				if(($lst_day==$this->sdd)&&($this->chr=='23')&&($min=='56'))	{
					$renametbl="5min_data";
					$newname="5min_data_".date("M_Y");
					$renm="RENAME TABLE `" . $renametbl . "` TO `" . $newname . "`";
					$reqry=mysql_query($renm);
					if($renm)	{
						$create = "CREATE TABLE IF NOT EXISTS `5min_data` (
						`blk_dv_fld_id` INT(5) NOT NULL,
						`insertedts` INT(10) NOT NULL,
						`value` FLOAT DEFAULT NULL,
						PRIMARY KEY (`blk_dv_fld_id`,`insertedts`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin DELAY_KEY_WRITE=1 ROW_FORMAT=FIXED";
						$create.=" PARTITION BY RANGE(blk_dv_fld_id)(";
						$dpt=mysql_result(mysql_query("SELECT count(*) FROM fields_num"),0);
						$dpp=250;
				    $part=(int)($dpt/$dpp) + 2;
						for($start=1; $start<=$part; $start++)	{
							$ite=($start * $dpp);
							$create.="PARTITION P".$start." VALUES LESS THAN (".$ite.") ,";
						}
						$create=trim($create, ",");
						$create.=");";
						mysql_query($create);
					}
					mysql_query("FLUSH TABLES $newname WITH READ LOCK");
					mysql_query("OPTIMIZE TABLE $newname");
					mysql_query("ANALYZE TABLE $newname");
					mysql_query("UNLOCK TABLES");
				}

				if(($this->chr=='00')&&($min=='15'))	{
					mysql_query("FLUSH TABLES 1min_data_today WITH READ LOCK");
					mysql_query("OPTIMIZE TABLE 1min_data_today");
					mysql_query("ANALYZE TABLE 1min_data_today");
					mysql_query("UNLOCK TABLES");
					mysql_query("FLUSH TABLES 1min_data_text_today WITH READ LOCK");
					mysql_query("OPTIMIZE TABLE 1min_data_text_today");
					mysql_query("ANALYZE TABLE 1min_data_text_today");
					mysql_query("UNLOCK TABLES");
				}
				if(($this->sdd=='01')&&($this->chr=='00')&&($min=='05'))	{
					mysql_query("FLUSH TABLES 1min_data WITH READ LOCK");
					mysql_query("OPTIMIZE TABLE 1min_data");
					mysql_query("ANALYZE TABLE 1min_data");
					mysql_query("UNLOCK TABLES");
					mysql_query("FLUSH TABLES 1min_data_text WITH READ LOCK");
					mysql_query("OPTIMIZE TABLE 1min_data_text");
					mysql_query("ANALYZE TABLE 1min_data_text");
					mysql_query("UNLOCK TABLES");
				}
				if(($this->chr=='00')&&($min=='11'))	{
					mysql_query("FLUSH TABLES 5min_data_today WITH READ LOCK");
					mysql_query("OPTIMIZE TABLE 5min_data_today");
					mysql_query("ANALYZE TABLE 5min_data_today");
					mysql_query("UNLOCK TABLES");
				}
				if(($this->sdd=='01')&&($this->chr=='00')&&($min=='06'))	{
					mysql_query("FLUSH TABLES 5min_data WITH READ LOCK");
					mysql_query("OPTIMIZE TABLE 5min_data");
					mysql_query("ANALYZE TABLE 5min_data");
					mysql_query("UNLOCK TABLES");
				}

				if($insertsq1)
					echo "StoreData\t".date("Y-m-d H:i:s")."\tStoreData\tInserted\t".$num."\tDatapoints\ttook\t";
				else
					echo "StoreData\t".date("Y-m-d H:i:s")."\tStoreData\tNot_Inserted\t";
				mysql_free_result($qry);
				$msc=microtime(true)-$this->msc;
				echo $msc."\tseconds\n";
				mysql_close($this->db);
			}
			else
				echo "StoreData\t".date("Y-m-d H:i:s")."\tStoreData\tNo_New_Datapoints_to_Insert\n";
		}
	}
}
$storeData = new storeData();
$storeData = null;
?>
