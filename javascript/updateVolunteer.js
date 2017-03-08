var changeForm = '';

$(document).ready(function() {

	$("#updateButton").on('click', function() {

		//Compared against original form for changes
		var $form2 = $('form')
		changeForm = $form2.serialize();

		var selection = $("#volunteerId").val();

		if(selection != "") {
			if(changeForm != origForm) {
				if(confirm("Are you sure you want to save you changes?")) {
					$.ajax({
						url: "../php/updateVolunteer.php",
						type: "POST", 
						data: selection,
						success: function(data) {
							console.log(data);
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
