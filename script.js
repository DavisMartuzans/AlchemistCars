const signUpBtn = document.querySelector('#sign-up-btn');
const signInBtn = document.querySelector('#sign-in-btn');
const emailInput = document.querySelector('#email');
const passwordInput = document.querySelector('#password');
const message = document.querySelector('#message');

signUpBtn.addEventListener('click', () => {
  const email = emailInput.value;
  const password = passwordInput.value;
  // Add sign up logic here
  message.textContent = 'Signed up successfully';
});

signInBtn.addEventListener('click', () => {
  const email = emailInput.value;
  const password = passwordInput.value;
  // Add sign in logic here
  message.textContent = 'Signed in successfully';
});