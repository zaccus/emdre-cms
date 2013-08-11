<?php
class For_Sale_Listings_Controller extends Admin_Controller {
    // constructor
	function __construct() {
		parent::__construct();
	
        // load for sale listing model
        $this->load->model('property_model');
        $this->load->model('for_sale_listing_model');
	}
    
    // admin/for-sale-listings controller
    public function index($ext = null) {
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
}
/* end of fiel listings_for_sale.php */
/* location: ./application/controllers/listings_for_sale_controller.php */