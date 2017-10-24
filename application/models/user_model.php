<?php

class User_model extends CI_Model {
    
    /**
     * Get records
     * @param int $user_id User ID
     * @return array Results
     * @usage
     *      Single : $this->user_model->get(2)
     *      All    : $this->user_model->get()
     */
    public function get($user_id = null) {
        if ($user_id === null) {
            $q = $this->db->get('user');
        } elseif (is_array($user_id)) {
            $q = $this->db->get_where('user', $user_id);    
        } else {
            $q = $this->db->get_where('user', ['user_id' => $user_id]);
        }
        return $q->result_array();
    }
    
    /**
     * Insert Record
     * @param array $data Data to insert
     * @return int ID Inserted Record
     * @usage
     *      $result = $this->user_model->insert([
     *          'login' => 'Mario'
     *      ]);
     */
    public function insert($data) {
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Update Record
     * @param array $data Data to update
     * #param int $user_id User ID to update         
     * @return int Affected Rows
     * @usage
     *      $result = $this->user_model->insert([
     *          'login' => 'Beppe'
     *      ], 1);
     */
    public function update($data, $user_id) {
        $this->db->where(['user_id' => $user_id]);
        $this->db->update('user', $data);
        return $this->db->affected_rows();
    }
    
    /**
     * Delete Record
     * @param int $user_id User ID to delete
     * @return int Affected Rows
     * @usage
     *      $result = $this->user_model->delete(1);
     */
    public function delete($user_id) {
        $this->db->delete('user', ['user_id' => $user_id]);
        return $this->db->affected_rows();
    }
    
}
