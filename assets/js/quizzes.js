// Detect if we are in browse-all mode or subject mode
const list = document.getElementById('list'); // exists only in browse mode
const searchInput = document.getElementById('q'); // exists only in browse mode
const pills = document.querySelectorAll('.pill'); // exists only in browse mode

// ===============================
//  BROWSE-ALL MODE (Client-side)
// ===============================
if (list && searchInput && pills.length > 0) {
  // Placeholder quizzes (eventually replaced by AJAX)
  // For now, these are static from your original design
  const QUIZZES = [
    {
      id: 'math',
      title: 'Math Genius Test',
      qs: 20,
      level: 'Beginner',
      cat: 'Math',
    },
    {
      id: 'science',
      title: 'Ultimate Science',
      qs: 20,
      level: 'Mixed',
      cat: 'Science',
    },
    {
      id: 'history',
      title: 'History Buff',
      qs: 15,
      level: 'Intermediate',
      cat: 'History',
    },
  ];

  let filterCat = 'All';

  function render() {
    const keyword = (searchInput.value || '').toLowerCase();

    list.innerHTML = '';

    QUIZZES.filter((x) => {
      const matchCategory = filterCat === 'All' || x.cat === filterCat;
      const matchKeyword = x.title.toLowerCase().includes(keyword);
      return matchCategory && matchKeyword;
    }).forEach((x) => {
      const a = document.createElement('a');
      a.href = `/quiz_app/?route=quiz&id=${x.id}`;
      a.className = 'card';
      a.innerHTML = `
                <img src="https://via.placeholder.com/800x360?text=${encodeURIComponent(
                  x.cat
                )}" alt="">
                <strong>${x.title}</strong>
                <div class="meta"><span>${x.qs} Questions</span><span>${
        x.level
      }</span></div>
            `;
      list.appendChild(a);
    });
  }

  // Initial render
  render();

  // Search filter
  searchInput.addEventListener('input', render);

  // Category pills
  pills.forEach((p) => {
    p.addEventListener('click', () => {
      // Update active pill styling
      pills.forEach((x) => x.classList.remove('active'));
      p.classList.add('active');

      filterCat = p.dataset.cat;
      render();
    });
  });
}

// ===============================
//  SUBJECT MODE (Server-side)
// ===============================
// Nothing to render — server already rendered the cards.
// JS must gracefully do nothing.
// (This block intentionally left empty)

// ===============================
//  A11Y HAMBURGER SYNC (Always)
// ===============================
const t = document.getElementById('menu-toggle');
const b = document.querySelector('label.hamburger');

if (t && b) {
  const sync = () =>
    b.setAttribute('aria-expanded', t.checked ? 'true' : 'false');
  t.addEventListener('change', sync);
  sync();
}
