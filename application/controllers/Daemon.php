<?php

/* 
 * @copyright Marcos Zuriaga Miguel <wolfi at wolfi.es> 2016 All rights reserved
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
