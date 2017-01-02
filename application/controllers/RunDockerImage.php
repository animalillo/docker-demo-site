<?php

/**
 * Docker container creator for the docker demo site.
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
        
        $command = $this->config->item('docker_command');
        
        $instance->docker_hash = exec($command);
        exec("docker inspect $instance->docker_hash", $docker_info);
        
        $instance->docker_json = "";
        foreach ($docker_info as $value) {
            $instance->docker_json .= $value;
        }
        
        $docker_info = json_decode($instance->docker_json);
        
        $sslPort = "443/tcp";
        $instance->docker_public_port = $docker_info[0]->NetworkSettings->Ports->{$sslPort}[0]->HostPort;
        
        echo "iptables -A INPUT -p tcp --dport $instance->docker_public_port -j ACCEPT";
        exec("iptables -A INPUT -p tcp --dport $instance->docker_public_port -j ACCEPT");
        $this->RunningInstance->createInstance($instance);
        // To delete: iptables -D INPUT -p tcp $instance->docker_public_port -j ACCEPT
    }
}
