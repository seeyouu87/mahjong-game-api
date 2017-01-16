<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('gameroomModel', '', true);
    }
    
    function _list(){
		$decoded = $this->_authToken($this->input->get("token"));
        
        if($decoded)
        {
			$arr['json'] =$this->gameroomModel->listGameRoom();
			$arr['response_code']=200;
		} else
        {
            //JMR
            log_message("error",'Decoded NOT available');
            
            $arr['response_code'] = 401;
        }
        return $arr;
	}
}

 