<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GameSession extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('gamesessionModel', '', true);
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
            //JMR
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        return $arr;
	}
	function joinroom(){
		$decoded = $this->_authToken($this->input->get("token"));
        $roomId =$this->input->post_json("roomId");
        if($decoded)
        {
			$userId = $this->userModel->getIDByEmail($decoded->email);
			if($this->gamesessionModel->joinRoom($userId,$roomId)){
				$arr["json"]=array("joined"=>true);
				$arr['response_code'] = 201;
			}else{
				$arr["json"]=array("joined"=>false);
				$arr['response_code'] = 202;
			}
		} else
        {
            //JMR
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        $this->parser->parse("json", $arr);
	}
	function leaveroom(){
		$decoded = $this->_authToken($this->input->get("token"));
        $roomId =$this->input->post_json("roomId");
        if($decoded)
        {
			$userId = $this->userModel->getIDByEmail($decoded->email);
			if($this->gamesessionModel->leaveRoom($userId,$roomId)){
				$arr["json"]=array("left"=>true);
				$arr['response_code'] = 201;
			}else{
				$arr["json"]=array("left"=>false);
				$arr['response_code'] = 202;
			}
		} else
        {
            //JMR
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        $this->parser->parse("json", $arr);
	}
	function refreshsession(){
		$decoded = $this->_authToken($this->input->get("token"));
        $roomId =$this->input->post_json("roomId");
        if($decoded)
        {
			$userId = $this->userModel->getIDByEmail($decoded->email);
			if($this->gamesessionModel->gameSessionActive($userId,$roomId)){
				$arr["json"]=array("refreshed"=>true);
				$arr['response_code'] = 201;
			}else{
				$arr["json"]=array("refreshed"=>false);
				$arr['response_code'] = 202;
			}
		} else
        {
            //JMR
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        $this->parser->parse("json", $arr);
	}
	function isuseractive(){
		$decoded = $this->_authToken($this->input->get("token"));
        $userIds =$this->input->post_json("userId");
		$roomId =$this->input->post_json("roomId");
		if($decoded)
        {
			foreach($userIds as $id)
			{
				 $arr["json"][$id] = $this->gamesessionModel->checkUserActive($id,$roomId);
			}
			$arr['response_code'] = 200;
		} else
        {
            //JMR
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        $this->parser->parse("json", $arr);
	}
}

 