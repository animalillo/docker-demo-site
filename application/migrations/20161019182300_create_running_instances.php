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

/* 
 * @copyright Marcos Zuriaga Miguel <wolfi at wolfi.es> 2016 All rights reserved
 */

class Migration_Create_running_instances extends CI_Migration {
    public function up() {
        $fields = [
            'start_time' => [
                'type' => 'DOUBLE',
                'null' => FALSE
            ],
            'ip' => [
                'type' => 'varchar',
                'constraint' => 200,
                'null' => false
            ],
            'docker_hash' => [
                'type' => 'varchar',
                'constraint' => 200,
                'null' => TRUE
            ],
            'docker_public_port' => [
                'type' => 'int',
                'unsigned' => TRUE
            ],
            'docker_json' => [
                'type' => 'text',
                'null' => FALSE
            ]
        ];
        
        $this->dbforge->add_field('id');
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('RunningInstances');
    }
}
