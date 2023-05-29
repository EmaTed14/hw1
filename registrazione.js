const form = document.getElementById('form');
const nameInput = document.querySelector('.nome input');
const usernameInput = document.querySelector('.username input');
const surnameInput = document.querySelector('.cognome input');
const passwordInput = document.querySelector('.password input');
const confirm_passwordInput = document.querySelector('.conferma_password input');
const emailInput = document.querySelector('.email input');
const dateInput = document.querySelector('.data input');
const genderInput = document.querySelectorAll('.sesso input');

const responses = {};

form.addEventListener('submit', checkInputs);

nameInput.addEventListener('input', checkNameInput);
surnameInput.addEventListener('input', checkSurnameInput);
usernameInput.addEventListener('input', checkUsernameInput);
emailInput.addEventListener('input', checkEmailInput);
passwordInput.addEventListener('input', checkPasswordInput);
confirm_passwordInput.addEventListener('input', checkConfirmPasswordInput);
dateInput.addEventListener('input', checkDateInput);

function saveResponse(inputName, isValid) {
  responses[inputName] = isValid;
  
}

function checkInputs(event) {
  event.preventDefault();
 
  if (
    responses['name'] &&
    responses['username'] &&
    responses['surname'] &&
    responses['password'] &&
    responses['confirm_password'] &&
    responses['email']
  ) {
    form.submit();
  } else {
    alert('Riempi tutti i campi');
  }
}

function checkDateInput() {
  const dateValue = dateInput.value.trim();
  const errorDate = document.createElement('p');

  const errors = dateInput.parentNode.querySelectorAll('.error');
  for (let i = 0; i < errors.length; i++) {
    errors[i].remove();
  }

  if (dateValue === '') {
    errorDate.textContent = 'Completa la data';
    errorDate.classList.add('error');
    dateInput.parentNode.appendChild(errorDate);
    saveResponse('date', false);
  
  } else {
    saveResponse('date', true);
  }

 
}

function onJsonUsername(json) {
  const errorUsername = document.createElement('p');

console.log(json);
  const errors = usernameInput.parentNode.querySelectorAll('.error');
  for (let i = 0; i < errors.length; i++) {
    errors[i].remove();
  }

  if (json.exists === true) {
    console.log('sono qui');
    errorUsername.textContent = 'Nome utente già utilizzato';
    errorUsername.classList.add('error');
    usernameInput.parentNode.appendChild(errorUsername);
    saveResponse('username', false);
    // Specify the condition for performing the desired action here
  } else {
    errorUsername.textContent = 'Nome utente valido';
    errorUsername.classList.add('error');
    usernameInput.parentNode.appendChild(errorUsername);
    console.log('username ok')
    saveResponse('username', true);
  }
}

function onResponse(response) {
  if (!response.ok) return null;
  return response.json();
}

function checkUsernameInput() {

  const usernameValue = usernameInput.value.trim();
  const errorUsername = document.createElement('p');

  const errors = usernameInput.parentNode.querySelectorAll('.error');
  for (let i = 0; i < errors.length; i++) {
    errors[i].remove();
  }

  if (!/^[a-zA-Z0-9_]{1,15}$/.test(usernameValue)) {
    errorUsername.textContent = 'Nome utente non valido';
    errorUsername.classList.add('error');
    usernameInput.parentNode.appendChild(errorUsername);
    saveResponse('username', false);
  } else {
    fetch('checkusername.php?q=' + encodeURIComponent(usernameValue))
      .then(onResponse)
      .then(onJsonUsername);
  }
}


function checkNameInput() {
  const nameValue = nameInput.value.trim();
  const errorName = document.createElement('p');

  const errors = nameInput.parentNode.querySelectorAll('.error');
  for (let i = 0; i < errors.length; i++) {
    errors[i].remove();
  }

  if (nameValue === '') {
    errorName.textContent = 'sono vuoto';
    errorName.classList.add('error');
    nameInput.parentNode.appendChild(errorName);
    saveResponse('name', false);
    
  } else if (!/^[a-zA-Z]+$/.test(nameValue)) {
    errorName.textContent = 'The name can only contain letters.';
    errorName.classList.add('error');
    nameInput.parentNode.appendChild(errorName);
    saveResponse('name', false);
   
  } else {
    console.log('Nome vero');
    saveResponse('name', true);
  }

  
}

