const SAMPLE = [
  { name: 'Rizky Rahmat', points: 150 },
  { name: 'Fauzi Fauzan (you)', points: 140, you: true },
  { name: 'Shinta Maudy', points: 138 },
  { name: 'Iqbal Prasetya', points: 135 },
  { name: 'Sulistya Mawar', points: 120 },
  { name: 'Aisha Chen', points: 112 },
  { name: 'Diego Alvarez', points: 110 },
];

// Use lastResult to update "you"
const last = JSON.parse(localStorage.getItem('lastResult') || 'null');
if (last) {
  const existing = SAMPLE.find((x) => x.you);
  if (existing) existing.points = Math.max(existing.points, last.points || 0);
}

const sorted = SAMPLE.slice().sort((a, b) => b.points - a.points);
const top3 = sorted.slice(0, 3);
const podium = document.getElementById('podium');
['2nd', '1st', '3rd'].forEach((label, i) => {
  const idx = i === 0 ? 1 : i === 1 ? 0 : 2;
  const p = top3[idx];
  const div = document.createElement('div');
  div.className = 'p';
  div.innerHTML = `
    <div class="badge">${label}</div>
    <div class="name">${p.name.split(' ')[0]}</div>
    <div class="score">⭐ ${p.points} pts</div>`;
  podium.appendChild(div);
});

const list = document.getElementById('list');
sorted.forEach((u, i) => {
  const row = document.createElement('div');
  row.className = 'row' + (u.you ? ' you' : '');
  row.innerHTML = `<div class="rank">${i + 1}</div><div style="flex:1">${
    u.name
  }</div><div style="color:#6c7396">⭐ ${u.points} pts</div>`;
  list.appendChild(row);
});

// a11y: aria-expanded sync
const t = document.getElementById('menu-toggle');
const b = document.querySelector('label.hamburger');
if (t && b) {
  const s = () => b.setAttribute('aria-expanded', t.checked ? 'true' : 'false');
  t.addEventListener('change', s);
  s();
}
