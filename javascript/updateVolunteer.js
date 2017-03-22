var volunteerId = '';

$(document).ready(function() {

	//Shown if volunteer update was successful
    $("#successDialog").dialog({
        autoOpen: false,
        draggable: false,
        title: "Success",
        buttons: {
        	'Ok' : function() {
        		$(this).dialog("close");
        	},
        	'Refresh' : function() {
        		location.reload();
        	}
        }
    });	

    //Show if no volunteer is selected
    $("#noneSelectedDialog").dialog({
        autoOpen: false,
        draggable: false,
        title: "Warning",
        buttons: {
        	'Ok' : function() {
        		$(this).dialog("close");
        	}
        }
    });	    

    //Show if no volunteer is selected
    $("#nothingChangedDialog").dialog({
        autoOpen: false,
        draggable: false,
        title: "Warning",
        buttons: {
        	'Ok' : function() {
        		$(this).dialog("close");
        	}
        }
    });	    

    $("#updateVolunteerForm").submit(function(e) {
    	e.preventDefault();

		var changedForm = $("#updateVolunteerForm").serialize();
		var volunteerId = $("#volunteerId").val();

        console.log(volunteerId);

		if(volunteerId != '') {
			if(changedForm != origForm) {
				$("#confirmChangesDialog").dialog({
					autoOpen: false,
					draggable: false,
					title: "Save Changes?",
			        buttons: {
				        "Cancel" : function() {
				        	$(this).dialog("close");
				        },
				        "Save" : function() {
							$.ajax({
								url: "../php/updateVolunteer_submit.php",
								type: "POST", 
								data: { form1 : origForm, form2 : changedForm},
								success: function(data) {
									origForm = $("#updateVolunteerForm").serialize();
									$("#successDialog").dialog("open");
								}
							});				        	
				        }
			        }					
				}).dialog("open");
			} else {
				$("#nothingChangedDialog").dialog("open");
			}
		} else {
			$("#noneSelectedDialog").dialog("open");
		}
    });
});