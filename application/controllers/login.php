<?php
class Login extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['title'] = 'Please Log In';
		$this->load->view('header_view', $data);
		$this->load->view('admin/login_view');
		$this->load->view('footer_view');
	}
	
	public function process() {
		$this->load->model('login_model');
		$result = $this->login_model->validate();
		
		if (! $result) {
			redirect(base_url().'login/');
		} else {
			redirect(base_url().'admin/');
		}
	}
    
    // end the session and redirect to /admin/
	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url().'login/');
	}
}
/* end of file login.php */
/* location: ./application/controllers.php */