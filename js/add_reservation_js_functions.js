//create the internal rows of the add reservation table
function createAddReservationTable(){
	
	var MIN_DURATION_TIME = 1; //1 min
	var MAX_DURATION_TIME = 1440; //1440 min => 24h
	
	//retrieve add reservation table
	var tTable = document.getElementById("add_reservation_table");
	
	//create body and the rows to insert the selection items of the form
	var tBody = document.createElement("tbody");
	
	//start time (hh:mm) row 
	var startTimeRow = document.createElement("tr");
	
	var startTimeLabelField = document.createElement("td");
	var startTimeLabel = document.createElement("label");
	startTimeLabel.innerHTML = "Starting Time (hh:mm):"
	startTimeLabelField.appendChild(startTimeLabel);
	
	//start time hour (HH:mm) field
	var hourSelectField = document.createElement("td");
	var hourSelect = document.createElement("select");
	//set all attributes for the select
	hourSelect.name = "start_time_h";
	hourSelect.required = "true";
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
	hourSelectField.appendChild(hourSelect);
	
	//start time minutes (hh:MM) field
	var minSelectField = document.createElement("td");
	var minSelect = document.createElement("select");
	//set all attributes for the select
	minSelect.name = "start_time_m";
	minSelect.required = "true";
	for(i = 0; i < 60; i++){
		var min = document.createElement("option");
		min.value = i;
		min.innerHTML = leadZero(i, 2);
		if(i == 0){
			min.selected = "true";
		}
		minSelect.appendChild(min);
	}
	minSelectField.appendChild(minSelect);
	
	startTimeRow.appendChild(startTimeLabelField);
	startTimeRow.appendChild(hourSelectField);
	startTimeRow.appendChild(minSelectField);
	
	//duration time (min) row
	var durationTimeRow = document.createElement("tr");
	
	var durationTimeLabelField = document.createElement("td");
	var durationTimeLabel = document.createElement("label");
	durationTimeLabel.innerHTML = "Duration Time (min):"
	durationTimeLabelField.appendChild(durationTimeLabel);
	
	//duration time (MIN) field
	var minDurationSelectField = document.createElement("td");
	var minDurationSelect = document.createElement("select");
	//set all attributes for the select
	minDurationSelect.name = "duration_time";
	minDurationSelect.required = "true";
	for(i = MIN_DURATION_TIME; i <= MAX_DURATION_TIME; i++){
		var minDuration = document.createElement("option");
		minDuration.value = i;
		minDuration.innerHTML = i;
		if(i == 0){
			minDuration.selected = "true";
		}
		minDurationSelect.appendChild(minDuration);
	}
	minDurationSelectField.appendChild(minDurationSelect);
	
	durationTimeRow.appendChild(durationTimeLabelField);
	durationTimeRow.appendChild(minDurationSelectField);
	
	//append the 2 rows and the body
	tBody.appendChild(startTimeRow);
	tBody.appendChild(durationTimeRow);
	tTable.appendChild(tBody);
}

function leadZero(num, size) {
    var s = "0" + num;
    return s.substr(s.length-size);
}

function validateAddReservationForm() {
	var selectElements = document.getElementsByTagName("select");
	
	var selectedHour = selectElements.item(0).options[selectElements.item(0).selectedIndex].innerHTML;
	var selectedMin = selectElements.item(1).options[selectElements.item(1).selectedIndex].innerHTML;
	var selectedDuration = selectElements.item(2).options[selectElements.item(2).selectedIndex].value;
	
	var userChoice = confirm("Want to add reservation with:\r" +
			"Starting time (hh:mm): " + selectedHour + ":" + selectedMin + "\r" + 
			"Duration time (min): " + selectedDuration);

	return userChoice;
	
}

function clearAddReservationForm(){
	var selectElements = document.getElementsByTagName("select");
	
	for(var i = 0; i < selectElements.length; i++){
		selectElements.item(i).selectedIndex = 0; //reset the selected options for all the select
	}
}