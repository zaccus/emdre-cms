<?php
class MY_Controller extends CI_Controller {
    function __construct() {
		parent::__construct();
	}
}

class Admin_Controller extends MY_Controller {
    // constructor
	function __construct() {
		parent::__construct();
        
        // validate user before going any further
		$this->validation_redirect();
	}
	
    // redirect user to login page if they are not logged in
	private function validation_redirect() {
		
		if (! $this->session->userdata('validated')) {
			redirect(base_url().'login');
		}
	}
    
    // end the session and redirect to /admin/
	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url().'/login');
	}
}
/* end file MY_Controller.php */
/* location: ./application/core/MY_Controller.php */