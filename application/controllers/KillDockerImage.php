<?php

/* 
 * @copyright Marcos Zuriaga Miguel <wolfi at wolfi.es> 2016 All rights reserved
 */

/**
 * Description of KillDockerImage
 *
 * @author Marcos Zuriaga Miguel
 */
class KillDockerImage extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_cli()) {
            show_404();
        }
        
        $this->load->model('RunningInstance');
    }
    
    public function _remap($docker_hash) {
        $instance = $this->RunningInstance->getByDockerHash($docker_hash);

        if ($instance) {
            exec("docker kill $instance->docker_hash");
            exec("docker rm $instance->docker_hash");
            exec("iptables -D INPUT -p tcp --dport $instance->docker_public_port -j ACCEPT");

            $this->RunningInstance->delete($instance);
        }
        else {
            echo "The instance you provides is not found in the database\n";
        }
    }
}
