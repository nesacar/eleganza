import modal from './modal';

/**
 * Kicks things off.
 * Sets slider, and stuff...
 */
function init() {
  modal.init({
    open: true,
    data: 'hello',
  });
}

export default {
  init,
};
