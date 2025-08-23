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