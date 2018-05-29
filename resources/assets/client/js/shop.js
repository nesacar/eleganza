import axios from 'axios';

/**
 * Convinience function for adding product to cart.
 *
 * @param {String|Number} id - Products ID.
 */
function addToCart(id) {
  const route = _getRoute('cart', id);
  const msg = 'proizvod je dodat u košaricu';

  _postRequest(route, msg);
}

/**
 * Convinience function for adding product to wishlist.
 *
 * @param {String|Number} id - Products ID.
 */
function addToWishlist(id) {
  const route = _getRoute('wishlist', id);
  const msg = 'proizvod je dodat u listu želja';
  _postRequest(route, msg);
}

/**
 * Convinience function for posting to passed route.
 *
 * @param {String} route - Route to post to.
 * @param {String} msg - Message to show on sucess.
 */
function _postRequest(route, msg) {
  const _token = document.querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

  axios.post(route, {_token})
    .then((res) => {
      // $().toastmessage('showSuccessToast', msg)
      console.log(res)
    })
    .catch((err) => {
      // $().toastmessage('showErrorToast', 'something went wrong :(');
      console.log(err)
    });
}

/**
 * Convinience function for creating an end-point.
 *
 * @param {String} store - Store to save product to.
 * @param {String|Number} id - Products ID.
 */
function _getRoute(store, id) {
  return `add-to-${store}/${id}`;
}

export default {
  addToCart,
  addToWishlist,
};
