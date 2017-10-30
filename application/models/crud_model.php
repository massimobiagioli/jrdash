<?php

class CRUD_model extends CI_Model {
    
    protected $_table = null;
    protected $_primary_key = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get records
     * @param int $id Model ID
     * @return array Resultss
     * @usage
     *      All    : $this->user_model->get()
     *      Single : $this->user_model->get(2)
     *      Custom : $this->user_model->get(array('k1' => 'v1', 'k2' => 'v2'))
     */
    public function get($id = null, $order_by = null) {
        if (is_numeric($id)) {
            $this->db->where($this->_primary_key, $id);    
        } elseif (is_array($id)) {
            foreach ($id as $k => $v) {
                $this->db->where($k, $v);    
            }
        }
        
        // TODO: Order by
        
        $q = $this->db->get($this->_table);
        
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
