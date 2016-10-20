<?php

/* 
 * @copyright Marcos Zuriaga Miguel <wolfi at wolfi.es> 2016 All rights reserved
 */

class JobQueue_Item extends \AQ\CIObject {
    public 
        $id,
        $action,
        $parameters,
        $date;
    
    public function _post_init_process() {
        $this->id = intval($this->id);
        $this->date = intval($this->date);
    }
}
