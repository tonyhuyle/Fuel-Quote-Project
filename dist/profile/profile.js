function toggleEdit() {
    var editProfileDiv = document.getElementById('editProfile');
	var profileDiv = document.getElementById('showProfile');
    editProfileDiv.classList.toggle('hidden');
	profileDiv.classList.toggle('hidden');
}

function validateProfile() {
	document.querySelector('form').addEventListener('submit', function(event) {
		event.preventDefault();

		var name = document.getElementById('name').value;
		var email = document.getElementById('email').value;
		var address1 = document.getElementById('address1').value;
		var address2 = document.getElementById('address2').value;
		var city = document.getElementById('city').value;
		var state = document.getElementById('state').value;
		var zip = document.getElementById('zip').value;

		var editError = document.getElementById('editError');
		var nameError = document.getElementById('nameError');
		var emailError = document.getElementById('emailError');
		var address1Error = document.getElementById('address1Error');
		var address2Error = document.getElementById('address2Error');
		var cityError = document.getElementById('cityError');
		var stateError = document.getElementById('stateError');
		var zipError = document.getElementById('zipError');

		editError.innerHTML = '';
		nameError.innerHTML = '';
		emailError.innerHTML = '';
		address1Error.innerHTML = '';
		address2Error.innerHTML = '';
		cityError.innerHTML = '';
		stateError.innerHTML = '';
		zipError.innerHTML = '';

		var isValid = true;
		if(name == '' || email == '' || address1 == '' || city == '' || state == '' || zip == '') {
			editError.innerHTML = 'Please fill out all required fields.';
			isValid = false;
		}
		if(name.length > 50 || !isNaN(name)) {
			nameError.innerHTML = 'Please enter a valid name.';
			isValid = false;
		}
		if(address1.length > 100) {
			address1Error.innerHTML = 'Please enter a valid address.';
			isValid = false;
		}
		if(address2.length > 100) {
			address2Error.innerHTML = 'Please enter a valid address.';
			isValid = false;
		}
		if(city.length > 100 || !isNaN(city)) {
			cityError.innerHTML = 'Please enter a valid city.';
			isValid = false;
		}
		if(zip.length > 9 || isNaN(zip)) {
			zipError.innerHTML = 'Please enter a valid zip code.';
			isValid = false;
		}
		if(!validateEmail(email)) {
			emailError.innerHTML = 'Please enter a valid email address.';
			isValid = false;
		}
		if(isValid) {
			this.submit();
		}
	});
}

function validateEmail(email) {
	var re = /\S+@\S+\.\S+/;
	return re.test(email);
}