<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * this CI model control CRUD of gamesession table
 *
 * @author seeyouu
 */
class gamesessionModel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    
    function listActiveUsersInRoom()
    {
		$query = $this->db->get_where("gamesession",array("isuseractive" => 1));
		if($query->num_rows() > 0)
		{
			$row=$query->result_array();
			return $row;
		}	
        return false;

    }
	function joinRoom($userId, $roomId)
    {
		$this->db->where('roomId', $roomId);
		$this->db->where('userid', $userId);
		$this->db->delete('gamesession'); 
		$data = array(
		   'userid' => $userId ,
		   'roomid' => $roomId ,
		   'isuseractive' => 1
		);

		if($this->db->insert('gamesession', $data))
			return true;
		else	
			return false;

    }
	function leaveRoom($userId, $roomId)
    {
		$this->db->where('roomId', $roomId);
		$this->db->where('userid', $userId);

		if($this->db->delete('gamesession'))
			return true;
		else	
			return false;

    }
	function gameSessionActive($userId, $roomId)
    {
		$this->db->where('roomId', $roomId);
		$this->db->where('userid', $userId);
		$upd = array(
			'userlastactive'=>date('Y-m-d H:i:s',time()),
		   'isuseractive' => 1
		);
		if($this->db->update('gamesession',$upd))
			return true;
		else	
			return false;

    }
	function checkUserActive($userId,$roomId){
		$this->db->where('roomId', $roomId);
		$this->db->where('userid', $userId);
		$this->db->where('isuseractive',1);
		$query = $this->db->get('gamesession');
		if($query->num_rows() > 0)
			return true;
		else	
			return false;
	}
}
