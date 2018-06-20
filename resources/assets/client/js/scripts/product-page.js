import Drift from 'drift-zoom';

$(document).ready(function () {
  const $images = $('[data-zoom]');
  const $paneContainer = $('#jsPaneContainer');

  if ($images.length < 1 || $paneContainer.length < 1) return;

  $images.each((i, image) => {
    new Drift(image, {
      zoomFactor: 2,
      paneContainer: $paneContainer[0]
    });
  });
});

$(document).ready(function () {
  const $imageBox = $('#jsImageBox');

  if ($imageBox.length < 1) return;

  $imageBox.owlCarousel({
    items: 1,
    thumbs: true,
    thumbsPrerendered: true,
    mouseDrag: false,
    touchDrag: false
  });
});
