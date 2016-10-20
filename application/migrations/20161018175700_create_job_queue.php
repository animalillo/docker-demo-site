<?php

/* 
 * @copyright Marcos Zuriaga Miguel <wolfi at wolfi.es> 2016 All rights reserved
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
