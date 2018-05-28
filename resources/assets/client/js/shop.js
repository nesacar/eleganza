import axios from 'axios';

const shop = (function() {
  let _token;
  let _url;
  let options;

  window.addEventListener('load', function() {
    _init();
  });

  function _init() {
    _token = window._token;
    _url = window._url;
    options = {
      _token,
    };
  }

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
    axios.post(route, options)
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
    return `${window._url}/add-to-${store}/${id}`;
  }

  return {
    addToCart,
    addToWishlist,
  };
}());

export default shop;
