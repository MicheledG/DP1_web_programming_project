//create the internal rows of the table
function createAddReservationTable(){
	var tTable = document.getElementById("add_reservation_table");
	var tBody = document.createElement("tbody");
	
	var startTimeRow = document.createElement("tr");
	
	var startTimeLabelField = document.createElement("td");
	var startTimeLabel = document.createElement("label");
	startTimeLabel.innerHTML = "Starting Time (hh:mm):"
	startTimeLabelField.appendChild(startTimeLabel);
	
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
	
	var durationTimeRow = document.createElement("tr");
	
	var durationTimeLabelField = document.createElement("td");
	var durationTimeLabel = document.createElement("label");
	durationTimeLabel.innerHTML = "Duration Time (min):"
	durationTimeLabelField.appendChild(durationTimeLabel);
	
	var minDurationSelectField = document.createElement("td");
	var minDurationSelect = document.createElement("select");
	//set all attributes for the select
	minDurationSelect.name = "duration_time";
	minDurationSelect.required = "true";
	for(i = 1; i <= 120; i++){
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
	
	tBody.appendChild(startTimeRow);
	tBody.appendChild(durationTimeRow);
	tTable.appendChild(tBody);
}

function leadZero(num, size) {
    var s = "0" + num;
    return s.substr(s.length-size);
}

function clearAddReservationForm(){
	var selectElements = document.getElementsByTagName("select");
	
	for(var i = 0; i < selectElements.length; i++){
		selectElements.item(i).selectedIndex = 0; //reset the selected options for all the select
	}
}