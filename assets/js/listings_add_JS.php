<?php header('Content-type: text/javascript'); ?>

/*
    JS controller for admin/properties
*/

(function($, ev) {
    
    
    
    // refresh the properties table
	var fetchProperties = function() {
        
        // remove any table rows currently being displayed
		$('tr:gt(0)').remove();
        
        // make an ajax call and build an updated table
		$.ajax({
			url: ev.baseUrl + 'admin/fetch_properties',
			type: 'get',
			success: function(res) {
                
                // convert string to json
				var resObj = JSON.parse(res);
				
                // build the table
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
				
                // event handler for delete links
				$('.delete').click(function(e) {
					e.preventDefault();
					
					var id = $(e.target).closest('tr').attr('id');
					deleteProperty(id);
				});
			},
			error: function(res) {
				console.log(res.message);
			}
		});
	}
	
    // delete the given property record
	var deleteProperty = function(id) {
		$.ajax({
			url: ev.baseUrl + 'admin/delete_listing',
			type: 'post',
			data: {property_id: id},
			success: function(res) {
				fetchProperties();
			},
			error: function(res) {
				console.log(res);
			}
		});
	}
    
    // main controller for the page
	$('document').ready(function() {
        
        // update and build table of properties
		fetchProperties();
        
        // event handler for save button
		$('#save').click(function() {
			var data = {};
            
            // get user input -- this is raw data that needs to be sanitized server-side
			data.address = $('#address').val();
			data.city = $('#city').val();
			data.beds = $('#beds').val();
			data.baths = $('#baths').val();
			data.sqft = $('#sqft').val();
			data.acres = $('#acres').val();
			
            // create the listing with an ajax call and update the table
			$.ajax({
				url: ev.baseUrl + 'admin/create_property',
				type: 'post',
				data: data,
				success: function(res) {
					$('.property-input').val("");
					fetchProperties();
				},
				error: function(res) {
					var resObj = JSON.parse(res);
					$('#message').html(resObj.message);
					console.log(res);
				}
			});
		});
	});
})(jQuery, emdre_vars)
