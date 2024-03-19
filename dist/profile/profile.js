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

		isValid = true;
		if(name == '' || email == '' || address1 == '' || city == '' || state == '' || zip == '') {
			alert('Please fill out all required fields.');
			isValid = false;
		}
		if(name.length > 50 || !isNaN(name)) {
			alert('Please enter a valid name.');
			isValid = false;
		}
		if(address1.length > 100) {
			alert('Please enter a valid address.');
			isValid = false;
		}
		if(address2.length > 100) {
			alert('Please enter a valid address.');
			isValid = false;
		}
		if(city.length > 100 || !isNaN(city)) {
			alert('Please enter a valid city.');
			isValid = false;
		}
		if(zip.length > 9 || isNaN(zip)) {
			alert('Please enter a valid zip code.');
			isValid = false;
		}
		if(!validateEmail(email)) {
			alert('Please enter a valid email address.');
			isValid = false;
		}
		if(isValid) {
			var profileDiv = document.getElementById('showProfile');
			var editProfileDiv = document.getElementById('editProfile');
			profileDiv.classList.toggle('hidden');
			editProfileDiv.classList.toggle('hidden');
			document.getElementById('profileEdit').submit();
		}
	});
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}