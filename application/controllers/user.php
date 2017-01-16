<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserModel', '', true);
    }
    
    //********************* Authentication Internal Fn **************** //

    function _hashsaltpass($password)
    {
        $salted_hash = hash("sha512", "salted__#edsdfdwrsdse". $password."salted__#ewr^&^$&e");
        return $salted_hash;
    }
    
   
     //********************* End Authentication Internal Fn **************** //
    
    function auth()
    {
        $this->load->library("jwt");
        
        $email = $this->input->post_json("email");
        $password = $this->input->post_json("password");
        
        
        //check user login
        $salted_hash = $this->_hashsaltpass($password);
        //$salted_hash = $password;
        log_message('debug', "email: ".$email." and password:".$salted_hash);
        //JMR added id to the token contents
        if($this->UserModel->auth($email, $salted_hash))
        {
            //create an unique secret password for every user
            $token=array(
              "email" => $email,
              "exp" => (time()+(12*60*60)), // 12 hour 
            );
            $jwt = $this->jwt->encode($token, $this->_secret());

            $arr["response_code"] = "200";
            $arr["json"] = array("token"=>$jwt);
        }
        else {
		log_message("error", "User->auth failed");
            $arr["response_code"] = "401";
        }
        
        

        $this->parser->parse("json", $arr);

    }//end auth
}

 