// minimal placeholder
(function () {
  var btn = document.getElementById('sdNavToggle');
  var menu = document.getElementById('sd-menu');
  var header = document.querySelector('.sd-site-header');

  if (!btn || !menu || !header) return;

  function openNav() {
    document.documentElement.classList.add('sd-nav-open');
    header.classList.add('is-open');
    btn.setAttribute('aria-expanded', 'true');
  }
  function closeNav() {
    document.documentElement.classList.remove('sd-nav-open');
    header.classList.remove('is-open');
    btn.setAttribute('aria-expanded', 'false');
  }
  function toggleNav() {
    if (document.documentElement.classList.contains('sd-nav-open')) {
      closeNav();
    } else {
      openNav();
    }
  }

  btn.addEventListener('click', toggleNav);

  // Close on Escape
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeNav();
  });

  // Close after tapping a menu link (mobile)
  menu.addEventListener('click', function (e) {
    if (e.target.tagName.toLowerCase() === 'a') closeNav();
  });
})();
