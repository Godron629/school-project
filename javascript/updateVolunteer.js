var volunteerId = '';

$(document).ready(function() {

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

	$("#updateButton").on('click', function() {
		var changedForm = serializeForm();
		var volunteerId = $("#volunteerId").val();

		if(volunteerId != '') {
			if(changedForm != origForm) {
				if(confirm("Are you sure you want to save your changes?")) {
					$.ajax({
						url: "../php/updateVolunteer.php",
						type: "POST", 
						data: { form1 : origForm, form2 : changedForm},
						success: function(data) {
							origForm = serializeForm();
							$("#successDialog").dialog("open");
						}
					});
				} 
			} else {
					alert("No form fields have changed - Volunteer records unchanged");
			}
		} else {
				alert("Please select a volunteer");
		}
	});
});


function serializeForm() {
	var $form = $('form');
	var serializedForm = $form.serialize();
	return serializedForm
}