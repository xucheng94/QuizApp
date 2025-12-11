// Optional: sync aria-expanded on hamburger
const t = document.getElementById('menu-toggle');
const b = document.querySelector('label.hamburger');
if (t && b) {
  const sync = () =>
    b.setAttribute('aria-expanded', t.checked ? 'true' : 'false');
  t.addEventListener('change', sync);
  sync();
}
