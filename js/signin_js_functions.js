/**
 * Functions to manage the signup page
 */

function clearSigninForm(){
	$(".user_input").val("");
}

function validateSigninForm(){
	var warningDiv = document.getElementById("warning_div");
	warningDiv.innerHTML = "";
	
	//collect user input and correspondent warning message
	var signinFormElements = document.getElementsByTagName("input");
	var warningElements = document.getElementsByClassName("warning");
	
	//variable to store test results
	var testResults = new Array();
	
	//validate user input
	testResults.push(validateEmail(signinFormElements, 0, warningElements));
	testResults.push(validatePassword(signinFormElements, 1, warningElements));
	
	//check if all tests are ok
	var validForm = true;
	
	for ( var testResultNumber in testResults) {
		if(!testResults[testResultNumber]){
			validForm = false;
			break;
		}
	}
	
	return validForm;
}