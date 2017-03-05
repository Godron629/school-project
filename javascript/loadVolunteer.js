//Make the .selectVolunteer select searchable
$(document).ready(function() {
	$('.selectVolunteer').select2();

/*	$("#loadButton").click(function() {*/
	$(".selectVolunteer").on('change', function() {

		var selection = {
			id: $('.selectVolunteer').val()
		}

		$.ajax({
			url: '../php/updateVolunteer.php',
			type: 'POST',
			data: selection,
			dataType: 'json',
			success: function(data) {
				console.log(data);
				loadVolunteerIntoFields(data);
				loadEmergencyContactIntoFields(data);
				loadPreferredDepartmentsIntoFields(data);
			}
		});
	});
});		

function loadVolunteerIntoFields(data) {
	$("#volunteerFirstName").attr("value", data['Volunteer'].volunteer_fname);
	$("#volunteerLastName").attr("value", data['Volunteer'].volunteer_lname);
	$("#volunteerEmail").attr("value", data['Volunteer'].volunteer_email);
	$("#volunteerDOB").attr("value", data['Volunteer'].volunteer_birthdate);

	//remove selected attribute or else multiple options will be selected after changing the volunteer a few times
	$("#volunteerGender option").removeAttr('selected');
	$("#volunteerGender option[value=" + data['Volunteer'].volunteer_gender + "]").attr('selected', 'selected');

	$("#volunteerAddress").attr("value", data['Volunteer'].volunteer_street);
	$("#volunteerCity").attr("value", data['Volunteer'].volunteer_city);

	$("#province option").removeAttr('selected');
	$("#province option[value=" + data['Volunteer'].volunteer_province + "]").attr('selected', 'selected');
	
	$("#postalCode").attr("value", data['Volunteer'].volunteer_postcode);
	$("#volunteerPrimaryPhone").attr("value", data['Volunteer'].volunteer_primaryphone);
	$("#volunteerSecondaryPhone").attr("value", data['Volunteer'].volunteer_secondaryphone);
}

function loadEmergencyContactIntoFields(data) {
	$("#emergencyFirstName").attr("value", data['Volunteer'].emergency_contact_fname);
	$("#emergencyLastName").attr("value", data['Volunteer'].emergency_contact_lname);

	$("#emergencyRelationship option").removeAttr('selected');
	$("#emergencyRelationship option[value='" + data['Volunteer'].relationship + "']").attr('selected', 'selected');

	$("#emergencyPhone").attr("value", data['Volunteer'].phone);
}

function loadPreferredDepartmentsIntoFields(data) {
	var $checkbox = $("#preferredDepartments input");

	$("#preferredDepartments input:not([hidden])").removeAttr("checked");

	/*if($("#preferredDepartments input[type='checkbox']").attr('hidden') == 'hidden') {
		$('this').attr('checked', 'checked');
	} */

	for (var i = 0; i < data["Dep"].length; i++) {
		var department = data["Dep"][i]["department"];
		var allow = data["Dep"][i]["allow"];

		if(allow === "yes") {
			switch(department) {
				case "front": 
					console.log("Hello!");
					$("#frontCheck").attr('checked', 'checked');
					break;
				case "vio":
					$("#volunteerCheck").attr('checked', 'checked');
					break;
				case "kitchen":
					$("#kitchenCheck").attr('checked', 'checked');
					break;
				case "warehouse":
					$("#warehouseCheck").attr('checked', 'checked');
					break;
				default:
					break;
			}
		}
	}
}