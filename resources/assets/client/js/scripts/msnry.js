import Masonry from 'masonry-layout';

$(document).ready(function() {
  const $grid = document.querySelector('.js-grid');
  
  // If there is no 'grid', just ignore.
  if (!$grid) {
    return;
  }

  new Masonry($grid, {
    itemSelector: '.js-grid-cell',
    percentPosition: true,
    horizontalOrder: true,
  });
});
