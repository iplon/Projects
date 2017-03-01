<?php
/* File : Config.php
	 * Author : Saradha P
	*/
class Config {

		public $db = NULL;
		
		/*
		 *  Init parent contructor
		 *	Initiate Database connection
		*/
		
		public function __construct(){
			//parent::__construct();
			$this->readJsondata();				
			$this->dbConnect();
			$this->datefetch();
			$this->common();			
		}
		
		/*
		 *  Database connection 
		*/
		private function dbConnect(){
			$this->db = mysql_connect($this->hostname,$this->username,$this->password);
			if($this->db)
			mysql_select_db($this->dbname,$this->db) or die(mysql_error());
		}
		
		/*
		 * Public method for JSON DATA.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function readJsondata(){
			$string = file_get_contents("data.json");
			$json = json_decode($string, true);
			$this->plantname=$json['plant']['name'];
			$this->hostname=$json['db_credential']['hostname'];
			$this->username=$json['db_credential']['username'];
			$this->password=$json['db_credential']['password'];
			$this->dbname=$json['db_credential']['dbname'];
			$this->lf=$json['Energy_Meters']['lf'];
			$this->lf1=$json['Energy_Meters']['lf1'];
			$this->lf2=$json['Energy_Meters']['lf2'];
			$this->incommers=$json['Energy_Meters']['incommers'];
			$this->section=$json['Energy_Meters']['incommers_sec'];
			$this->name_blocks=$json['blocks']['name'];
			$this->num_blocks=$json['blocks']['num'];
			$this->inv=$json['inverters']['inv'];
			$this->inverter=$json['inverters']['inverter'];
			$this->mw1=$json['plantov']['1mw'];
			$this->mw2=$json['plantov']['2mw'];
			$this->mw3=$json['plantov']['3mw'];
		}
		
		/*
		 * Public method for Date & Time Fetching.
		 * This method dynmically call the method based on the query string
		 *
		 */
		 public function datefetch()
		 {	date_default_timezone_set('Asia/Kolkata');
			$this->msc=microtime(true);
			$this->nowtime = time();
			$this->slmnth=date("m");
			$this->crtyr=date("Y");
			$this->sdd=date("d");
			$this->chr=date('H');

			if((isset($_REQUEST['date']))&&($_REQUEST['date']!=''))
			{
			 $this->sdd=stripslashes(trim($_REQUEST['date']));
			}
			if((isset($_REQUEST['month']))&&($_REQUEST['month']!=''))
			{
			 $this->slmnth=stripslashes(trim($_REQUEST['month']));
			}
			if((isset($_REQUEST['year']))&&($_REQUEST['year']!=''))
			{
			 $this->crtyr=stripslashes(trim($_REQUEST['year']));
			}
			$this->startTime = mktime(0, 0, 0,  $this->slmnth,  $this->sdd,  $this->crtyr);
			$this->endTime = mktime(0, 0, 0,  $this->slmnth,  $this->sdd+1,  $this->crtyr);
			$this->today = mktime(0, 0, 0, $this->slmnth, $this->sdd, $this->crtyr); 
		 }
		 
		 /*
		 * Common values: constant, variables
		 */
		public function common(){
			ini_set('display_errors', 1);
		}
	
}

?>
