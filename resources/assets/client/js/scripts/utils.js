/**
 * Asynchronous forEach.
 *
 * @param {Array} arr
 * @param {Function} cb
 * @param {number} [t=0]
 */
export const forEachAsync = (arr, cb, t=0) => {
  const length = arr.length;
  for (let i = 0; i < length; i++) {
    setTimeout(() => {
      cb(arr[i]);
    }, t);
  }
};
