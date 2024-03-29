const validationOptions = [
	{
		attribute: 'minlength',
    	isValid: input => {
			// If the input is optional and blank, pass the validation
			if (input.getAttribute('required') == null && input.value.trim() === '') {
				return true;
			}
			// Otherwise, check the length
			return input.value.length >= parseInt(input.minLength, 10);
    	},
    	errorMessage: (input, label) => `${label.textContent} must be at least ${input.minLength} characters`
	}
	,
	{
		attribute: 'custommaxlength',
    	isValid: input => {
			// If the input is optional and blank, pass the validation
			if (input.getAttribute('required') == null && input.value.trim() === '') {
				return true;
			}
			// Otherwise, check the length
			return input.value.length <= parseInt(input.getAttribute('custommaxlength'), 10);
    	},
    	errorMessage: (input, label) => `${label.textContent} must be at most ${input.getAttribute('custommaxlength')} characters`
	}
	,
	{
		attribute: 'id',
        isValid: input => {
            switch (input.getAttribute('id')) {
                case 'email':
                    // simple email validation
                    return /\S+@\S+\.\S+/.test(input.value);
                case 'name':
                    // check if it's a number
                    return !/\d/.test(input.value);
				case 'zip':
					// check if it's a number
					return /\d/.test(input.value);
                default:
                    // if it's another type, just return true
                    return true;
            }
        },
		errorMessage: (input, label) => `Please enter a valid ${input.getAttribute('name')}`
	},
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
				}
			});

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