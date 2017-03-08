var changeForm = '';

$(document).ready(function() {

	$("#updateButton").on('click', function() {

		//Compared against original form for changes
		var changedForm = serializeForm();

		//#volunteerId is a hidden text input that contains the Id of the loaded volunteer
		var selection = $("#volunteerId").val();

		if(selection != "") {
			if(changedForm != origForm) {
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


function serializeForm() {
	var $form = $('form');
	var serializedForm = $form2.serialize();
	return serializedForm
}