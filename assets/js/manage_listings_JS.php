<?php header('Content-type: text/javascript'); ?>
/*
    JS controller for general management of listings
*/

(function($, ev) {
    
    // is this a properties view?
    var isProperties = function() {
        if (ev.type === "listings_add") {
            return true;
        } else {
            return false;
        }
    }
    
    // is this a for sale view?
    var isForSale = function() {
        if (ev.type === "listings_for_sale") {
            return true;
        } else {
            return false;
        }
    }
    
    // is this a for rent view?
    var isForRent = function() {
        if (ev.type === "listings_for_rent") {
            return true;
        } else {
            return false;
        }
    }
        
    // build the appropriate table, depending on what type of view this is
    var buildTable = function(resObj) {
        
        if (isProperties()) {
                    
            for (item in resObj) {
                $('#propertyTable').append('<tr id="' + resObj[item].id + '">' +
                                            '<td>' + resObj[item].address + '</td>' +
                                            '<td>' + resObj[item].city + '</td>' + 
                                            '<td>' + resObj[item].beds + '</td>' + 
                                            '<td>' + resObj[item].baths + '</td>' +
                                            '<td>' + resObj[item].sqft + '</td>' +
                                            '<td>' + resObj[item].acres + '</td>' +
                                            '<td><a href="#" class="delete">Delete</a></td>' +
                                            '</tr>');
            }
            
        } else if (isForSale()) {
            
            for (item in resObj) {
                $('#propertyTable').append('<tr id="' + resObj[item].id + '">' +
                                            '<td>' + resObj[item].address + '</td>' +
                                            '<td>' + resObj[item].price + '</td>' + 
                                            '<td>' + resObj[item].blurb + '</td>' + 
                                            '<td><a href="#" class="delete">Delete</a></td>' +
                                            '</tr>');
            }
            
        } else if (isForRent()) {
            for (item in resObj) {
                $('#propertyTable').append('<tr id="' + resObj[item].id + '">' +
                                            '<td>' + resObj[item].address + '</td>' +
                                            '<td>' + resObj[item].price + '</td>' + 
                                            '<td><a href="#" class="delete">Delete</a></td>' +
                                            '</tr>');
            }
        }
    }
    
    // refresh the for sale listings table
	var fetchListings = function() {
        
        // declare variables
        var endpoint;
        
        // assign endpoint appropriately, depending on ev.type
        if (isForSale()) {
            endpoint = "admin/for_sale_listings_controller/fetch_for_sale_listings";
        } else if (isForRent()) {
            endpoint = "admin/for_rent_listings_controller/fetch_for_rent_listings";
        } else {
            endpoint = "admin/properties_controller/fetch_properties";
        }
        
        // remove all rows except table headers
        $('#propertyTable tr:gt(0)').remove();
        
        // make ajax call to endpoint and re-build table
        $.ajax({
            url: ev.baseUrl + endpoint,
            type: 'get',
            success: function(res) {
                
                // make js object with response
                var resObj = JSON.parse(res);
                
                // build the table
                buildTable(resObj);
                
                // event handler for delete links
                $('.delete').click(function(e) {
                    e.preventDefault();
                    
                    var id = $(e.target).closest('tr').attr('id');
                    deleteListing(id);
                });
            },
            error: function(res) {
                console.log(res);
            }
        }); 
        
	}
    
    // refresh the property options with all listings not in this category (for rent, for sale, etc.)
    var fetchNotListings = function() {
        
        // declare variables
        var endpoint;
        
        // remove all existing options (except 'Add New Property')
        $('#property-select option:gt(0)').remove();
        
        // assign endpoint appropriately, depending on ev.type
        if (isForSale()) {
            endpoint = "admin/for_sale_listings_controller/fetch_not_for_sale_listings";
        } else if (isForRent()) {
            endpoint = "admin/for_rent_listings_controller/fetch_not_for_rent_listings";
        }
        
        // make ajax call and re-build select options
        $.ajax({
            url: ev.baseUrl + endpoint,
            type: 'get',
            success: function(res) {
                var resObj = JSON.parse(res);
                
                for (item in resObj) {
                    $('#property-select').append('<option id="' + resObj[item].id + '">' + resObj[item].address + '</option>');
                }      
            },
            error: function(res) {
                console.log(res);
            }
        });
    }
    
    // delete the given property record
	var deleteListing = function(id) {
        
        // declare variables
        var endpoint;
        
        // assign endpoint appropriately, depending on ev.type
        if (isForSale()) {
            endpoint = "admin/for_sale_listings_controller/delete_for_sale_listing";
        } else if (isForRent()) {
            endpoint = "admin/for_rent_listings_controller/delete_for_rent_listing";
        } else {
            endpoint = "admin/properties_controller/delete_property";
        }
        
		$.ajax({
			url: ev.baseUrl + endpoint,
			type: 'post',
			data: {property_id: id},
			success: function(res) {
				fetchListings();
			},
			error: function(res) {
				document.write(res.responseText);
			}
		});
	}
    
    // save listing
    var save = function() {
        
        // declare variables
        var endpoint;
        
        // assign endpoint appropriately, depending on ev.type
        if (isForSale()) {
            endpoint = "admin/for_sale_listings_controller/create_for_sale_listing";
        } else if (isForRent()) {
            endpoint = "admin/for_rent_listings_controller/create_for_rent_listing";
        } else {
            endpoint = "admin/properties_controller/create_property";
        }
        
        var data = {
            id: $('#property-select option:selected').attr('id'),
            price: $('#price').val(),
            blurb: $('#blurb').val(),
            comments: $('#comments').val(),
            address: $("#address").val(),
            city: $("#city").val(),
            beds: $("#beds").val(),
            baths: $("#baths").val(),
            sqft: $("#sqft").val(),
            acres: $("#acres").val()
        };
        
        $.ajax({
            url: ev.baseUrl + endpoint,
            type: 'post',
            data: data,
            success: function(res) {
                $('#add-listing').hide();
                $("#add-listing-link").show();
                fetchListings();
            },
            error: function(res) {
               document.write(res.responseText);
            }
        });
    }
    
    // main page controller
	$(document).ready(function() {
        
        // refresh listings table
		fetchListings();
        
        // event handler for add listing link
        $('#add-listing-link').click(function(e) {
            e.preventDefault();
            
            fetchNotListings();
            //$('.for-sale-input').val('');
            
            $(e.target).hide();
            $('#add-listing').show();
            $('#property-info').show();
        });
        
        // event handler for cancel link -- turns off add listing modal
        $('.modal-cancel').click(function(e) {
            e.preventDefault();
            
            $(e.target).closest(".modal").hide();
            $("#add-listing-link").show();
        });
        
        // displays add property form or not depending on value of #property-select
        $('#property-select').change(function() {
            if ($(this).val() === 'New Property') {
                $('#property-info').show();
            } else {
                $('#property-info').hide();
            }
        });
        
        // saves a new sales record
        $('#save').click(function(e) {
            e.preventDefault();
            
            save();
            $('.listing-input input, .listing-input textarea').val('');
            $(e.target).closest(".modal").hide();
            $("#add-listing-link").show();
        });
	});
})(jQuery, emdre_vars)