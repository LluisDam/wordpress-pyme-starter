/**
 * Pyme Starter — main.js
 * Handles: sticky header shadow, smooth scroll, AJAX contact form
 */
(function () {
  'use strict';

  // ── Sticky header shadow ──────────────────────────────────────
  const header = document.getElementById('site-header');
  if (header) {
    const onScroll = () => {
      header.classList.toggle('scrolled', window.scrollY > 10);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // ── Smooth scroll for anchor links ───────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (!target) return;
      e.preventDefault();
      const offset = (header ? header.offsetHeight : 0) + 16;
      const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
      window.scrollTo({ top: top, behavior: 'smooth' });
    });
  });

  // ── AJAX Contact Form ─────────────────────────────────────────
  const form   = document.getElementById('pyme-contact-form');
  const status = document.getElementById('form-status');

  if (!form || !status || typeof pymeAjax === 'undefined') return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const submitBtn = form.querySelector('[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Enviando…';
    status.className = 'form-status';
    status.style.display = 'none';
    status.textContent = '';

    const data = new FormData(form);
    data.append('action', 'pyme_contact');
    data.append('nonce',  pymeAjax.nonce);

    fetch(pymeAjax.ajaxurl, {
      method:      'POST',
      credentials: 'same-origin',
      body:        data,
    })
      .then(function (res) {
        if (!res.ok) throw new Error('Network error ' + res.status);
        return res.json();
      })
      .then(function (json) {
        status.textContent = json.data && json.data.message
          ? json.data.message
          : (json.success ? '¡Mensaje enviado!' : 'Error al enviar. Inténtalo de nuevo.');
        status.className = 'form-status ' + (json.success ? 'success' : 'error');
        status.style.display = 'block';
        if (json.success) form.reset();
      })
      .catch(function () {
        status.textContent = 'Error de conexión. Comprueba tu internet e inténtalo de nuevo.';
        status.className   = 'form-status error';
        status.style.display = 'block';
      })
      .finally(function () {
        submitBtn.disabled    = false;
        submitBtn.textContent = originalText;
      });
  });
})();
