<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Recaptcha library
 * Copyright (C) 2016  Marcos Zuriaga Miguel <wolfi at wolfi.es>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

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