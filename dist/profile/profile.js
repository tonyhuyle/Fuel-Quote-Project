
document.addEventListener('DOMContentLoaded', function() {

	document.getElementById('select').addEventListener('click', function() {
		document.getElementById('currentState').style.display = 'none';
		document.getElementById('stateForm').style.display = 'block';
	});
});

document.getElementById('stateForm').addEventListener('submit', function(event) {
	event.preventDefault();

	var state = document.getElementById('state').value;

	if(state == "") {
		alert("State must be selected");
		return false;
	}

	document.getElementById('stateDisplay').textContent = state;
	document.getElementById('currentState').style.display = 'block';
	document.getElementById('stateForm').style.display = 'none';

	sendDataToServer('state', state);
});

function editField(fieldId) {
	const field = document.getElementById(fieldId);
	const currentValue = field.textContent;
	field.innerHTML = `<input type="text" class="mt-1 p-2 w-full border rounded-md" id="${fieldId}Input" value="${currentValue}">`;
	const input = document.getElementById(fieldId + 'Input');
	input.focus();
	input.addEventListener('blur', function() {
		updateField(fieldId, input.value);
	});
	input.addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			updateField(fieldId, input.value);
		}
	});
}

function updateField(fieldId, newValue) {
	if (fieldId === 'email' && !validateEmail(newValue)) {
        alert('Please enter a valid email address');
        return;
    }
	if (fieldId === 'name' && newValue.length < 3 || newValue.length > 50) {
		alert('Name must be between 3 and 50 characters');
		return;
	}
	if (fieldId === 'address1' && newValue.length > 100) {
		alert('Address must be less than 100 characters');
		return;
	}
	if (fieldId === 'address2' && newValue.length > 100) {
		alert('Address must be less than 100 characters');
		return;
	}
	if (fieldId === 'city' && newValue.length > 100) {
		alert('City must be less than 50 characters');
		return;
	}
	if (fieldId === 'zip' && newValue.length > 10) {
		alert('Zip must be 9 digits');
		return;
	}
 
	const field = document.getElementById(fieldId);
	field.textContent = newValue;
	sendDataToServer(fieldId, newValue);
}

function sendDataToServer(fieldId, newValue) {
	fetch('', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify({
			field: fieldId,
			value: newValue,
		}),
	})
	.then(response => response.json())
	.then(data => console.log(data))
	.catch((error) => {
	console.error('Error:', error);
	});
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}