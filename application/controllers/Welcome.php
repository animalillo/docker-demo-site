<?php
/**
 * Main page of the docker demo site.
 * Copyright (C) 2016  Marcos Zuriaga Miguel <wolfi at wolfi.es>
 * Copyright (C) 2016  Sander Brand <brantje at gmail.com>
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

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('recaptcha');
        $this->load->model('JobQueue');
        $this->load->model('RunningInstance');
        $this->load->helper('url');
    }
    
    public function index()
    {
        $ip = $this->input->ip_address();
        $item = $this->RunningInstance->getByIP($ip);
        
        $data = [
            'running_demo' => false,
            'port' => 0
        ];

        $data['recaptcha_html'] = $this->recaptcha->get_html();
        if ($item) {
            $data['running_demo'] = true;
            $data['port'] = $item->docker_public_port;
            $data['time_left'] = 3600 - ((new DateTime())->getTimestamp() - $item->start_time);
        }
        
        $this->load->view('welcome_message', $data);
    }

    public function createContainer() {
        $ip = $this->input->ip_address();
        $item = $this->RunningInstance->getByIP($ip);
        
        if (!$item) {
            if ($this->recaptcha->catch_answer()) {
                $job = new JobQueue_Item();
                $job->action = 'RunDockerImage';
                $job->parameters = $this->input->ip_address();
                $job->date = (new DateTime())->getTimestamp();

                $this->JobQueue->add($job);
            }
            else {
                show_error("Bad recaptcha", 403);
            }
        }
        
        header('Refresh:0;url='.  site_url('Welcome/demoLoop'));
    }
    
    private function testConnection($address, $requiredStatusCode) {
        $ch = curl_init($address);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode == $requiredStatusCode;
    }
    
    public function demoLoop() {
        $ip = $this->input->ip_address();
        $item = $this->RunningInstance->getByIP($ip);
        
        echo "Please, wait while we create your demo";
        
        if ($item && $this->testConnection('https://demo.passman.cc:' . $item->docker_public_port, 200)) {
            redirect('https://demo.passman.cc:' . $item->docker_public_port);
        }
        else {
            header('Refresh:10;url='.  site_url('Welcome/demoLoop'));
            exit();
        }
    }
    
    public function instanceReady() {
        $ip = $this->input->ip_address();
        $item = $this->RunningInstance->getByIP($ip);
        
        if ($item && $this->testConnection('https://demo.passman.cc:' . $item->docker_public_port, 200)) {
            echo json_encode([
                'status' => 'ok', 
                'port' => $item->docker_public_port
            ]);
        }
        else {
            echo json_encode(['status' => 'off']);
        }
    }
}
