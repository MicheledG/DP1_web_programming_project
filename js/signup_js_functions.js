/**
 * Functions to manage the signup page
 */

function clearSignupForm(){
	document.getElementById("name").value = "";
	document.getElementById("lastname").value = "";
	document.getElementById("email").value = "";
	document.getElementById("password").value = "";
	document.getElementById("confirm-password").value = "";
	
	document.getElementById("name-warning").innerHTML = "";
	document.getElementById("lastname-warning").innerHTML = "";
	document.getElementById("email-warning").innerHTML = "";
	document.getElementById("password-warning").innerHTML = "";
	document.getElementById("confirm-password-warning").innerHTML = "";
	
	document.getElementById("signin-error-msg").innerHTML = "";
}

function validateSignupForm(){
	//collect user input and correspondent warning message
	var name = document.getElementById("name");
	var lastname = document.getElementById("lastname");
	var email = document.getElementById("email");
	var password = document.getElementById("password");
	var confirmPassword = document.getElementById("confirm-password");
	
	var nameWarning = document.getElementById("name-warning");
	var lastnameWarning = document.getElementById("lastname-warning");
	var emailWarning = document.getElementById("email-warning");
	var passwordWarning = document.getElementById("password-warning");
	var confirmPasswordWarning = document.getElementById("confirm-password-warning");
	
	//variable to store test results
	var testResults = new Array();
	
	//validate user input
	testResults.push(validateName(name, nameWarning));
	testResults.push(validateName(lastname, lastnameWarning));
	testResults.push(validateEmail(email, emailWarning));
	testResults.push(validatePassword(password, passwordWarning));
	//compare password and  confirm password value
	testResults.push(comparePasswordConfirmPassword(password, confirmPassword, confirmPasswordWarning));
	
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

function comparePasswordConfirmPassword(passwordFormElement, confirmPasswordFormElement,
		confirmPasswordWarning) {
	
	var equal = passwordFormElement.value.localeCompare(confirmPasswordFormElement.value);
	if(equal != 0){
		//the two typed passwords are not equal
		confirmPasswordWarning.innerHTML = "not matching";
		return false;
	} 
	else {
		confirmPasswordWarning.innerHTML = "";
		return true;
	}
}