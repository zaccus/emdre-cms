<?php
    class For_Rent_Listing_Model extends Property_Model {
        
        // constructor
        function __construct() {
            parent::__construct();
        }
        
        // returns query for all for rent listings data
        function fetch_for_rent_listings() {
            $query = $this->db->get('for_rent_listings_view');
            return $query->result_array();
        }
        
        // returns id and address of properties not currently for rent
        function fetch_not_for_rent_listings() {
            $query = $this->db->get('not_for_rent_listings_view');
            return $query->result_array();
        }
        
        // insert a for rent record
        function insert_for_rent($data) {
            
            $rentData = array(
                'propId' => $data['propId'],
                'price' => $data['price'],
                'blurb' => $data['blurb'],
                'comments' => $data['comments'],
                'created' => null,
                'modified' => null
            );
            
            // if it's a new property, create a property record first and set propId accordingly
            if ($rentData['propId'] === 'newProperty') {
                $propData = array(
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'beds' => $data['beds'],
                    'baths' => $data['baths'],
                    'sqft' => $data['sqft'],
                    'acres' => $data['acres'],
                    'created' => null,
                    'modified' => null
                );
                
                if ($this->insert_property($propData)) {
                    $rentData['propId'] = $this->db->insert_id();
                } else {
                    return false;
                }
            }
            
            return $this->db->insert('for_rent', $rentData);
        }
        
        // delete a for rent record
        function delete_for_rent($id) {
            $this->db->where('propId', $id);
            return $this->db->delete('for_rent');
        }
        
        // get id of last record inserted
        function get_last_inserted() {
            return $this->db->insert_id();
        }
    }
/* end file for_rent_listings_model.php */
/* location: ./application/models/for_rent_listings_model.php */