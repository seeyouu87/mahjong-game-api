<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * this CI model serve CRUD on user table
 * of course, control user's authentication
 *
 * @author seeyouu87
 */
class UserModel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    
    function auth($email, $password)
    {
        $this->db->select("email");
        $this->db->from("user");
        
        $this->db->where("password",$password);
        $this->db->where("email",$email);
        //$this->db->where("hashkey = UNHEX(SHA2(".$this->db->escape($email).",512))", NULL, FALSE);
        return $this->db->count_all_results() > 0;
    }
    
    
    function create($email, $password, $verificationcode)
    {
        //insert into whatever database you want here.
        if (!$email || !$password) {
            return false;
        }
        $data = array("email"=> $email, "password"=>$password);
        $this->db->set($data);
        $this->db->where("email",$email);
        
        $this->db->insert("user");
        
        return true;
    }

    function getIDByEmail($email)
    {
	$this->db->select("userid");
        $this->db->from("user");
	$this->db->where("email",$email);
 	$query = $this->db->get();
	if($query->num_rows() > 0)
	{
		$row=$query->row_array();
		return $row['userid'];
	}	
        return false;

    }
	
}
