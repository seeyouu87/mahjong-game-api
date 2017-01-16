<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class gameroomModel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    
    function listGameRoom()
    {
		$this->db->from("gameroom");
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$row=$query->result_array();
			return $row;
		}	
        return false;

    }
	
}
