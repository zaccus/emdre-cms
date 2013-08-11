<?php
class User_Model extends CI_Model {
	var $username;
	var $password;
	var $fName;
	var $lName;

	function __construct() {
		parent::__construct();
	}
	
	function add_user($data) {
		return $this->db->insert('user', $data);
	}
}
?>
