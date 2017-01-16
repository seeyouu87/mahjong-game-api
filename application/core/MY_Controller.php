<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Candidates
 *
 * @author GimYuen
 */
class MY_Controller extends CI_Controller {
    
    protected $secret = "#489345)(&fjew982--pPKds34";
    public function __construct() {
		
        parent::__construct();
        //JMR
        //$_get_params = $this->uri->uri_to_assoc(3);
        
    }
    
    function _secret()
    {
        return "pre_salted".$this->secret."post_salted";
    }//end secret
    
    
    
    function _authToken($token)
    {
        try{
            $this->load->library("jwt");
            //retrieve secret password from database. unique for every user
            $decoded = $this->jwt->decode($token, $this->_secret());
            log_message("error","MY_Controller->_authToken: ".json_encode($decoded));
			if($decoded->exp<=time()){
				return false;
			}
            return $decoded;
        }
        catch(Exception $e)
        {
            log_message("error","MY_Controller->_authToken: ERROR: ". $e);
            return false;
        }
    }//end authtoken
    
	    
    /*
     * Checks whether the var is an integer. Used in many places to validate
     * input.
     * Dave 2014/12/19
     */
    function _checkint($var)
    {
        // checks that the var is an integer
        // returns TRUE if it is, FALSE if it isn't
        log_message("debug", "checkint: " . $var . ". ");
        if ($var)
        {
            log_message("debug", "checkint var exists. ");
            if ($var == 1)
            {
                log_message("debug", "checkint var is a 1 returning TRUE. ");
                return TRUE;
            }
            
            $var = intval($var);
            log_message("debug", "checkint intval: " . $var . ". ");

            // check if intval has returned greater than 2
            // 0 or 1 are likely to be arrays
            if ($var >= 2)
            {
                log_message("debug", "checkint returning TRUE. ");
                return TRUE;
            }
        }
        log_message("debug", "checkint returning FALSE. ");
        return FALSE;
    }//end checkint

    
    /**
     * Index
     *      Handle all the GET| POST| PUT| DELETE
     */
    function index()
    {
        log_message("error","MY_Controller->index: ". $this->input->server('REQUEST_METHOD'));
		//log_message("error",'MY_Controller->index->get(token): '. $_GET["token"]);
        switch(strtoupper($this->input->server('REQUEST_METHOD')))
        {
            case "GET":
                        //JMR -- get any optional params that were passed in.
                $arr = $this->_list();
                break;
            case "POST":
                $arr = $this->_create();
                break;
            case "PUT":
                $arr = $this->_update();
                break;
            case "DELETE":
                $arr = $this->_delete();
                break;
                
        }//end switch
        
        $this->parser->parse("json", $arr);
        
    }
    
    protected function _list()
    {
        //please overwrite
    }
    
    protected function _update()
    {
        //please overwrite
    }
    protected function _create()
    {
        //please overwrite
    }
    protected function _delete()
    {
        //please overwrite
    }
    
    /*
    function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
    }
    */
    
}