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
       $query = $this->db->get('alarm_users');
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
			$query = $this->db->get('alarm_users');
			if($query->num_rows >0)
			{
				$row = $query->row();
				return $row;
			}
		}
	}
}
?>