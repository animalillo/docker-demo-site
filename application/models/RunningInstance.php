<?php

/**
 * Database of the docker demo site
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
