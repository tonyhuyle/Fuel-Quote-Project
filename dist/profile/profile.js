const validationOptions = [
	{
		attribute: 'minlength',
		isValid: input => input.value && input.value.length >= parseInt(input.minLength, 10),
		errorMessage: (input, label) => `${label.textContent} must be at least ${input.minLength} characters`
	}
	,
	{
		attribute: 'custommaxlength',
		isValid: input => input.value && input.value.length <= parseInt(input.getAttribute('custommaxlength'), 10),
		errorMessage: (input, label) => `${label.textContent} must be at most ${input.getAttribute('custommaxlength')} characters`
	}
	,
	{
		attribute: 'required',
		isValid: input => input.value.trim() !== '',
		errorMessage: (input, label) => `${label.textContent} is required`
	}
];


document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('profileEditForm');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
		var inputs = form.querySelectorAll('input');
		var valid = true;

		inputs.forEach(function(input) {
			var label = input.parentElement.querySelector('label');
			var error = input.parentElement.querySelector('span.error');
			var validation = validationOptions.filter(option => input.hasAttribute(option.attribute));
			var errorArray = [];

			validation.forEach(validation => {
				if (!validation.isValid(input)) {
					errorArray.push(validation.errorMessage(input, label));
					valid = false;
				} else {
					error.textContent = '';
				}
			});

			if(label == 'name') {
				var hasNumbers = containsNumbers(input.value);
				if(hasNumbers) {
					error.textContent = 'Name cannot contain numbers';
					valid = false;
				}
			}

			if(label == 'email') {
				var validEmail = validateEmail(input.value());
				if(!validEmail) {
					error.textContent = 'Invalid email';
					valid = false;
				}
			}

			error.textContent = errorArray.pop();
			
		});

		if (valid) {
			form.submit();
		}
		event.preventDefault();
    });
});

function toggleEdit() {
    var editProfileDiv = document.getElementById('editProfile');
	var profileDiv = document.getElementById('showProfile');
    editProfileDiv.classList.toggle('hidden');
	profileDiv.classList.toggle('hidden');
};

function validateEmail(email) {
	var re = /\S+@\S+\.\S+/;
	return re.test(email);
}

function containsNumbers(input) {
	return /\d/.test(input);
}