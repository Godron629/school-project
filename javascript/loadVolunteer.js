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
				loadPreferredAvailIntoFields(data);
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
	$("#preferredDepartments input:not([hidden])").removeAttr("checked");

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

function loadPreferredAvailIntoFields(data) {
	$("#preferredTimes input:not([hidden])").removeAttr("checked");

	for (var i = 0; i < data["Avail"].length; i++) {
		var weekday = data["Avail"][i]["weekday"];
		var am = data["Avail"][i]["am"];
		var pm = data["Avail"][i]["pm"];

		if(am === "yes") {
			switch(weekday) {
				case "monday": 
					$("#mondayCheckAM").attr('checked', 'checked');
					break;	
				case "tuesday": 
					$("#tuesdayCheckAM").attr('checked', 'checked');
					break;	
				case "wednesday": 
					$("#wednesdayCheckAM").attr('checked', 'checked');
					break;			
				case "thursday": 
					$("#thursdayCheckAM").attr('checked', 'checked');
					break;	
				case "friday": 
					$("#fridayCheckAM").attr('checked', 'checked');
					break;																		
				default:
					break;												
			}
		}

		if(pm === "yes") {
			switch(weekday) {
				case "monday": 
					$("#mondayCheckPM").attr('checked', 'checked');			
					break;
				case "tuesday": 
					$("#tuesdayCheckPM").attr('checked', 'checked');			
					break;
				case "wednesday": 
					$("#wednesdayCheckPM").attr('checked', 'checked');			
					break;	
				case "thursday": 
					$("#thursdayCheckPM").attr('checked', 'checked');			
					break;		
				case "friday": 
					$("#fridayCheckPM").attr('checked', 'checked');			
					break;																	
				default:
					break;												
			}
		}
	}

}