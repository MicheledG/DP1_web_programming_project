/**
 * Functions to manage the signup page
 */

function clearSigninForm(){
	document.getElementById("email").value = "";
	document.getElementById("password").value = "";
	document.getElementById("email-warning").innerHTML = "";
	document.getElementById("password-warning").innerHTML = "";
	document.getElementById("signin-error-msg").innerHTML = "";
}

function validateSigninForm(){
	var signinErrorMsg = document.getElementById("signin-error-msg");
	signinErrorMsg.innerHTML = "";
	
	//variable to store test results
	var testResults = new Array();
	
	//validate email
	var emailElement = document.getElementById("email");
	var emailWarning = document.getElementById("email-warning");
	testResults.push(validateEmail(emailElement, emailWarning));
	
	//validate password
	var passwordElement = document.getElementById("password");
	var passwordWarning = document.getElementById("password-warning");
	testResults.push(validatePassword(passwordElement, passwordWarning));
	
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