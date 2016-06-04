function validateName(signupFormElements, formElementIndex, warningElements) {
	//check name validity
	var nameRegExp = /^[A-Za-z ]+$/;
	//var nameRegExpSecondLevel = new RegExp("/^[A-Za-z]+$/");
	var match = nameRegExp.test(signupFormElements.item(formElementIndex).value.trim());
	if(!match){
		warningElements.item(formElementIndex).innerHTML = "invalid name: only letters and spaces are allowed";
	} else {
		warningElements.item(formElementIndex).innerHTML = "";
	}
	
	return match;
}

function validateEmail(signupFormElements, formElementIndex, warningElements)   {  
	//check email validity
	var emailRegExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var match = emailRegExp.test(signupFormElements.item(formElementIndex).value);
	if(!match){
		warningElements.item(formElementIndex).innerHTML = "invalid email";
	} else {
		warningElements.item(formElementIndex).innerHTML = "";
	}
	
	return match;  
}  

function validatePassword(signupFormElements, formElementIndex, warningElements) {
	//check password validity
	var passwordRegExp = /^[A-Za-z0-9]+$/;
	var match = passwordRegExp.test(signupFormElements.item(formElementIndex).value);
	if(!match){
		warningElements.item(formElementIndex).innerHTML = "invalid password: only letters and numbers are allowed";
	} else {
		warningElements.item(formElementIndex).innerHTML = "";
	}
	
	return match;  
}