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

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.cpf').forEach(el => {
    const input = el.tagName === 'INPUT' ? el : el.querySelector('input');

    if (!input) {
      const divCpf = (el.textContent || '').replace(/\D/g, '');
      if (divCpf.length === 11) {
        el.textContent = divCpf.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
      }
      return;
    }

    const formatCpf = (value) => {
      const digits = value.replace(/\D/g, '').slice(0, 11);
      if (digits.length <= 3) return digits;
      if (digits.length <= 6) return `${digits.slice(0,3)}.${digits.slice(3)}`;
      if (digits.length <= 9) return `${digits.slice(0,3)}.${digits.slice(3,6)}.${digits.slice(6)}`;
      return `${digits.slice(0,3)}.${digits.slice(3,6)}.${digits.slice(6,9)}-${digits.slice(9,11)}`;
    };

    input.addEventListener('input', () => {
      input.value = formatCpf(input.value);
    });

    const form = input.closest('form');
    if (form) {
      form.addEventListener('submit', () => {
        input.value = input.value.replace(/\D/g, ''); 
      });
    }
  });
});