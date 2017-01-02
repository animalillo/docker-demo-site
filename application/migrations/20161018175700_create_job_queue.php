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
 * Description of 201610181757CreateJobQueue
 *
 * @author wolfi
 */
class Migration_Create_job_queue extends CI_Migration {
    public function up(){
        $fields = [
            'action' => [
                'type' => 'varchar',
                'constraint' => 200,
                'null' => false
            ],
            'parameters' => [
                'type' => 'varchar',
                'constraint' => 200,
                'null' => TRUE
            ],
            'date' => [
                'type' => 'DOUBLE',
                'null' => FALSE
            ]
        ];
        
        $this->dbforge->add_field('id');
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('JobQueue');
    }
}
