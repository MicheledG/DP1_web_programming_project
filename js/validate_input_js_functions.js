function validateName(nameFormElement, warningElement) {
	//check name validity
	var nameRegExp = /^[A-Za-z ]+$/;
	//var nameRegExpSecondLevel = new RegExp("/^[A-Za-z]+$/");
	var match = nameRegExp.test(nameFormElement.value.trim());
	if(!match){
		warningElement.innerHTML = "invalid name: only letters and spaces are allowed";
	} else {
		warningElement.innerHTML = "";
	}
	
	return match;
}

function validateEmail(emailFormElement, warningElement)   {  
	//check email validity
	var emailRegExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var match = emailRegExp.test(emailFormElement.value);
	if(!match){
		warningElement.innerHTML = "invalid email";
	} else {
		warningElement.innerHTML = "";
	}
	
	return match;  
}  

function validatePassword(passwordFormElement, warningElement) {
	//check password validity
	var passwordRegExp = /^[A-Za-z0-9]+$/;
	var match = passwordRegExp.test(passwordFormElement.value);
	if(!match){
		warningElement.innerHTML = "invalid password: only letters and numbers are allowed";
	} else {
		warningElement.innerHTML = "";
	}
	
	return match;  
}