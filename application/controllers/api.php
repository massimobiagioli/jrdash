<?php

class Api extends CI_Controller {

    private function _require_login() {
        if (!$this->session->userdata('user_id')) {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => 'You are not authorized'
            ]));
            return false;
        }
    }

    public function login() {
        $login = $this->input->post('login');
        $password = $this->input->post('password');

        $this->load->model('user_model');

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

        $this->load->model('user_model');

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
        $this->_require_login();

        if ($id !== null) {
            $this->db->where([
                'todo_id' => $id,
                'user_id' => $this->session->userdata('user_id')
            ]);
        } else {
            $this->db->where('user_id', $this->session->userdata('user_id'));
        }

        $query = $this->db->get('todo');
        $result = $query->result_array();
        
        $this->output->set_output(json_encode($result));
    }

    public function create_todo() {
        $this->_require_login();

        $this->form_validation->set_rules('content', 'Content', 'required|max_length[255]');
        if ($this->form_validation->run() === false) {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => $this->form_validation->error_array()
            ]));
            return;
        }

        $result = $this->db->insert('todo', [
            'content' => $this->input->post('content'),
            'user_id' => $this->session->userdata('user_id')
        ]);

        if ($result) {
            $query = $this->db->get_where('todo', ['todo_id' => $this->db->insert_id()]);
            $this->output->set_output(json_encode([
                'result' => 1,
                'data' => $query->result_array()
            ]));
        } else {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => 'Could not insert record'
            ]));
        }
    }

    public function update_todo() {
        $this->_require_login();
        
        $todo_id = $this->input->post('todo_id');
        $completed = $this->input->post('completed');
        
        $this->db->where([
            'todo_id' => $todo_id,
            'user_id' => $this->session->userdata('user_id')
        ]);
        $result = $this->db->update('todo', [
           'completed' => $completed 
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
        $this->_require_login();
        
        $result = $this->db->delete('todo', [
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
        $this->_require_login();

        
    }

    public function create_note() {
        
    }

    public function update_note() {
        $note_id = $this->input->post('note_id');
    }

    public function delete_note() {
        $note_id = $this->input->post('note_id');
    }

}
