<?php

/* 
 * @copyright Marcos Zuriaga Miguel <wolfi at wolfi.es> 2016 All rights reserved
 */

/**
 * Description of RunningInstance
 *
 * @author Marcos Zuriaga Miguel
 */
class RunningInstance extends CI_Model {
    CONST TABLE = "RunningInstances";
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('db/runninginstance');
    }
    
    public function createInstance(RunningInstance_Item $instance) {
        $instance->id = null;
        $this->db->insert(self::TABLE, $instance);
    }
    
    /**
     * 
     * @param type $hash
     * @return bool|RunningInstance_Item
     */
    public function getByDockerHash($hash) {
        $result = $this->db->select()->from(self::TABLE)->where('docker_hash', $hash)->get();
        
        if ($result->num_rows() > 0) {
            return RunningInstance_Item::fromObject($result->row(0));
        }
        
        return false;
    }
    
    /**
     * 
     * @param type $ip_address
     * @return boolean|RunningInstance_Item
     */
    public function getByIP($ip_address){
        $result = $this->db->select()->from(self::TABLE)->where('ip', $ip_address)->get();
        
        if ($result->num_rows() > 0) {
            return RunningInstance_Item::fromObject($result->row(0));
        }
        
        return false;
    }
    
    /**
     * 
     * @param type $time
     * @return RunningInstance_Item[]
     */
    public function getInstanceOlderThan($time) {
        $time = intval($time);
        $time = (new DateTime())->getTimestamp() - $time;
        
        $q = "SELECT * FROM " . self::TABLE . " WHERE start_time < $time";
        $result = $this->db->query($q);
        if ($result->num_rows() > 0) {
            return RunningInstance_Item::fromSTDArray($result->result());
        }
        
        return false;
    }
    
    public function delete(RunningInstance_Item $instance) {
        $this->db->delete(self::TABLE, ['id' => $instance->id]);
    }
}
