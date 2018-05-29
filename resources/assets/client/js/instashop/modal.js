import moment from 'moment';
import Siema from '../components/siema';
import shop from '../shop';

// Constants.
const ADD_ROUTE = 'http://localhost/eleganza/public/add-to-cart/';
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
let $image;
let $products;
let $desc;
let $date;
let $btns;
let slider;
let state;

/**
 * Sets everything up.
 * 
 * @param {Object} initialState - Initial state.
 * @public
 */
function init(initialState = DEFAULT_STATE) {
  moment.locale('hr');
  $modal = document.querySelector('.js-nv-instashop');
  $image = $modal.querySelector('.js-nv-image');
  $products = $modal.querySelector('.js-nv-products');
  $desc = $modal.querySelector('.js-nv-desc');
  $btnClose = $modal.querySelector('.js-btn-close');
  $date = $modal.querySelector('.js-nv-date');

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
    _renderImage();
    _renderProducts();
    $desc.innerHTML = state.data.desc;
    $date.innerHTML = moment(state.data.created_at).format('LL');
    // Setup Siema.
    slider = new Siema(SLIDER_PARAMS);
    slider.addPagination();
    
    // Then show the modal.
    $modal.classList.add(ACTIVE_CLASS);
    document.body.classList.add(NO_SCROLL_CLASS);

    _addEventListeners();
    return;
  }
  // Hide modal.
  $modal.classList.remove(ACTIVE_CLASS);
  document.body.classList.remove(NO_SCROLL_CLASS);

  // Clean up
  $image.innerHTML = '';
  $products.innerHTML = '';
  $desc.innerHTML = '';
  $date.innerHTML = '';

  // Cleanup after buttons if there are any.
  if ($btns) {
    _removeEventListeners();
  }

  // Destroy slider.
  if (slider) {
    let paggination = $modal.querySelector('.siema-pagination');
    paggination.parentElement.removeChild(paggination)
    slider.destroy();
  }
}

/**
 * Renders image, and appends pins.
 * @private
 */
function _renderImage() {
  const dots = state.data.coordinate;

  $image.style.backgroundImage = `url(${state.data.fullImagePath})`;
  $image.innerHTML = dots.reduce((html, dot) => {
    return html + `
      <a class="nv-pin"
        style="top: ${dot.y}%; left: ${dot.x}%;"
        href="${dot.product.link}">
        <span class="nv-pin_container elevation--z2">
          <span>${dot.order}</span>
          <span class="nv-pin_tooltip elevation--z2">
            prikazi u web trgovini
          </span>
        </span>
      </a>
    `;
  }, '');
}

function _renderProducts() {
  const dots = state.data.coordinate;

  $products.innerHTML = dots.reduce((html, dot) => {
    let p = dot.product;

    return html + `
      <div class="nv-item">
        <a href="${p.link}">
          <figure class="nv-image nv-image--34">
            <img src="${p.fullImagePath}">
          </figure>
        </a>
        <div class="nv-item_details">
          <h2 class="nv-item_name nv-spacer--1">
            <a href="#product-link">${p.title}</a>
          </h2>
          <div class="nv-item_price nv-spacer--1">${p.price_small}</div>
          <button class="nv-btn js-nv-action-btn" data-id=${p.id}>u kosaricu</button>
        </div>
      </div>    
    `;
  }, '');
}

/**
 * Removes all event listeners from buttons.
 */
function _removeEventListeners() {
  Array.from($btns).forEach(($btn) => {
    $btn.removeEventListener('click', _addToCart);
  });
  $btns = [];
}

/**
 * Binds click events on buttons.
 */
function _addEventListeners() {
  $btns = $products.querySelectorAll('.js-nv-action-btn');
  Array.from($btns).forEach(($btn) => {
    $btn.addEventListener('click', _addToCart);
  });
}

/**
 * Add selected item to cart.
 *
 * @param {Event} evt 
 */
function _addToCart(evt) {
  const id = evt.target.dataset.id;
  // Do the post stuff...
  shop.addToCart(id);
  // console.log(id)
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
