<?php

class Home extends CI_Controller {
    
    public function index() {
        $this->load->view('home/inc/header_view');
        $this->load->view('home/home_view');
        $this->load->view('home/inc/footer_view');
    }
    
}

