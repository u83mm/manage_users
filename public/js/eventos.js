"use strict"; 

/** Change the form's action attribute to point 'changePassword' controller */
function changePassword() {
	document.getElementById("admin_form").action = "/admin/changePassword";
}

window.onload = function() {
	/** Event to 'changePassword' */
	let changePasswordButton = document.querySelector('#change_passwd');
	if(changePasswordButton) changePasswordButton.addEventListener('click', changePassword);
}
