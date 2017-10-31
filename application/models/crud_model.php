<?php

class CRUD_model extends CI_Model {
    
    protected $_table = null;
    protected $_primary_key = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get records
     * @param mixed $id Model ID
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
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Update Record
     * @param array $new_data New data
     * #param mixed $id User ID to update         
     * @return int Affected Rows
     * @usage
     *      $result = $this->user_model->insert([
     *          'login' => 'Beppe'
     *      ], 1);
     */
    public function update($new_data, $id) {
        if (is_numeric($id)) {
            $this->db->where($this->_primary_key, $id);    
        } elseif (is_array($id)) {
            foreach ($id as $k => $v) {
                $this->db->where($k, $v);    
            }
        } else {
            die('You must pass a second parameter to update method');
            // TODO: Al posto di die(), prevedere delle preconditions
        }
        $this->db->update($this->_table, $new_data);
        return $this->db->affected_rows();
    }
    
    /**
     * Insert Or Update Record
     * @param array $data Data to insert/update
     * #param mixed $id Primary Key Value   
     * @return int Affected Rows
     * @usage
     *      $result = $this->user_model->insertUpdate([
     *          'login' => 'Beppe'
     *      ], 1);
     */
    public function insertUpdate($data, $id) {
        if (!$id) {
            die('You must pass a second parameter to update insertUpdate');
            // TODO: Gestione precondizioni
        }
        
        $this->db->select($this->_primary_key);
        $this->db->where($this->_primary_key, $id);
        $q = $this->db->get($this->_table);
        $result = $q->num_rows();
        
        if ($result === 0) {
            // Insert
            return $this->insert($data);
        } else {
            // Update
            return $this->update($data, $id);
        }
    }
    
    /**
     * Delete Record
     * @param mixed $id User ID to delete
     * @return int Affected Rows
     * @usage
     *      $result = $this->user_model->delete(1);
     *      $result = $this->user_model->delete(['name' => 'Markus']);
     */
    public function delete($id) {
        if (is_numeric($id)) {
            $this->db->where($this->_primary_key, $id);
        } else if (is_array($id)) {
            foreach ($id as $k => $v) {
                $this->db->where($k, $v);    
            }
        } else {
            die('You must pass a parameter to delete method');
            // TODO: Al posto di die(), prevedere delle preconditions
        }
        $this->db->delete($this->_table);
        return $this->db->affected_rows();
    }
    
}
