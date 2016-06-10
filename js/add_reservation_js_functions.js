//create the internal rows of the add reservation table
function createAddReservationOptions(){
	
	var MIN_DURATION_TIME = 1; //1 min
	var MAX_DURATION_TIME = 1440; //1440 min => 24h
	
	//retrieve hour starting time select element
	var hourSelect = document.getElementById("start-h-select");
	//retrieve min starting time select element
	var minSelect = document.getElementById("start-m-select");
	//retrieve duration time select element
	var minDurationSelect = document.getElementById("duration-select");
	
	//create options for hour starting time select
	var i = 0;
	for(i = 0; i < 24; i++){
		var hour = document.createElement("option");
		hour.value = i;
		hour.innerHTML = leadZero(i, 2);
		if(i == 0){
			hour.selected = "true";
		}
		hourSelect.appendChild(hour);
	}
	
	//create options for mins starting time select
	for(i = 0; i < 60; i++){
		var min = document.createElement("option");
		min.value = i;
		min.innerHTML = leadZero(i, 2);
		if(i == 0){
			min.selected = "true";
		}
		minSelect.appendChild(min);
	}
	
	//create options for duration time select
	for(i = MIN_DURATION_TIME; i <= MAX_DURATION_TIME; i++){
		var minDuration = document.createElement("option");
		minDuration.value = i;
		minDuration.innerHTML = i;
		if(i == 0){
			minDuration.selected = "true";
		}
		minDurationSelect.appendChild(minDuration);
	}
	
}

function leadZero(num, size) {
    var s = "0" + num;
    return s.substr(s.length-size);
}

function validateAddReservationForm() {
	var selectStartH = document.getElementById("start-h-select");
	var selectStartM = document.getElementById("start-m-select");
	var selectDuration = document.getElementById("duration-select");
	
	var selectedHour = selectStartH.options[selectStartH.selectedIndex].innerHTML;
	var selectedMin = selectStartM.options[selectStartM.selectedIndex].innerHTML;
	var selectedDuration = selectDuration.options[selectDuration.selectedIndex].value;
	
	var userChoice = confirm("Want to add reservation with:\r " +
			"Starting time (hh:mm): " + selectedHour + ":" + selectedMin + "\r " + 
			"Duration time (min): " + selectedDuration);

	return userChoice;
	
}

function clearAddReservationForm(){
	var selectElements = document.getElementsByTagName("select");
	
	for(var i = 0; i < selectElements.length; i++){
		selectElements.item(i).selectedIndex = 0; //reset the selected options for all the select
	}
	
	document.getElementById("insert-operation-result").innerHTML = "";
}