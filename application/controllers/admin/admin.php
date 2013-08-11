<?php

/*
    This controller hides the backend behind /admin
    Other options for using base classes in application/core given here:
    
    http://philsturgeon.co.uk/blog/2010/02/CodeIgniter-Base-Classes-Keeping-it-DRY
    http://www.highermedia.com/articles/nuts_bolts/codeigniter_base_classes_revisited
    
    I'm doing it this way because I want a particular url structure
    update: having second thoughts, commence refactoring for better OO structure
*/

class Admin extends CI_Controller {
    
    // constructor
	function __construct() {
		parent::__construct();
		
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	
        // validate user before going any further
		$this->validation_redirect();
		$this->load->model('user_model');
        $this->load->model('property_model');
        $this->load->model('for_sale_listing_model');
        $this->load->model('for_rent_listing_model');
	}
	
    // redirect user to login page if they are not logged in
	private function validation_redirect() {
		
		if (! $this->session->userdata('validated')) {
			redirect(base_url().'login');
		}
	}
    
    // main admin view
	public function index() {
		$data['title'] = 'Welcome to Admin';
		$this->load->view('header_view', $data);
		$this->load->view('admin/admin_main');
		$this->load->view('footer_view');
	}
	
    // end the session and redirect to /admin/
	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url().'/login');
	}
	
    // admin/properties controller
	public function properties($ext = null) {
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
    
    // admin/for-sale-listings controller
    public function for_sale_listings($ext = null) {
        if ($ext == null) {
            $data = array(
                'title' => 'For Sale Listings',
                'js_file' => 'listings_for_sale'
            );
            $this->load->view('header_view', $data);
            $this->load->view('admin/admin_panel');
            $this->load->view('admin/for_sale_listings_view');
            $this->load->view('footer_view');
        } else {
            redirect(base_url().'/admin');
        }
    }
     
    // admin/for-rent-listings controller
    public function for_rent_listings($ext = null) {
        if ($ext == null) {
            $data = array(
                'title' => 'For Rent Listings',
                'js_file' => 'listings_for_rent'
            );
            $this->load->view('header_view', $data);
            $this->load->view('admin/admin_panel');
            $this->load->view('admin/for_rent_listings_view');
            $this->load->view('footer_view');
        } else {
            redirect(base_url().'/admin');
        }
    }
	
    // admin/users controller
	public function users($ext = null) {
		if ($ext == null) {
			$data['title'] = 'Users';
			$this->load->view('header_view', $data);
			$this->load->view('admin/admin_panel');
			$this->load->view('admin/user_view');
			$this->load->view('footer_view');
		} elseif ($ext == 'add') {
			$data['title'] = 'Add User';
			$this->load->view('header_view', $data);
			$this->load->view('admin/admin_panel');
			$this->load->view('admin/user_add_view');
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
	
    // returns a json string of for sale listings
	public function fetch_for_sale_listings() {
		if ($this->input->is_ajax_request()) {
			echo json_encode($this->for_sale_listing_model->fetch_for_sale_listings());
		} else {
			redirect(base_url().'admin/');
		}
	}
    
    // returns a json string of listings that aren't currently for sale
    public function fetch_not_for_sale_listings() {
		if ($this->input->is_ajax_request()) {
			echo json_encode($this->for_sale_listing_model->fetch_not_for_sale_listings());
		} else {
			redirect(base_url().'admin/');
		}
	}
    
    public function fetch_for_rent_listings() {
		if ($this->input->is_ajax_request()) {
			echo json_encode($this->for_rent_listing_model->fetch_for_rent_listings());
		} else {
			redirect(base_url().'admin/');
		}
	}
    
    public function fetch_not_for_rent_listings() {
		if ($this->input->is_ajax_request()) {
			echo json_encode($this->for_rent_listing_model->fetch_not_for_rent_listings());
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
	public function delete_listing() {
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
	
    // ajax post endpoint for creating a for sale record
    public function create_for_sale_listing() {
        if ($this->input->is_ajax_request()) {
            $data = array(
                'propId' => $this->input->post('id'),
                'price' => $this->input->post('price'),
                'blurb' => $this->input->post('blurb'),
                'comments' => $this->input->post('comments'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'beds' => $this->input->post('beds'),
                'baths' => $this->input->post('baths'),
                'sqft' => $this->input->post('sqft'),
                'acres' => $this->input->post('acres'),
                'created' => null,
                'modified' => null
            );
            
            if ($this->for_sale_listing_model->insert_for_sale($data)) {
                $this->data['message'] = 'For sale listing successfully created.';
            } else {
                $this->output->set_status_header('400');
                $this->data['message'] = 'Error creating sale record.';
            }
        } else {
            show_error('No direct access allowed');
        }
    }
    
    // ajax post endpoint for deleting a for sale record
    public function delete_for_sale_listing() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('property_id');
            
            if ($this->for_sale_listing_model->delete_for_sale($id)) {
				$this->data['message'] = 'For sale listing successfully deleted.';
			} else {
				$this->output->set_status_header('400');
				$this->data['message'] = 'Error deleting for sale listing.';
			}
			echo json_encode($this->data);
        } else {
			show_error('No direct access allowed');
		}
    }
    
    // ajax post endpoint for adding a user
	public function add_user() {
		if ($this->input->is_ajax_request()) {
			$user = array(
				'user_fName' => $this->input->post('fName'),
				'user_lName' => $this->input->post('lName'),
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password'))
			);

			if ($this->user_model->add_user($user)) {
				$this->data['message'] = 'User successfully added.';
			} else {
				$this->output->set_status_header('400');
				$this->data['message'] = 'Error creating user.';
			}
			echo json_encode($this->data);
		} else {
			show_error('No direct access allowed');
		}
	}
}
?>
