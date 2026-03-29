import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
  document.addEventListener('click', (e) => {
    const buttonDelete = e.target.closest('.button-delete');
    if (!buttonDelete) return;

    e.preventDefault();
    e.stopPropagation();

    const message = buttonDelete.dataset.confirmMessage || buttonDelete.getAttribute('data-confirm-message') || 'Confirmar?';
    if (!confirm(message)) return;

    const form = buttonDelete.closest('form');
    if (form) form.submit();
  });
});

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.js-toggle-password').forEach(btn => {
    btn.addEventListener('click', () => {
      const form = btn.closest('form');
      if (!form) return;

      let input = btn.closest('.col-md-6')?.querySelector('input[type="password"], input[type="text"]') || null;
      if (!input) {
        input = form.querySelector('input[type="password"], input[type="text"]');
      }
      if (!input) return;

      if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🐵';
      } else {
        input.type = 'password';
        btn.textContent = '🙈';
      }
    });
  });
});