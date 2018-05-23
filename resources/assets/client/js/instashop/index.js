import modal from './modal';

let state = {
  products: window.products,
  currentID: 0,
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
      const id = $image.dataset.id;
      // TODO: Use ID instead of index
      _setCurrentID(parseInt(id));
    });
  });
  // Tmp
  modal.init({
    data: state.products[state.currentID],
  });
}

/**
 * Sets the current id of the image.
 *
 * @param {Number|String} id - ID of the image to render.
 */
function _setCurrentID(id) {
  _setState({
    currentID: id,
  });
}

/**
 * Calls show method on modal.
 */
function _render() {
  const data = state.products.find((el) => {
    return el.id === state.currentID;
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
