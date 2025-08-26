/* FAQ toggle
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
});*/

import flatpickr from "flatpickr";
import { French } from "flatpickr/dist/l10n/fr.js";

document.addEventListener("DOMContentLoaded", () => {
  flatpickr(".flatpickr", {
    enableTime: true,
    dateFormat: "d/m/Y H:i",
    locale: French,
  });

  flatpickr(".flatpickr", {
    enableTime: true,
    dateFormat: "d/m/Y H:i",
    time_24hr: true,
    locale: "fr"
  });
});
