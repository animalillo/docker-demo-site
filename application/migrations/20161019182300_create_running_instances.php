<?php

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
