<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */
class Login_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function validate(){
       $username = $this->security->xss_clean($this->input->post('username'));
       $password = $this->security->xss_clean($this->input->post('password'));
       $this->db->where('username', $username);
       $this->db->where('password', md5($password));
       $query = $this->db->get('users');
		//echo $this->db->last_query();exit;
        if($query->num_rows >0)
        {
            $row = $query->row();
            $data = array(
                    'id' => $row->userId,
                    'username' => $row->Name
                    );	
			$loginUserdata = array('userid'=>$row->userId,
									'username'=>$row->Name,
									'timestamp'=>mktime(),
									'ipaddress'=>$_SERVER['REMOTE_ADDR'],
									'success'=>1);	
			$this->db->insert('logins',$loginUserdata); 								
			$this->session->set_userdata('logged_in',$data);
            return true;
        }
		return false;
    }
	
	function getlogindetails($userid)
	{
		if($userid!='')
		{
			$this->db->select('timestamp');
			$this->db->where('userid', $userid);
			$query = $this->db->get('logins');
			if($query->num_rows >0)
			{
				$row = $query->row();
				return $row->timestamp;
			}
			
		}
	}
	function getuserDetails($userId)
	{
		if($userId!='')
		{
			$this->db->select('*');
			$this->db->where('id',$userId);
			$query = $this->db->get('users');
			if($query->num_rows >0)
			{
				$row = $query->row();
				return $row;
			}
		}
	}
	
	function getnewreport($userId)
	{
		if($userId!='')
		{
		$this->db->select('*');
		$this->db->order_by("id", "asc");		
        $query = $this->db->get('new_reports');  
		//echo $this->db->last_query();exit;
		foreach ($query->result() as $row){
            $results = array(
                'id' => $row->id,
				'report_title' => $row->report_title,
                'report_name' => $row->report_name,
                'report_type' => $row->report_type,
				'block' => $row->block,
				'interval' => $row->interval
            );
		}
       return $query->result();
		}
	}
	
	
	////////add new report//////////
	
public function add_new($plant,$title,$name,$type,$interval)
    {
$tbl = 'new_reports';	
$plant="'".$plant."'";
$title="'".$title."'";
$name="'".$name."'";
$type="'".$type."'";
$interval="'".$interval."'";
$block="1";
$sql="insert into ".$tbl." (`plant`,`report_title`,`report_name`,`report_type`,`interval`,`block`) values($plant,$title,$name,$type,$interval,$block)";
    $query = $this->db->query($sql);
	}	
////////calc revenue//////////
public function add_revenue($ts,$plant,$cexport,$import,$nexport,$cuf,$revenue)
    {
$tbl = 'abt_revenue';	
$ts="'".$ts."'";
$plant="'".$plant."'";
$cexport="'".$cexport."'";
$import="'".$import."'";
$nexport="'".$nexport."'";
$cuf="'".$cuf."'";
$revenue="'".$revenue."'";
$sql="replace into ".$tbl." (`ts`,`plant`,`cross_export`,`import`,`net_export`,`cuf`,`revenue_cost`) values($ts,$plant,$cexport,$import,$nexport,$cuf,$revenue)";
    $query = $this->db->query($sql);
	}

///delete new report
public function del_report($id)
    {	
	$this->db->where('id', $id);
	$this->db->delete('new_reports');
	}	
	}
?>