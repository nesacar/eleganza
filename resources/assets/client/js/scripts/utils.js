/**
 * Asynchronous forEach.
 *
 * @param {Array} arr
 * @param {Function} cb
 */
export const forEachAsync = (arr, cb) => {
  const length = arr.length;
  for (let i = 0; i < length; i++) {
    setTimeout(() => {
      cb(arr[i]);
    }, 0);
  }
};
