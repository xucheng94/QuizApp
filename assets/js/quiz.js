// QUIZ_DATA is injected by PHP.
// Contains:
// - id
// - questions[]
// - options{ question_id: [ ... ] }

let index = 0;
let answers = {}; // question_id → selected option_id

const startBtn = document.getElementById('startBtn');
const quizContainer = document.getElementById('quizContainer');
const intro = document.querySelector('.quiz-intro');

const qText = document.getElementById('questionText');
const answerList = document.getElementById('answerList');

const backBtn = document.getElementById('backBtn');
const nextBtn = document.getElementById('nextBtn');

const questions = QUIZ_DATA.questions;

// Start quiz
startBtn.onclick = () => {
  intro.classList.add('hidden');
  quizContainer.classList.remove('hidden');

  renderQuestion();
};

// Render a question
function renderQuestion() {
  const q = questions[index];
  const opts = QUIZ_DATA.options[q.id] || [];

  qText.textContent = q.question_text;

  answerList.innerHTML = '';
  opts.forEach((opt) => {
    const div = document.createElement('div');
    div.className = 'answer-option';

    div.textContent = opt.option_text;
    div.dataset.optionId = opt.id;
    div.dataset.questionId = q.id;

    // Show selected state
    if (answers[q.id] == opt.id) {
      div.classList.add('selected');
    }

    // Handle click
    div.onclick = () => {
      answers[q.id] = opt.id;
      renderQuestion();
    };

    answerList.appendChild(div);
  });

  // Buttons
  backBtn.disabled = index === 0;

  if (index === questions.length - 1) {
    nextBtn.textContent = 'Finish';
  } else {
    nextBtn.textContent = 'Next';
  }
}

// Navigation
nextBtn.onclick = () => {
  if (index === questions.length - 1) {
    submitQuiz();
  } else {
    index++;
    renderQuestion();
  }
};

backBtn.onclick = () => {
  if (index > 0) {
    index--;
    renderQuestion();
  }
};

// Submit answers to backend (single request)
function submitQuiz() {
  const payload = {
    quiz_id: QUIZ_DATA.id,
    answers: answers,
  };

  fetch('/index.php?route=result', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload),
  })
    .then((res) => res.json())
    .then((data) => {
      window.location.href = `/index.php?route=show_result&attempt=${data.attempt_id}`;
    })
    .catch((err) => alert('Submission failed'));
}

// a11y for hamburger (same as other pages)
const t = document.getElementById('menu-toggle');
const b = document.querySelector('label.hamburger');
if (t && b) {
  const sync = () =>
    b.setAttribute('aria-expanded', t.checked ? 'true' : 'false');
  t.addEventListener('change', sync);
  sync();
}
