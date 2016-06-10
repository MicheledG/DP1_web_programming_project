/**
 * Functions to manage the my reservations page
 */

function validateRemoveReservationsForm(){
	//check if at least one reservation has been selected
	var myreservationsFormElements = document.getElementsByName("selected_reservation[]");
	
	var validForm = false;
	
	for ( var i = 0; i < myreservationsFormElements.length; i++) {
		if(myreservationsFormElements.item(i).checked){
			validForm = true;
			break;
		}
	}
	
	if(!validForm){
		alert("Select at least one reservation to remove!");
	} 
	else {
		validForm = confirm("Want to remove " + myreservationsFormElements.length + " reservations?");
	} 

	return validForm;
}