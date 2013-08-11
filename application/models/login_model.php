<?php
class Login_Model extends CI_Model {
	function __construct() {
		parent::__construct();
		
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}	
	
	public function validate() {
		$result = false;
	
		$username = $this->security->xss_clean($this->input->post('username'));
		$password = $this->security->xss_clean($this->input->post('password'));
		
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));
		
		$query = $this->db->get('user');
		if ($query->num_rows == 1) {
			$row = $query->row();
			$data = array(
						'userId' => $row->userId,
						'fName' => $row->fName,
						'lName' => $row->lName,
						'username' => $row->username,
						'validated' => true	
					);
			$this->session->set_userdata($data);
			$result = true;
		}
		
		return $result;
	}
}
?>
