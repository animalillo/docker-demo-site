<?php

/**
 * Docker killer of the docker demo site.
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
            exec("docker rm -v $instance->docker_hash");
            exec("iptables -D INPUT -p tcp --dport $instance->docker_public_port -j ACCEPT");

            $this->RunningInstance->delete($instance);
        }
        else {
            echo "The instance you provides is not found in the database\n";
        }
    }
}
