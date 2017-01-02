<?php
/**
 * Daemon of the docker demo site.
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
 * Description of Daemon
 *
 * @author Marcos Zuriaga Miguel
 */
class Daemon extends CI_Controller {
    CONST DOCKER_IMAGE_LIFE = 3600; // Seconds
    
    public function __construct() {
        parent::__construct();
        if (!is_cli()) {
            show_404();
        }
        
        $this->load->library('migration');

        $this->load->model('JobQueue');
        $this->load->model('RunningInstance');
    }
    
    public function index() {
        echo "Starting up the daemon loop \n";
        while (true) {
            $this->db->reconnect();
            
            $pending = $this->JobQueue->getPendingRuns();
            
            if ($pending) {
                foreach ($pending as $job) {
                    $this->run($job);
                }
            }
            
            $this->cron();
            sleep(5);
        }
    }
    
    protected function run(JobQueue_Item $job) {
        $command = 'php ' . SELF . " $job->action $job->parameters";
        
        echo "running: $command" . PHP_EOL;
        
        exec('php ' . SELF . " $job->action $job->parameters", $result);
        foreach ($result as $line) echo $line . PHP_EOL;
        
        $this->JobQueue->delete($job);
    }
    
    protected function cron() {
        $items = $this->RunningInstance->getInstanceOlderThan(self::DOCKER_IMAGE_LIFE);
        
        if ($items) {
            echo "Marking running images for deletion on next loop" . PHP_EOL;
            foreach ($items as $item) {
                $job = new JobQueue_Item();
                $job->action = 'KillDockerImage';
                $job->parameters = $item->docker_hash;
                $job->date = (new DateTime())->getTimestamp();
                $this->JobQueue->add($job);
            }
        }
    }
}
