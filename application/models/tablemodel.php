<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This is a CI model to control mahjongtable in database
 * mahjong table recorded all user's action while playing
 * From joining/leaving table to every turn they take or throw a game token
 *
 * @author seeyouu87
 */
class tableModel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
	
    function listTable(){
		$this->db->distinct('tableid');
		$query = $this->db->get("mahjongtable");
		if($query->num_rows() >0)
		{
			$row=$query->result_array();
			return $row;
		}	
        return false;
	}
	
    function listplayers($tableId,$roomId)
    {
		$this->db->from("mahjongtable");
		$this->db->where("tableid",$tableId);
		$this->db->where("roomid",$roomId);
		$query = $this->db->get();
		if($query->num_rows() >0)
		{
			$row=$query->result_array();
			return $row;
		}	
        return false;
    }
	
	function createtable($userId,$roomId)
    {
		$this->db->select_max('tableid');
		$query = $this->db->get('mahjongtable');
		if($query->num_rows() >0)
		{
			$tableId = $query->row_array()["tableid"] +1;
		}else{
			$tableId = 1;
		}
		$data = array(
			'userid'=>$userId,
			'roomid'=>$roomId,
			'tableid'=>$tableId,
			'userstatus'=>'waiting'
		);
		$this->db->insert('mahjongtable',$data);
        $query = $this->db->get_where('mahjongtable',array('tableid'=>$tableId));
		if($query->num_rows() >0){
			return $query->result_array();
		}else{
			return false;
		}
    }
	
	function jointable($tableId,$roomId,$userId)
    {
		$this->db->from("mahjongtable");
		$this->db->where("tableid",$tableId);
		$this->db->where("roomid",$roomId);
		$query = $this->db->get();
		if($query->num_rows() >=4)
		{
			return false;
		}else{

			$q = $this->db->get_where("mahjongtable",
									array("tableid"=>$tableId,
									"roomid"=>$roomId,
									"userid"=>$userId));

			//to prevent double entry from a same user
			if($q->num_rows() >0)
			{
				return true;
			}else{
				$data =array("roomid"=>$roomId,
						"tableid"=>$tableId,
						"userid"=>$userId);
				if($this->db->insert('mahjongtable',$data)){
					return true;
				}else{
					return false;
				}
			}
			
		}	
        return false;
    }
	
	function leavetable($tableId,$roomId,$userId)
    {
		$this->db->where("tableid",$tableId);
		$this->db->where("roomid",$roomId);
		$this->db->where("userid",$userId);
		$query = $this->db->delete("mahjongtable");	
        
    }
	
	function updateAction($tableId,$roomId,$userId, $userAction,$gameToken)
	{
		$this->db->where("tableid",$tableId);
		$this->db->where("roomid",$roomId);
		$this->db->where("userid",$userId);
		if(empty($gameToken)){
			$data = array("useraction"=>$userAction,
							"actiontime"=>date('Y-m-d H:i:s',time()));
		}else{
			$data = array("useraction"=>$userAction,
							"gametoken"=>$gameToken,
							"actiontime"=>date('Y-m-d H:i:s',time()));
		}
		return $this->db->update("mahjongtable",$data);
	}
}
