document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('ajax-form');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(form);
    fetch('/contact/ajax', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(data => {
      document.getElementById('form-response').innerHTML = data;
    });
  });
});
console.log('contact.js actif');
