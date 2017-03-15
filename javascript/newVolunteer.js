$(document).ready(function() {		

	$("#volunteerForm").submit(function(e) {
		e.preventDefault();
		
		$("#volunteerForm").serialize();

	    $("#successDialog").dialog({
	        autoOpen: false,
	        draggable: false,
	        title: "Success",
	        buttons: {
	        	'Ok' : function() {
	        		location.reload();
	        	}
	        }
	    });				

		$.ajax({
			type: 'POST', 
			data: $("#volunteerForm").serialize(),
			url : '../php/createNewVolunteer.php',
			success : function(data) {
				$("#successDialog").dialog("open");			
			}
		});
	});
});