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
