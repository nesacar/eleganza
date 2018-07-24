import DoubleSlider from '../components/double-slider';
import {forEachAsync} from './utils';

$(document).ready(function () {
  const sliders = Array.from(document.querySelectorAll('[data-is-slider="true"]'))
    .map((el) => new DoubleSlider(el))
    .map(attachEventHandlers);

  window.addEventListener('slider:layout', () => {
    forEachAsync(sliders, (s) => {
      s.layout();
    });
  });
});

function attachEventHandlers(slider) {
  const id = slider.root.id;
  const updateSliderLabels = updateSliderLabelsFactory(id);
  updateSliderLabels(slider.value);
  slider.addEventListener('slider:change', () => {
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
