var origForm;
//Make the .selectVolunteer select searchable
$(document).ready(function() {
	//Make Select Volunteer Select into a Select2
	$('.selectVolunteer').select2();

		$(".selectVolunteer").on('change', function() {

			//Value of .selectVolunteer is their volunteerId
			var selection = {
				id: $('.selectVolunteer').val()
			}

			$.ajax({
				url: '/Foodbank/code/php/loadUpdateFields.php',
				type: 'POST',
				data: selection,
				dataType: 'json',
				success: function(data) {
					loadVolunteerIntoFields(data);
					loadEmergencyContactIntoFields(data);
					loadPreferredDepartmentsIntoFields(data);
					loadPreferredAvailIntoFields(data);

					//Save form state after load to compare against for changes
					var $form = $('#updateVolunteerForm');
					origForm = $form.serialize();
				}
			});
		});
	});		

function loadVolunteerIntoFields(data) {
	//Deselect active checkbox checked from previous volunteer loads
	$("#volunteerInformation input:not([hidden])").prop("checked", false);

	$("#volunteerId").val(data['Volunteer'].volunteer_id);
	$("#volunteerFirstName").val(data['Volunteer'].volunteer_fname);
	$("#volunteerLastName").val(data['Volunteer'].volunteer_lname);
	$("#volunteerEmail").val(data['Volunteer'].volunteer_email);
	$("#volunteerDOB").val(data['Volunteer'].volunteer_birthdate);

	$("#volunteerGender option").removeAttr('selected');
	$("#volunteerGender option[value=" + data['Volunteer'].volunteer_gender + "]").attr('selected', 'selected');

	$("#volunteerAddress").val(data['Volunteer'].volunteer_street);
	$("#volunteerCity").val(data['Volunteer'].volunteer_city);

	$("#province option").removeAttr('selected');
	$("#province option[value=" + data['Volunteer'].volunteer_province + "]").attr('selected', 'selected');
	
	$("#postalCode").val(data['Volunteer'].volunteer_postcode);
	$("#volunteerPrimaryPhone").val(data['Volunteer'].volunteer_primaryphone);
	$("#volunteerSecondaryPhone").val(data['Volunteer'].volunteer_secondaryphone);
	
	if(data['Volunteer'].volunteer_status == '1') {
		$("#volunteerStatusCheck").prop('checked', true);
	}
}

function loadEmergencyContactIntoFields(data) {
	$("#emergencyFirstName").val(data['Volunteer'].emergency_contact_fname);
	$("#emergencyLastName").val(data['Volunteer'].emergency_contact_lname);

	$("#emergencyRelationship option").removeAttr('selected');
	$("#emergencyRelationship option[value='" + data['Volunteer'].relationship + "']").attr('selected', 'selected');

	$("#emergencyPhone").val(data['Volunteer'].phone);
}

function loadPreferredDepartmentsIntoFields(data) {
	//Deselect departments that have been checked from previous volunteer loads
	$("#preferredDepartments input:not([hidden])").prop("checked", false);

	//Go through the department checkboxes and get the values
	for (var i = 0; i < data["Dep"].length; i++) {

		var department = data["Dep"][i]["department"];
		var allow = data["Dep"][i]["allow"];

		if(allow === "yes") {
			switch(department) {
				case "front": 
					$("#frontCheck").prop('checked', true);
					break;
				case "vio":
					$("#volunteerCheck").prop('checked', true);
					break;
				case "kitchen":
					$("#kitchenCheck").prop('checked', true);
					break;
				case "warehouse":
					$("#warehouseCheck").prop('checked', true);
					break;
				default:
					break;
			}
		}
	}
}

function loadPreferredAvailIntoFields(data) {
	//Deselect departments that have been checked from previous volunteer loads
	$("#preferredTimes input:not([hidden])").prop('checked', false);

	//Go through the data and set the values of checkboxes 
	for (var i = 0; i < data["Avail"].length; i++) {
		var weekday = data["Avail"][i]["weekday"];
		var am = data["Avail"][i]["am"];
		var pm = data["Avail"][i]["pm"];

		if(am === "yes") {
			switch(weekday) {
				case "monday": 
					$("#mondayCheckAM").prop('checked', true);
					break;	
				case "tuesday": 
					$("#tuesdayCheckAM").prop('checked', true);
					break;	
				case "wednesday": 
					$("#wednesdayCheckAM").prop('checked', true);
					break;			
				case "thursday": 
					$("#thursdayCheckAM").prop('checked', true);
					break;	
				case "friday": 
					$("#fridayCheckAM").prop('checked', true);
					break;																		
				default:
					break;												
			}
		}

		if(pm === "yes") {
			switch(weekday) {
				case "monday": 
					$("#mondayCheckPM").prop('checked', true);		
					break;
				case "tuesday": 
					$("#tuesdayCheckPM").prop('checked', true);			
					break;
				case "wednesday": 
					$("#wednesdayCheckPM").prop('checked', true);		
					break;	
				case "thursday": 
					$("#thursdayCheckPM").prop('checked', true);			
					break;		
				case "friday": 
					$("#fridayCheckPM").prop('checked', true);	
					break;																	
				default:
					break;												
			}
		}
	}

}