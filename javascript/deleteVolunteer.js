$(document).ready(function() {
	$(".deleteButton").on('click', function() {
		var volunteerId = $("#volunteerId").val();

		$("#successDeleteDialog").dialog({
		    autoOpen: false,
		    draggable: false,
		    title: "Success",
		    buttons: {
		    	'Ok' : function() {
		    		location.reload();
		    	}
		    }
		});			

		if(volunteerId != "") {
			$("#confirmDeleteDialog").dialog({
				autoOpen: false,
				draggable: false,
				title: "Confirm Delete",
		        buttons: {
			        "Cancel" : function() {
			        	$(this).dialog("close");
			        },
			        "Delete" : function() {
			        	$(this).dialog("close");
						$.ajax({
							url: "../php/deleteVolunteer.php",
							type: "POST", 
							data: {id : volunteerId},
							success: function(data) {
								$("#successDeleteDialog").dialog("open");
							}
						});				        	
			        }
		        }					
			}).dialog("open");
		} else {
			//From updateVolunteer.js
			$("#noneSelectedDialog").dialog("open");
		}
		
	});
});