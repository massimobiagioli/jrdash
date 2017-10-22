<?php

class Home extends CI_Controller {
    
    public function index() {
        $this->load->view('inc/header_view');
        $this->load->view('inc/footer_view');
    }
    
}

