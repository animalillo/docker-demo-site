<?php

/* 
 * @copyright Marcos Zuriaga Miguel <wolfi at wolfi.es> 2016 All rights reserved
 */

/**
 * Description of JobQueue
 *
 * @author wolfi
 */
class JobQueue extends CI_Model {
    CONST TABLE = "JobQueue";
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('db/jobqueue');
    }
    
    public function getPendingRuns() {
        $result = $this->db->select()->from(self::TABLE)->get();
        
        if ($result->num_rows() > 0) {
            return JobQueue_Item::fromSTDArray($result->result_object());
        }
        
        return false;
    }
    
    public function add(JobQueue_Item $job) {
        $job->id = null;
        $this->db->insert(self::TABLE, $job);
    }
    
    public function delete(JobQueue_Item $item){
        $this->db->delete(self::TABLE, ['id' => $item->id]);
    }
}
