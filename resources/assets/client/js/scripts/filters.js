import DoubleSlider from '../components/double-slider';
import {forEachAsync} from './utils';

const FORM_ID = 'moja';

$(document).ready(function () {
  const form = document.getElementById(FORM_ID);
  const sliders = Array.from(document.querySelectorAll('[data-is-slider="true"]'))
    .map((el) => new DoubleSlider(el))
    .map(attachEventHandlers);

  window.addEventListener('slider:change', () => {
    form.submit();
  });

  window.addEventListener('slider:layout', () => {
    forEachAsync(sliders, (s) => {
      s.layout();
    }, 300);
  });
});

function attachEventHandlers(slider) {
  const id = slider.root.id;
  const updateSliderLabels = updateSliderLabelsFactory(id);
  updateSliderLabels(slider.value);
  slider.addEventListener('slider:input', () => {
    updateSliderLabels(slider.value);
  });
  return slider;
}

function updateSliderLabelsFactory (id) {
  return value => {
    for (let prop in value) {
      const $labels = $(`[data-for-slider="${id}"][data-label-for="${prop}"]`);

      if ($labels.length < 1) return;

      $labels.each((i, label) => {
        const $label = $(label);

        if ($label.is('input')) {
          $label.val(value[prop]);
        }
        else {
          $label.html(value[prop]);
        }
      });
    }
  }
}
