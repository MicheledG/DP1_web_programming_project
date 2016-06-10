/**
 * Functions to manage the my reservations page
 */

function clearRemoveReservationsForm() {
	var checkedBoxes = getCheckedBoxes("selected_reservation[]");
	
	//clear all the checked boxes
	checkedBoxes.forEach(function(checkedBox){checkedBox.checked = false;});
	
}


function validateRemoveReservationsForm(){
	//check if at least one reservation has been selected
	var checkedBoxes = getCheckedBoxes("selected_reservation[]");
	
	var validForm = null;
	
	if(checkedBoxes.length <= 0){
		alert("Select at least one reservation to remove!");
		validForm = false;
	} 
	else {
		validForm = confirm("Want to remove " + checkedBoxes.length + " reservations?");
		if(!validForm){
			//user press cancel
			clearRemoveReservationsForm();
		}
	} 

	return validForm;
}

function getCheckedBoxes(checkBoxName){
	
	var checkBoxes = document.getElementsByName(checkBoxName);
	var checkedBoxes = new Array();
	
	for (var i=0; i < checkBoxes.length; i++ ){
		if(checkBoxes[i].checked){
			checkedBoxes.push(checkBoxes[i]);
		}
	}
	
	return checkedBoxes;
	
}