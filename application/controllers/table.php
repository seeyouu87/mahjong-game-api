<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Table extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('gamesessionModel', '', true);
		$this->load->model('tableModel', '', true);
		$this->load->model('userModel', '', true);
    }
    
    function _list(){
		$decoded = $this->_authToken($this->input->get("token"));
        
        if($decoded)
        {
			$arr['json'] =$this->gamesessionModel->listActiveUsersInRoom();
			$arr['response_code']=200;
		} else
        {
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        return $arr;
	}
	
	function createtable(){
		$decoded = $this->_authToken($this->input->get("token"));
        $roomId =$this->input->post_json("roomId");
        if($decoded)
        {
			$userId = $this->userModel->getIDByEmail($decoded->email);
			$table = $this->tableModel->createtable($userId,$roomId);
			if($table)
			{
				$arr["json"] = $table;
				$arr['response_code'] = 201;
			}else{
				$arr["json"]=array("joined"=>false);
				$arr['response_code'] = 202;
			}
		} else
        {
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        $this->parser->parse("json", $arr);
	}
	
	function jointable()
    {
		$decoded = $this->_authToken($this->input->get("token"));
        $roomId =$this->input->post_json("roomId");
		$tableId =$this->input->post_json("tableId");
        if($decoded)
        {
			$userId = $this->userModel->getIDByEmail($decoded->email);
			$joined = $this->tableModel->jointable($tableId,$roomId,$userId);
			if($joined)
			{
				$arr["json"] = array("joined"=>true);
				$arr['response_code'] = 201;
			}else{
				$arr["json"]=array("joined"=>false);
				$arr['response_code'] = 202;
			}
		} else
        {
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        $this->parser->parse("json", $arr);
    }
	function leavetable()
    {
		$decoded = $this->_authToken($this->input->get("token"));
        $roomId =$this->input->post_json("roomId");
		$tableId =$this->input->post_json("tableId");
        if($decoded)
        {
			$userId = $this->userModel->getIDByEmail($decoded->email);
			$this->tableModel->leavetable($tableId,$roomId,$userId);
			$arr["json"] = array("left"=>true);
			$arr['response_code'] = 200;
		} else
        {
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        $this->parser->parse("json", $arr);
    }
	
	function useraction()
    {
		$decoded = $this->_authToken($this->input->get("token"));
        $roomId =$this->input->post_json("roomId");
		$tableId =$this->input->post_json("tableId");
		$userAction =$this->input->post_json("userAction");
		$gameToken =$this->input->post_json("gameToken");
		
        if($decoded)
        {
			$userId = $this->userModel->getIDByEmail($decoded->email);
			$updated = $this->tableModel->updateAction($tableId,$roomId,$userId, $userAction,$gameToken);
			$arr["json"] = array("updated"=>$updated);
			$arr['response_code'] = 200;
		} else
        {
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        $this->parser->parse("json", $arr);
    }
}

 