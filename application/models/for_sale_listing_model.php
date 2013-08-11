<?php
    class For_Sale_Listing_Model extends Property_Model {
        
        // constructor
        function __construct() {
            parent::__construct();
        }
        
        // returns query for all for sale listings data
        function fetch_for_sale_listings() {
            $query = $this->db->get('for_sale_listings_view');
            return $query->result_array();
        }
        
        // returns id and address of properties not currently for sale
        function fetch_not_for_sale_listings() {
            $query = $this->db->get('not_for_sale_listings_view');
            return $query->result_array();
        }
        
        // insert a for sale record
        function insert_for_sale($data) {
            
            $saleData = array(
                'propId' => $data['propId'],
                'price' => $data['price'],
                'blurb' => $data['blurb'],
                'comments' => $data['comments'],
                'created' => null,
                'modified' => null
            );
            
            // if it's a new property, create a property record first and set propId accordingly
            if ($saleData['propId'] === 'newProperty') {
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
                    $saleData['propId'] = $this->db->insert_id();
                } else {
                    return false;
                }
            }
            
            return $this->db->insert('for_sale', $saleData);
        }
        
        // delete a for sale record
        function delete_for_sale($id) {
            $this->db->where('propId', $id);
            return $this->db->delete('for_sale');
        }
        
        // get id of last record inserted
        function get_last_inserted() {
            return $this->db->insert_id();
        }
    }
?>