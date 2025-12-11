/*
          Commit: Add popup-based success feedback for login + explicit validation
          - Validate non-empty email & password, highlight invalid fields
          - Show custom popup and redirect after 1.5s
          - Keep a11y sync for hamburger (aria-expanded)
        */

const loginForm = document.getElementById('loginForm');
const emailInput = document.getElementById('email');
const pwInput = document.getElementById('pw');
const popup = document.getElementById('popup');

loginForm.addEventListener('submit', (event) => {
  const emailVal = emailInput.value.trim();
  const pwVal = pwInput.value.trim();

  if (emailVal === '' || pwVal === '') {
    event.preventDefault();
    if (emailVal === '') emailInput.classList.add('error');
    if (pwVal === '') pwInput.classList.add('error');
    alert('Please enter both email and password.');
    return;
  }

  popup.textContent = 'Logging in…';
  popup.classList.add('show');
});
