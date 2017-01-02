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
