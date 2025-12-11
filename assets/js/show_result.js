const data = JSON.parse(localStorage.getItem('lastResult') || 'null');
const title = document.getElementById('title');
const details = document.getElementById('details');

if (!data || !data.questions) {
  title.textContent = 'No Result Found';
  details.innerHTML =
    '<p>No quiz record found. Please complete a quiz first.</p>';
} else {
  title.textContent = data.title + ' — Result Details';
  data.questions.forEach((q, i) => {
    const card = document.createElement('div');
    card.className = 'card';
    const isCorrect = data.answers[i] === q.correctIndex;
    card.innerHTML = `
      <div class="qtext">Q${i + 1}. ${q.question}</div>
      <div class="ans ${isCorrect ? 'correct' : 'wrong'}">
        Your Answer: ${q.options[data.answers[i]] ?? '—'} ${
      isCorrect ? '✅' : '❌'
    }
      </div>
      <div class="ans right">Correct Answer: ${q.options[q.correctIndex]}</div>
    `;
    details.appendChild(card);
  });
}

// a11y: sync aria-expanded
const t = document.getElementById('menu-toggle');
const b = document.querySelector('label.hamburger');
if (t && b) {
  const sync = () =>
    b.setAttribute('aria-expanded', t.checked ? 'true' : 'false');
  t.addEventListener('change', sync);
  sync();
}
