/**
 * Functions to manage the signup page
 */

function clearSignupForm(){
	$(".user_input").val("");
}

function validateSignupForm(){
	//collect user input and correspondent warning message
	var signupFormElements = document.getElementsByTagName("input");
	var warningElements = document.getElementsByClassName("warning");
	
	//variable to store test results
	var testResults = new Array();
	
	//validate user input
	testResults.push(validateName(signupFormElements, 0, warningElements));
	testResults.push(validateName(signupFormElements, 1, warningElements));
	testResults.push(validateEmail(signupFormElements, 2, warningElements));
	testResults.push(validatePassword(signupFormElements, 3, warningElements));
	//compare password and  confirm password value
	testResults.push(comparePasswordConfirmPassword(signupFormElements, 3, 4, warningElements));
	
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

function comparePasswordConfirmPassword(signupFormElements, passwordElementIndex
		, confirmpasswordElementIndex, warningElements) {
	
	if(warningElements[passwordElementIndex].innerHTML === "") {
		//valid password
		var equal = signupFormElements.item(passwordElementIndex).value.localeCompare(signupFormElements.item(confirmpasswordElementIndex).value);
		if(equal != 0){
			//the two typed passwords are not equal
			warningElements.item(confirmpasswordElementIndex).innerHTML = "not matching";
			return false;
		} 
		else {
			warningElements.item(confirmpasswordElementIndex).innerHTML = "";
			return true;
		}
		
	}
	else {
		warningElements.item(confirmpasswordElementIndex).innerHTML = "";
		return false;
	}
}