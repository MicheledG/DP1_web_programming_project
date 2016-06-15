function validateName(nameFormElement, warningElement) {
	warningElement.innerHTML = "";
	var validName = true;
	//check name validity
	var nameRegExp = /^[A-Za-z ]+$/;
	var name = nameFormElement.value.trim();
	if (name.length <= 255) {
		validName = nameRegExp.test(name);
		if(!validName){
			warningElement.innerHTML = "invalid name: only letters and spaces are allowed";
		}
	}
	else {
		validName = false;
		warningElement.innerHTML = "invalid name: to many characters (max 255)";
	}
	
	return validName;
}

function validateEmail(emailFormElement, warningElement)   {  
	warningElement.innerHTML = "";
	var validEmail = true;
	//check email validity
	var emailRegExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var email = emailFormElement.value.trim();
	if (email.length <= 255 ) {
		validEmail = emailRegExp.test(email);
		if(!validEmail){
			warningElement.innerHTML = "invalid email";
		}
	}
	else {
		validEmail = false;
		warningElement.innerHTML = "invalid email: to many characters (max 255)";
	}
	
	return validEmail;  
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