<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Curl\Curl;

class Recaptcha {
    protected $status;

    //Remember to obtain the Public and Private key @ https://www.google.com/recaptcha/admin/create
    protected $public_key = "";
    protected $privkey = "";
    protected $options = array();
    protected $ci;
            
    function __construct() {
            log_message('debug', "RECAPTCHA Class Initialized.");
            $this->ci = get_instance();
            
            //Load the CI Config file for recaptcha
            $this->ci->load->config('recaptcha');
            //load in the values from the config file. 
            $this->public_key   = $this->ci->config->item('public_key');
            $this->privkey  = $this->ci->config->item('private_key');
    }
    
    function get_html () {
        if ($this->public_key == null || $this->public_key == '') {
            throw new Exception("To use reCAPTCHA you must get an API key from <a href='https://www.google.com/recaptcha/admin/create'>https://www.google.com/recaptcha/admin/create</a>");
        }
        
        return 
            '<script src="https://www.google.com/recaptcha/api.js"></script>' . "
            <div class='g-recaptcha' data-sitekey='$this->public_key'></div>";
    }

    function catch_answer() {
        if (is_null($this->privkey) || $this->privkey == '') {
            throw new Exception("To use reCAPTCHA you must get an API key");
        }

        $remoteip = $this->ci->input->ip_address();
        $response = $this->ci->input->post('g-recaptcha-response');
        
        $curl = new Curl();
        $curl->setOpt(CURLOPT_ENCODING, 'gzip');
        $curl->setHeader('User-Agent', 'passman demo site');
        $curl->get('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $this->privkey,
            'response' => $response,
            'remoteip' => $remoteip
        ]);
        
       if ($curl->error) {
           throw new Exception("Error $curl->errorMessage", $curl->errorCode);
       }
       
       $this->status = $curl->response->success;
       
       return $curl->response->success;
    }
    
    public function getStatus() {
        return $this->status;
    }
}