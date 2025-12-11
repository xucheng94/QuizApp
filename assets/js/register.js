/*
  register.js — Corrected for real PHP registration flow
  - Validates all required fields
  - Highlights invalid fields
  - Shows popup during submit
  - Allows normal POST submission to backend
*/

const regForm = document.getElementById('regForm');
const popup = document.getElementById('popup');

// Field references
const firstName = document.getElementById('first_name');
const lastName = document.getElementById('last_name');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('pw');

regForm.addEventListener('submit', (event) => {
  // Clear previous errors
  [firstName, lastName, username, email, password].forEach((el) =>
    el.classList.remove('error')
  );

  let hasError = false;

  // Helper to mark fields invalid
  const mark = (field) => {
    field.classList.add('error');
    hasError = true;
  };

  // Validate each field
  if (firstName.value.trim() === '') mark(firstName);
  if (lastName.value.trim() === '') mark(lastName);
  if (username.value.trim() === '') mark(username);
  if (email.value.trim() === '') mark(email);
  if (password.value.trim().length < 8) mark(password);

  // Stop POST if errors found
  if (hasError) {
    event.preventDefault();
    alert('Please fill in all fields. Password must be at least 8 characters.');
    return;
  }

  // Allow normal POST submission
  popup.textContent = 'Registering…';
  popup.classList.add('show');
});
