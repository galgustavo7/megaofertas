/* MegaOfertas — storefront JS */
(function () {
    'use strict';

    // ── Menú móvil (hamburguesa) ──
    var navToggle = document.getElementById('navToggle');
    var mainNav = document.getElementById('mainNav');

    if (navToggle && mainNav) {
        navToggle.addEventListener('click', function () {
            var open = mainNav.classList.toggle('open');
            navToggle.classList.toggle('open', open);
            navToggle.setAttribute('aria-expanded', String(open));
        });
    }

    // ── Dropdown de categorías (toque en móvil) ──
    var dropdowns = document.querySelectorAll('.nav-dropdown > a');
    dropdowns.forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                link.parentElement.classList.toggle('open');
            }
        });
    });

    // ── Carrusel de destacados ──
    document.querySelectorAll('[data-carousel]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var track = document.getElementById('carousel-' + btn.dataset.carousel);
            if (!track) return;
            var card = track.querySelector('.carousel-item');
            var step = card ? card.offsetWidth + 18 : 280;
            track.scrollBy({ left: step * parseInt(btn.dataset.dir, 10), behavior: 'smooth' });
        });
    });

    // ── Filtros en off-canvas (móvil) ──
    var sidebar = document.getElementById('storeSidebar');
    var sbOpen = document.getElementById('sbOpen');
    var sbClose = document.getElementById('sbClose');

    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (sbOpen && sidebar) {
        sbOpen.addEventListener('click', function () {
            sidebar.classList.add('open');
            document.body.style.overflow = 'hidden';
        });
    }
    if (sbClose) sbClose.addEventListener('click', closeSidebar);
    if (sidebar) {
        sidebar.addEventListener('click', function (e) {
            if (e.target === sidebar) closeSidebar();
        });
    }

    // ── Sidebar admin (móvil) ──
    var adminSbToggle = document.getElementById('adminSbToggle');
    var adminSidebar = document.getElementById('adminSidebar');
    if (adminSbToggle && adminSidebar) {
        adminSbToggle.addEventListener('click', function () {
            adminSidebar.classList.toggle('open');
        });
    }

    // ── Confirmaciones de borrado ──
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!window.confirm(form.dataset.confirm)) e.preventDefault();
        });
    });

    // ── Newsletter (demo) ──
    var nlForm = document.getElementById('newsletterForm');
    if (nlForm) {
        nlForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var input = nlForm.querySelector('input');
            var btn = nlForm.querySelector('button');
            btn.textContent = '¡Listo! ✓';
            btn.disabled = true;
            input.value = '';
            setTimeout(function () {
                btn.textContent = 'Suscribirme';
                btn.disabled = false;
            }, 3000);
        });
    }

    // ── Form de categorías (admin): crear/editar dinámico ──
    var catForm = document.getElementById('catForm');
    if (catForm) {
        var base = catForm.getAttribute('action');
        document.querySelectorAll('[data-edit-cat]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                catForm.setAttribute('action', btn.dataset.updateUrl || base);
                document.getElementById('catMethod').value = 'PUT';
                document.getElementById('catName').value = btn.dataset.name;
                document.getElementById('catEmoji').value = btn.dataset.emoji;
                document.getElementById('catFrom').value = btn.dataset.from;
                document.getElementById('catTo').value = btn.dataset.to;
                document.getElementById('catDesc').value = btn.dataset.desc;
                document.getElementById('catFormTitle').textContent = 'Editar: ' + btn.dataset.name;
                document.getElementById('catSubmit').textContent = '💾 Guardar cambios';
                catForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });

        var resetBtn = document.getElementById('catReset');
        resetBtn.addEventListener('click', function () {
            catForm.setAttribute('action', base);
            document.getElementById('catMethod').value = 'POST';
            catForm.reset();
            document.getElementById('catMethod').value = 'POST';
            document.getElementById('catEmoji').value = '📦';
            document.getElementById('catFrom').value = '#6366F1';
            document.getElementById('catTo').value = '#8B5CF6';
            document.getElementById('catFormTitle').textContent = 'Nueva categoría';
            document.getElementById('catSubmit').textContent = '💾 Guardar categoría';
        });
    }

    // ── Scroll suave para anclas internas ──
    document.querySelectorAll('a[href="#top"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
})();
