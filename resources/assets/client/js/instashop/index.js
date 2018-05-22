import modal from './modal';

const state = {
  products: window.products,
  currentIndex: 0,
}

/**
 * Kicks things off.
 * Sets slider, and stuff...
 */
function init() {
  // Tmp
  modal.init({
    open: true,
    data: state.products[state.currentIndex],
  });
}

window.kurac = function() {
  modal.show(state.products[state.currentIndex]);
}

export default {
  init,
};
