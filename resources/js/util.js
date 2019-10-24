import isNumber from 'lodash-es/isNumber';

/**
 *
 * @param {number} [index] Index of a letter in the alphabet
 * @param {boolean} [reverse] Reverse the alphabet
 */
export function alphabet(index, reverse = false) {
  const letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

  if (isNumber(index)) {
    return letters[index];
  }

  if (reverse) {
    letters.reverse();
  }

  return letters;
}

export function reverseObject(obj) {
  return Object.keys(obj).sort().reverse().reduce((result, key) => {
    const ref = result;

    ref[key] = obj[key];

    return ref;
  }, {});
}

/**
 *
 * @param {array} seats
 * @param {number} length
 */
export function getMissingSeats(seats, length) {
  return seats
    .slice(0, length)
    .filter((_, index, array) => !array.find((s) => s.column === index))
    .length;
}
