import Siema from '../components/siema';

function init() {
  const slider = new Siema({
    perPage: 3,
  });
  slider.addPagination();
}

export default {
  init,
};
