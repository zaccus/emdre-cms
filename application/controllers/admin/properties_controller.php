<?php
class Properties_Controller extends Admin_Controller {
    
    // constructor
	function __construct() {
		parent::__construct();
	
        // load property model
        $this->load->model('property_model');
	}
    
    // admin/properties controller
	public function index($ext = null) {
        if ($ext == null) {
            $data = array(
                'title' => 'Properties',
                'js_file' => 'listings_add'
            );
            $this->load->view('header_view', $data);
            $this->load->view('admin/admin_panel');
            $this->load->view('admin/properties_view');
            $this->load->view('footer_view');
        } else {
            redirect(base_url().'/admin');
        }
	}
    
    // returns a json string of properties
	public function fetch_properties() {
		if ($this->input->is_ajax_request()) {
			echo json_encode($this->property_model->fetch_properties());
		} else {
			redirect(base_url().'admin/');
		}
	}
    
    // ajax post endpoint for creating a property record
	public function create_property() {
		if ($this->input->is_ajax_request()) {
			$data = array(
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'beds' => $this->input->post('beds'),
				'baths' => $this->input->post('baths'),
				'sqft' => $this->input->post('sqft'),
				'acres' => $this->input->post('acres'),
				'created' => null,
				'modified' => null
			);
			
			if ($this->property_model->insert_property($data)) {
				$this->data['message'] = 'Property successfully created.';
			} else {
				$this->output->set_status_header('400');
				$this->data['message'] = 'Error creating property.';
			}
			echo json_encode($this->data);
		} else {
			show_error('No direct access allowed');
		}
	}

    // ajax post endpoint for deleting a property record
	public function delete_property() {
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('property_id');
			
			if ($this->property_model->delete_property($id)) {
				$this->data['message'] = 'Property successfully deleted.';
			} else {
				$this->output->set_status_header('400');
				$this->data['message'] = 'Error deleting property.';
			}
			echo json_encode($this->data);
		} else {
			show_error('No direct access allowed');
		}
	}
}
/* end of file properties_controller.php */
/* location: ./application/controllers/properties_controller.php */