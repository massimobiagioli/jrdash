<?php

class Api extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('todo_model');
        $this->load->model('note_model');
    }
    
    private function _require_login() {
        if (!$this->session->userdata('user_id')) {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => 'You are not authorized'
            ]));
            return false;
        }
        return true;
    }

    public function login() {
        $login = $this->input->post('login');
        $password = $this->input->post('password');

        $result = $this->user_model->get([
            'login' => $login,
            'password' => hash('sha256', $password . SALT)
        ]);

        $this->output->set_content_type('application/json');

        if ($result) {
            $this->session->set_userdata(['user_id' => $result[0]['user_id']]);
            $this->output->set_output(json_encode(['result' => 1]));
        } else {
            $this->output->set_output(json_encode(['result' => 0]));
        }
    }

    public function register() {
        $this->output->set_content_type('application/json');

        $this->form_validation->set_rules('login', 'Login', 'required|min_length[4]|max_length[16]|is_unique[user.login]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[16]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]');

        if ($this->form_validation->run() === false) {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => $this->form_validation->error_array()
            ]));
            return false;
        }

        $login = $this->input->post('login');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user_id = $this->user_model->insert([
            'login' => $login,
            'password' => hash('sha256', $password . SALT),
            'email' => $email
        ]);

        if ($user_id) {
            $this->session->set_userdata(['user_id' => $user_id]);
            $this->output->set_output(json_encode(['result' => 1]));
        } else {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => 'User not created'
            ]));
        }
    }

    public function get_todo($id = null) {
        if (!$this->_require_login()) {
            return;
        }
        
        if ($id !== null) {
            $where = [
                'todo_id' => $id,
                'user_id' => $this->session->userdata('user_id')
            ];
        } else {
            $where = [
                'user_id' => $this->session->userdata('user_id')
            ];
        }
        $result = $this->todo_model->get($where);
        
        $this->output->set_output(json_encode($result));
    }

    public function create_todo() {
        if (!$this->_require_login()) {
            return;
        }

        $this->form_validation->set_rules('content', 'Content', 'required|max_length[255]');
        if ($this->form_validation->run() === false) {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => $this->form_validation->error_array()
            ]));
            return;
        }

        $result = $this->todo_model->insert([
            'content' => $this->input->post('content'),
            'user_id' => $this->session->userdata('user_id')
        ]);

        if ($result) {
            $data= $this->todo_model->get($this->db->insert_id());
            $this->output->set_output(json_encode([
                'result' => 1,
                'data' => $data
            ]));
        } else {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => 'Could not insert record'
            ]));
        }
    }

    public function update_todo() {
        if (!$this->_require_login()) {
            return;
        }
        
        $todo_id = $this->input->post('todo_id');
        $completed = $this->input->post('completed');
        
        $result = $this->todo_model->update([
           'completed' => $completed 
        ], [
            'todo_id' => $todo_id,
            'user_id' => $this->session->userdata('user_id')
        ]);
        if ($result) {
            $this->output->set_output(json_encode([
                'result' => 1
            ]));
        } else {
            $this->output->set_output(json_encode([
                'result' => 0,
                'message' => 'Could not update.'
            ]));
        }
    }

    public function delete_todo() {
        if (!$this->_require_login()) {
            return;
        }
        
        $result = $this->todo_model->delete([
            'todo_id' => $this->input->post('todo_id'),
            'user_id' => $this->session->userdata('user_id')
        ]);
        if ($result) {
            $this->output->set_output(json_encode([
                'result' => 1
            ]));
        } else {
            $this->output->set_output(json_encode([
                'result' => 0,
                'message' => 'Could not delete.'
            ]));
        }
    }

    public function get_note($id = null) {
        if (!$this->_require_login()) {
            return;
        }
        
        if ($id !== null) {
            $where = [
                'note_id' => $id,
                'user_id' => $this->session->userdata('user_id')
            ];
        } else {
            $where = [
                'user_id' => $this->session->userdata('user_id')
            ];
        }
        $result = $this->note_model->get($where);
        
        $this->output->set_output(json_encode($result));
    }

    public function create_note() {
        if (!$this->_require_login()) {
            return;
        }
        
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[100]');
        $this->form_validation->set_rules('content', 'Content', 'required|max_length[255]');
        if ($this->form_validation->run() === false) {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => $this->form_validation->error_array()
            ]));
            return;
        }

        $result = $this->note_model->insert([
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'user_id' => $this->session->userdata('user_id')
        ]);

        if ($result) {
            $data= $this->note_model->get($this->db->insert_id());
            $this->output->set_output(json_encode([
                'result' => 1,
                'data' => $data
            ]));
        } else {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => 'Could not insert record'
            ]));
        }
    }

    public function update_note() {
        $note_id = $this->input->post('note_id');
    }

    public function delete_note() {
        $note_id = $this->input->post('note_id');
    }

}
