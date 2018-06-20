import DoubleSlider from 'double-slider';

const color = '#000';

$(document).ready(function () {
  const sliders = {};
  const $sliderHosts = $('[data-is-slider="true"]');

  if ($sliderHosts.length < 1) return;

  $sliderHosts.each((i, sliderHost) => {
    const id = sliderHost.id;
    const updateSliderLabels = updateSliderLabelsFactory(id);

    const initialValue = {
      min: parseInt(sliderHost.getAttribute('data-min-value'), 10),
      max: parseInt(sliderHost.getAttribute('data-max-value'), 10),
      range: parseInt(sliderHost.getAttribute('data-value-range'), 10)
    };

    sliders[id] = new DoubleSlider({
      id,
      color,
      onEnd: updateSliderLabels
    });

    sliders[id].value = initialValue;
    updateSliderLabels(initialValue);
  });
});

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
