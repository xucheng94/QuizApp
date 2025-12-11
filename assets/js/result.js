const data = JSON.parse(localStorage.getItem('lastResult') || 'null');
const fallback = { title: 'Quiz', total: 10, correct: 0, points: 0 };
const r = data || fallback;

document.getElementById('title').textContent = `${r.title} — Result`;
document.getElementById('total').textContent = r.total;
document.getElementById('correct').textContent = r.correct;
document.getElementById('points').textContent = r.points;

// accuracy & completion
const acc = r.total ? Math.round((r.correct / r.total) * 100) : 0;
const comp = 100;
document.getElementById('accText').textContent = acc + '%';
document.getElementById('compText').textContent = comp + '%';
document.getElementById('accBar').style.width = acc + '%';
document.getElementById('compBar').style.width = comp + '%';

// ring chart
const ring = document.getElementById('ring');
ring.style.setProperty('--pct', acc);
ring.setAttribute('data-label', acc + '%');

// a11y: sync aria-expanded
const t = document.getElementById('menu-toggle');
const b = document.querySelector('label.hamburger');
if (t && b) {
  const sync = () =>
    b.setAttribute('aria-expanded', t.checked ? 'true' : 'false');
  t.addEventListener('change', sync);
  sync();
}
