<?php

/* 
 * @copyright Marcos Zuriaga Miguel <wolfi at wolfi.es> 2016 All rights reserved
 */

class RunningInstance_Item extends \AQ\CIObject {
    public 
        $id,
        $start_time,
        $ip,
        $docker_hash,
        $docker_public_port,
        $docker_json;
    
    protected function _post_init_process() {
        $this->id = intval($this->id);
        $this->start_time = intval($this->start_time);
        $this->docker_public_port = intval($this->docker_public_port);
    }
}