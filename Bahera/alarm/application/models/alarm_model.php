<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Alarm_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }


	function getList()
	{		
			$sql="SELECT id,alarm_type,alarm_field,type,priority, CASE WHEN audio_status LIKE 0 THEN 'Inactive' ELSE 'Active' END AS audio_status,CASE WHEN history_enable LIKE 0 THEN 'Inactive' ELSE 'Active' END AS history_enable,CASE WHEN status LIKE 0 THEN 'Inactive' ELSE 'Active' END AS status from alarm_fields order by type,alarm_type,alarm_field";			
			$query = $this->db->query($sql);			
			//echo $this->db->last_query();exit;
			foreach ($query->result() as $rows) 					 				
						$row[] = $rows;																								
			
				return $row;

	}

			
	function getList1()
	{		
			$sql1="SELECT DISTINCT field from scada_latest_igate_data where field NOT IN (select alarm_field from alarm_fields) and field not like '' and device_name not like '' and blockname not like '' and field not like '%ram%' and device_name not like '%ram%' and blockname not like '%ram%' order by field ASC";
			$query1 = $this->db->query($sql1);			
			//echo $this->db->last_query();exit;
			foreach ($query1->result() as $rows) 					 				
						$row[] = $rows;																								
			
				return $row;

	}			
	
	
	function alarmRemove($id)
	{									
			$sql="delete from alarm_fields where id=".$id;			
			$query = $this->db->query($sql);										
	}
	
	function alarmEdit($id)
	{					
			$this->db->where('id', $id);
			$edit = $this->db->get('alarm_fields')->row();			
			return $edit;
	}
	
	function alarmAudio($id,$st)
	{						
			$sql="update alarm_fields set audio_status='".$st."' where id=".$id;									
			$query = $this->db->query($sql);											
				return 'sucess';

	}
	
	
	function alarmPriority($id,$priority)
	{						
			$sql="update alarm_fields set priority='".$priority."' where id=".$id;									
			$query = $this->db->query($sql);											
				return 'sucess';

	}	


	function alarmAdd_field()
	{
			
			$sql="SELECT DISTINCT field from scada_latest_igate_data order by field ASC";			
			$query = $this->db->query($sql);			
			//echo $this->db->last_query();exit;
			foreach ($query->result() as $rows) 					 				
						$row[] = $rows;																								
			
				return $row;

	}	
	
	
	function alarmHistory($id,$st)
	{					
			$sql="update alarm_fields set history_enable='".$st."' where id=".$id;			
			$query = $this->db->query($sql);										
				return 'sucess';

	}
	
	function alarmStatus($id,$st)
	{						
			$sql="update alarm_fields set status='".$st."' where id=".$id;								
			$query = $this->db->query($sql);												
				return 'sucess';

	}
	
	function alarmInsert($data)
	{
		//print_r($data); 		
		$this->db->insert('alarm_fields', $data);
	}
	
	public function checkFieldExist($field)
	{
		$this->db->where("alarm_field",$field);
		$query=$this->db->get("alarm_fields");
		if($query->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function alarmUpdate($id,$data)
	{
		//extract($data);
		$this->db->where('id', $id);
		$this->db->update('alarm_fields', $data);
		
		//return true;
	}
	
}
?>
