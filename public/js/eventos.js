"use strict"; 

/** Change the form's action attribute to point 'changePassword' controller */
function changePassword() {
	document.getElementById("admin_form").action = "/admin/changePassword";
}

/** Show or hide the password */
function showPassword() {
	/* if(this.previousElementSibling.firstChild.type == 'password') {		
		this.previousElementSibling.firstChild.type = 'text';
		this.innerHTML = "<img src='/images/eye_closed.png' alt='eye_closed' height='40' />";
	} else {		
		this.previousElementSibling.firstChild.type = 'password';
		this.innerHTML = "<img src='/images/eye.png' alt='eye' height='40' />";
	} */

	let passwordField = this.previousElementSibling.getElementsByClassName('password');		

	if(passwordField[0].type == 'password') {
		passwordField[0].type = 'text';
		this.innerHTML = "<img src='/images/eye_closed.png' alt='eye_closed' height='40' />";
	} else {
		passwordField[0].type = 'password';
		this.innerHTML = "<img src='/images/eye.png' alt='eye' height='40' />";
	}
}

window.onload = function() {
	/** Event to 'changePassword' */
	let changePasswordButton = document.querySelector('#change_passwd');
	if(changePasswordButton) changePasswordButton.addEventListener('click', changePassword);

	/** Event to 'change password visibility' */
	let visibilityButton = document.querySelectorAll('.show_password');
	if(visibilityButton.length > 0) visibilityButton.forEach(button => button.addEventListener('click', showPassword));

	/** Event to 'change password visibility' */	
	let showPasswordChars = document.querySelectorAll('.show_password');

	if(showPasswordChars.length > 0) {
		showPasswordChars.forEach(showPasswordChar => {
			showPasswordChar.addEventListener('click', () => {				
				let input = showPasswordChar.parentNode.previousElementSibling.querySelector('input');
				if(input.type == 'password') {
					input.type = 'text';
					showPasswordChar.src = '/images/eye_closed.svg';
				} else {
					input.type = 'password';
					showPasswordChar.src = '/images/eye.svg';
				}
			});
		});
	}
}
