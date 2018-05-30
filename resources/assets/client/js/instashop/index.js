import modal from './modal';

let state = {
  products: window.products,
  currentIndex: 0,
};

let $images;
let $btnNext;
let $btnPrev;

/**
 * Kicks things off.
 * Sets slider, and stuff...
 */
function init() {
  $btnNext = document.querySelector('.js-nv-next');
  $btnPrev = document.querySelector('.js-nv-prev');
  $btnNext.addEventListener('click', next);
  $btnPrev.addEventListener('click', prev);
  $images = document.querySelectorAll('.instashop-thumbnail');
  $images.forEach(($image, index) => {
    $image.addEventListener('click', (evt) => {
      const index = Array.from($images).indexOf($image);

      // TODO: Create API for setting index.
      _setState({
        currentIndex: index,
      });
    });
  });
  // Tmp
  modal.init();
}

/**
 * Sets the image with the matching index as active.
 *
 * @param {Number} index - Index of the image to set as acitve
 */
function goTo(index) {
  const l = $images.length;
  let currentIndex = index;

  if (index < 0) {
    currentIndex = l - 1;
  } else if (index >= l) {
    currentIndex = 0;
  }

  _setState({
    currentIndex,
  });
}

/**
 * Sets next image as active.
 */
function next() {
  goTo(state.currentIndex + 1);
}

/**
 * Sets prev image as active.
 */
function prev() {
  goTo(state.currentIndex - 1);
}

/**
 * Calls show method on modal.
 */
function _render() {
  const img = $images[state.currentIndex];
  const id = parseInt(img.dataset.id);

  const data = state.products.find((el) => {
    return el.id === id;
  })
  modal.show(data);
}

/**
 * Updates current state and calls render with the new one.
 *
 * @param {Object} partialState - State update.
 */
function _setState(partialState) {
  state = Object.assign({}, state, partialState);
  _render();
}

export default {
  init,
};
