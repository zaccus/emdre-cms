<?php header('Content-type: text/javascript'); ?>
/*
    JS controller for admin/properties/for-sale
*/

(function($, ev) {
    
    // refresh the for sale listings table
	var fetchForSaleListings = function() {
        
        // remove all rows except table headers
        $('#propertyTable tr:gt(0)').remove();
        
        // make ajax call to endpoint and re-build table
        $.ajax({
            url: ev.baseUrl + "admin/fetch_for_sale_listings",
            type: 'get',
            success: function(res) {
                var resObj = JSON.parse(res);
                
                // build the table
                
                for (item in resObj) {
                    $('#propertyTable').append('<tr id="' + resObj[item].id + '">' +
                                                '<td>' + resObj[item].address + '</td>' +
                                                '<td>' + resObj[item].price + '</td>' + 
                                                '<td>' + resObj[item].blurb + '</td>' + 
                                                '<td><a href="#" class="delete">Delete</a></td>' +
                                                '</tr>');
                }
                
                // event handler for delete links
                $('.delete').click(function(e) {
                    e.preventDefault();
                    
                    var id = $(e.target).closest('tr').attr('id');
                    deleteProperty(id);
                });
            },
            error: function(res) {
                console.log(res);
            }
        }); 
        
	}
    
    // refresh the property options when adding listing
    var fetchProperties = function() {
        
        // remove all existing options (except 'Add New Property')
        $('#add-for-sale-listing .property-select option:gt(0)').remove();
        
        // make ajax call and re-build select options
        $.ajax({
            url: ev.baseUrl + 'admin/fetch_not_for_sale_listings/',
            type: 'get',
            success: function(res) {
                var resObj = JSON.parse(res);
                                
                for (item in resObj) {
                    $('#add-for-sale-listing .property-select').append('<option id="' + resObj[item].id + '">' + resObj[item].address + '</option>');
                }
            },
            error: function(res) {
                console.log(res);
            }
        });
    }
    
    // delete the given property record
	var deleteProperty = function(id) {
		$.ajax({
			url: ev.baseUrl + 'admin/delete_for_sale_listing',
			type: 'post',
			data: {property_id: id},
			success: function(res) {
				fetchForSaleListings();
			},
			error: function(res) {
				console.log(res);
			}
		});
	}
    
    // save for sale listing
    var save = function() {
        var data = {
                id: $('.property-select option:selected').attr('id'),
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
            url: ev.baseUrl + 'admin/create_for_sale_listing/',
            type: 'post',
            data: data,
            success: function(res) {
                console.log(res);
                $('#add-for-sale-listing').hide();
                $(".add-listing-link").show();
                fetchForSaleListings()
            },
            error: function(res) {
               console.log(res); 
            }
        });
    }
    
    // main page controller
	$(document).ready(function() {
        
        // refresh listings table
		fetchForSaleListings();
        
        // event handler for add listing link
        $('.add-listing-link').click(function(e) {
            e.preventDefault();
            
            fetchProperties();
            $('.for-sale-input').val('');
            
            $(e.target).hide();
            $("#add-for-sale-listing").show();
            $('#property-info').show();
        });
        
        // event handler for cancel link -- turns off add listing modal
        $('.modal-cancel').click(function(e) {
            e.preventDefault();
            
            $(e.target).closest(".modal").hide();
            $(".add-listing-link").show();
        });
        
        // displays add property form or not depending on value of .property-select
        $('.property-select').change(function() {
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
            $('.for-sale-input').val('');
            $(e.target).closest(".modal").hide();
            $(".add-listing-link").show();
        });
	});
})(jQuery, emdre_vars)
