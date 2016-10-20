<?php

/* 
 * @copyright Marcos Zuriaga Miguel <wolfi at wolfi.es> 2016 All rights reserved
 */

/**
 * Description of RunDockerImage
 *
 * @author Marcos Zuriaga Miguel
 */
class RunDockerImage extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_cli()) {
            show_404();
        }
        
        $this->load->model('RunningInstance');
    }
    
    public function _remap($ip_address) {
        $instance = new RunningInstance_Item();
        $instance->ip = $ip_address;
        $instance->start_time = (new DateTime)->getTimestamp();

        $instance->docker_hash = exec("docker run -d -P passman");
        exec("docker inspect $instance->docker_hash", $docker_info);
        
        $instance->docker_json = "";
        foreach ($docker_info as $value) {
            $instance->docker_json .= $value;
        }
        
        $docker_info = json_decode($instance->docker_json);
        
        $eighty = "80/tcp";
        $instance->docker_public_port = $docker_info[0]->NetworkSettings->Ports->$eighty[0]->HostPort;
        
        echo "iptables -A INPUT -p tcp --dport $instance->docker_public_port -j ACCEPT";
        exec("iptables -A INPUT -p tcp --dport $instance->docker_public_port -j ACCEPT");
        $this->RunningInstance->createInstance($instance);
        // To delete: iptables -D INPUT -p tcp $instance->docker_public_port -j ACCEPT
    }
}
