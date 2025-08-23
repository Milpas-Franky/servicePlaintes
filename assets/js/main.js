// FAQ toggle
document.querySelectorAll('.faq-item h3').forEach(header => {
  header.addEventListener('click', () => {
    const item = header.closest('.faq-item');
    item.classList.toggle('faq-active');
  });
});

// AOS init
AOS.init({
  duration: 800,
  once: true
});

<script>
  flatpickr(".flatpickr", {
    enableTime: true,
    dateFormat: "d/m/Y H:i",
    time_24hr: true,
    locale: "fr"
  });
</script>