import { French } from "flatpickr/dist/l10n/fr.js";
flatpickr(".flatpickr", { locale: French });

import flatpickr from "flatpickr";
flatpickr("#form_dateCreation", {
  enableTime: true,
  dateFormat: "d/m/Y H:i",
});