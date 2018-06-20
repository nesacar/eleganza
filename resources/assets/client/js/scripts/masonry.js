(function () {
  let $grid;
  let $items;
  let resizeTimer;

  // Kick things off!
  init();

  function init() {
    $grid = document.querySelector('.js-v-grid');

    // No grid, no fun!
    if (!$grid) {
      return;
    }

    $items = $grid.querySelectorAll('.js-v-grid-item');

    window.addEventListener('load', resizeAllGridItems, { once: true });
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        resizeAllGridItems();
      }, 250);
    });
  }

  function resizeGridItem(item) {
    const rowHeight = parseInt(window.getComputedStyle($grid)
      .getPropertyValue('grid-auto-rows'));
    const rowGap = parseInt(window.getComputedStyle($grid)
      .getPropertyValue('grid-row-gap'));
    const rowSpan = Math.ceil((item.querySelector('.js-v-grid-item_content')
      .getBoundingClientRect().height + rowGap) / (rowHeight + rowGap));
    item.style.gridRowEnd = `span ${rowSpan}`;
  }

  function resizeAllGridItems() {
    Array.from($items).forEach(resizeGridItem);
  }
}());
