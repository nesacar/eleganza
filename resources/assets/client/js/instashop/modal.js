import Siema from '../components/siema';

// Constants.
const ACTIVE_CLASS = 'active';
const NO_SCROLL_CLASS = 'no-scroll';
const DEFAULT_STATE = {
  open: false,
  data: null,
};
const SLIDER_PARAMS = {
  perPage: 3,
};

let $modal;
let $btnClose;
let slider;
let state;

/**
 * Sets everything up.
 * 
 * @param {Object} initialState - Initial state.
 * @public
 */
function init(initialState = DEFAULT_STATE) {
  $modal = document.querySelector('.js-nv-instashop');
  $btnClose = $modal.querySelector('.js-btn-close');

  $btnClose.addEventListener('click', _hide);

  _setState(initialState);
}

/**
 * Opens the modal and renders the data.
 *
 * @param {any} data - Data to render.
 * @public
 */
function show(data) {
  // Not sure about data format, yet.
  _setState({
    open: true,
    data,
  });
}

/**
 * Updates the state, and calls render.
 *
 * @param {Object} partialState - Update to the state.
 * @private
 */
function _setState(partialState) {
  state = Object.assign({}, state, partialState);
  _render();
}

/**
 * Updates the UI layer.
 * @private
 */
function _render() {
  if (state.open && state.data) {
    // Replace all the data.
    // Setup Siema.
    slider = new Siema(SLIDER_PARAMS);
    slider.addPagination();
    
    // Then show the modal.
    $modal.classList.add(ACTIVE_CLASS);
    document.body.classList.add(NO_SCROLL_CLASS);
    return;
  }
  // Hide modal.
  $modal.classList.remove(ACTIVE_CLASS);
  document.body.classList.remove(NO_SCROLL_CLASS);

  // Destroy slider and cleanup.
  if (slider) {
    slider.destroy();
  }
}

/**
 * Convinience function for hiding the modal.
 * Sets the state to it's default value.
 * @private
 */
function _hide() {
  _setState(DEFAULT_STATE);
}

export default {
  init,
  show,
};
