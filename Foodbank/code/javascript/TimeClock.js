$(document).ready(function() {    
$("#clockedInDialog").dialog({
        autoOpen: false,
        draggable: false,
        title: "Success",
        buttons: {
         'Ok' : function() {
          $(this).dialog("close");
         }
        }
    });

	$("#clockedOutDialog").dialog({
        autoOpen: false,
        draggable: false,
        title: "Success",
        buttons: {
         'Ok' : function() {
          $(this).dialog("close");
         }
        }
    });

	
});