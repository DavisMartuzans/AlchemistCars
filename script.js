<<<<<<< HEAD
const openFormButton = document.getElementById('open-form');
const closeFormButton = document.getElementById('close-form');
const formContainer = document.getElementById('form-container');

openFormButton.addEventListener('click', () => {
  formContainer.style.display = 'block';
});

closeFormButton.addEventListener('click', () => {
  formContainer.style.display = 'none';
});

/* back button */
function goBack() {
  window.history.back();
}
=======
const openFormButton = document.getElementById('open-form');
const closeFormButton = document.getElementById('close-form');
const formContainer = document.getElementById('form-container');

openFormButton.addEventListener('click', () => {
  formContainer.style.display = 'block';
});

closeFormButton.addEventListener('click', () => {
  formContainer.style.display = 'none';
});
>>>>>>> 47fadbc88b5219761800f3ab3029dfc08660867c
