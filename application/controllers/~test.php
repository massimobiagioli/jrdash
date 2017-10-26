<?php

class Test extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }
    
    public function test_get() {
        $data = $this->user_model->get(1);
        print_r($data);
        
        // Enable profiler
        $this->output->enable_profiler();
    }
    
    public function test_insert() {
        $result = $this->user_model->insert([
            'login' => 'Mario'
        ]);
        print_r($result);
    }
    
    public function test_update() {
        $result = $this->user_model->insert([
            'login' => 'Beppe'
        ], 1);
        print_r($result);
    }
    
    public function test_delete() {
        $result = $this->user_model->delete(1);
        print_r($result);
    }
    
}
