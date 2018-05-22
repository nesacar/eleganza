import modal from './modal';

let state = {
  products: window.products,
  currentIndex: 0,
};

let $images;

/**
 * Kicks things off.
 * Sets slider, and stuff...
 */
function init() {
  $images = document.querySelectorAll('.instashop-thumbnail');
  $images.forEach(($image, index) => {
    $image.addEventListener('click', (evt) => {
      // TODO: Use ID instead of index
      _setCurrentIndex(index);
    });
  });
  // Tmp
  modal.init({
    data: state.products[state.currentIndex],
  });
}

/**
 * Sets the current index of the image.
 *
 * @param {Number|String} i - Index of the image to render.
 */
function _setCurrentIndex(i) {
  const l = state.products.length;
  let index;

  // Keep it looping
  if (i >= l) {
    index = 0;
  } else if (i < 0) {
    index = l - 1;
  }

  _setState({
    currentIndex: index,
  });
}

/**
 * Calls show method on modal.
 */
function _render() {
  modal.show(state.products[state.currentIndex]);
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
