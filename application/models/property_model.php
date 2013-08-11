<?php
class Property_Model extends CI_Model {
    
    // constructor
	function __construct() {
		parent::__construct();
	}
	
    // insert a property
	function insert_property($data) {
		return $this->db->insert('property', $data);
	}
	
    // returns query for all properties data
	function fetch_properties() {
		$query = $this->db->get('property');
		return $query->result_array();
	}
	
    // delete a property record
	function delete_property($id) {
		$this->db->where('id', $id);
		return $this->db->delete('property');
	}
}
?>
