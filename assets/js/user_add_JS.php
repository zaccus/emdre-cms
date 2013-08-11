<?php header('Content-type: text/javascript'); ?>

(function($) {
	var create_user = function(userObj) {
		$.ajax({
			url: emdre_vars.baseUrl + 'admin/add_user',
			type: 'post',
			data: userObj,
			success: function() {
				$('.addUser_input').val('');
			},
			error: function(res) {
				console.log(res);
			}
		});
	}

	$(document).ready(function() {
		$('#save').click(function() {
			var userObj = {};
			userObj.fName = $('#addUser_fName').val();
			userObj.lName = $('#addUser_lName').val();
			userObj.username = $('#addUser_username').val();
			userObj.password = $('#addUser_password').val();
			create_user(userObj);
		});
	});
})(jQuery)