function checkSurnameInput() {
  const surnameValue = surnameInput.value.trim();
  const errorSurname = document.createElement('p');

  const errors = surnameInput.parentNode.querySelectorAll('.error');
  for (let i = 0; i < errors.length; i++) {
    errors[i].remove();
  }

  if (surnameValue === '') {
    errorSurname.textContent = 'sono vuoto';
    errorSurname.classList.add('error');
    surnameInput.parentNode.appendChild(errorSurname);
    saveResponse('surname', false);
   
  } else if (!/^[a-zA-Z]+$/.test(surnameValue)) {
    errorSurname.textContent = 'The surname can only contain letters.';
    errorSurname.classList.add('error');
    surnameInput.parentNode.appendChild(errorSurname);
    saveResponse('surname', false);
    
  } else {
    console.log('Cognome vero');
    saveResponse('surname', true);
  }

 
}

function checkPasswordInput() {
  const passwordValue = passwordInput.value.trim();
  const errors = passwordInput.parentNode.querySelectorAll('.error');
  const errorPassword = document.createElement('p');

  for (let i = 0; i < errors.length; i++) {
    errors[i].remove();
  }

  if (passwordValue === '') {
    errorPassword.textContent = 'sono vuoto';
    errorPassword.classList.add('error');
    passwordInput.parentNode.appendChild(errorPassword);
    saveResponse('password', false);
    
  } else if (passwordValue.length < 8) {
    errorPassword.textContent = 'The password must contain at least 8 characters.';
    errorPassword.classList.add('error');
    passwordInput.parentNode.appendChild(errorPassword);
    saveResponse('password', false);

  } else if (!/^[a-zA-Z0-9?!@&$]+$/.test(passwordValue)) {
    errorPassword.textContent = 'The password can contain letters, numbers, or special characters: ? ! @ & $';
    errorPassword.classList.add('error');
    passwordInput.parentNode.appendChild(errorPassword);
    saveResponse('password', false);
    
  } else {
    console.log('Password ok');
    saveResponse('password', true);
  }

  
}

function checkConfirmPasswordInput() {
  const passwordValue = passwordInput.value.trim();
  const confirmPasswordValue = confirm_passwordInput.value.trim();
  const errorConPassword = document.createElement('p');

  const errors = confirm_passwordInput.parentNode.querySelectorAll('.error');
  for (let i = 0; i < errors.length; i++) {
    errors[i].remove();
  }

  if (confirmPasswordValue === '') {
    errorConPassword.textContent = 'sono vuoto';
    errorConPassword.classList.add('error');
    confirm_passwordInput.parentNode.appendChild(errorConPassword);
    saveResponse('confirm_password', false);
    
  } else if (confirmPasswordValue !== passwordValue) {
    errorConPassword.textContent = 'Passwords do not match.';
    errorConPassword.classList.add('error');
    confirm_passwordInput.parentNode.appendChild(errorConPassword);
    saveResponse('confirm_password', false);
 
  } else {
    console.log('Conferma pass ok');
    saveResponse('confirm_password', true);
  }

  
}


function onJsonEmail(json) {
  const errorEmail = document.createElement('p');

console.log(json);

  const errors = emailInput.parentNode.querySelectorAll('.error');
  for (let i = 0; i < errors.length; i++) {
    errors[i].remove();
  }

 
  if (json.exists === true) {
   
    errorEmail.textContent = 'email già esistente';
    errorEmail.classList.add('error');
    emailInput.parentNode.appendChild(errorEmail);
    saveResponse('email', false);
    // Specify the condition for performing the desired action here
  } else {
    errorEmail.textContent = 'email utilizzabile';
    errorEmail.classList.add('error');
    emailInput.parentNode.appendChild(errorEmail);
    console.log('Email ok');
    saveResponse('email', true);
  }
}






function checkEmailInput() {
  const emailValue = emailInput.value.trim();
  const errorEmail = document.createElement('p');

  const errors = emailInput.parentNode.querySelectorAll('.error');
  for (let i = 0; i < errors.length; i++) {
    errors[i].remove();
  }

  if (emailValue === '') {
    errorEmail.textContent = 'sono vuoto';
    errorEmail.classList.add('error');
    emailInput.parentNode.appendChild(errorEmail);
    saveResponse('email', false);
    
  } else if (!/\S+@\S+\.\S+/.test(emailValue)) {
    errorEmail.textContent = 'The email is not valid.';
    errorEmail.classList.add('error');
    emailInput.parentNode.appendChild(errorEmail);
    saveResponse('email', false);

  } else  {
    fetch('checkemail.php?q=' + encodeURIComponent(emailValue))
      .then(onResponse)
      .then(onJsonEmail);
    
  } 
}




