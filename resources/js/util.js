import isNumber from 'lodash-es/isNumber';
import groupBy from 'lodash-es/groupBy';
import last from 'lodash-es/last';
import { assertReservationsDoNotExist, assertSeatsExist } from './assertions';

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

export function closestSeatsToMiddle(seats, row, seatCount, adder = 0, restart = false) {
  const lastSeat = last(row);
  const middleSeat = Math.floor(lastSeat.column / 2);

  const start = restart ? 0 : middleSeat - seatCount;

  if (start + seatCount + adder > row.length) {
    closestSeatsToMiddle(seats, row, seatCount, adder, true);

    return;
  }

  const reservation = row.slice(start, start + seatCount);

  try {
    assertReservationsDoNotExist(reservation);
    assertSeatsExist(seats, reservation);

    return reservation;
  } catch (error) {
    console.error(error);
    closestSeatsToMiddle(seats, row, seatCount, adder + 1);
  }
}

export function bestSeats(seats, seatCount, rowCount) {
  const row = groupBy(seats, 'row')[alphabet(Math.floor(rowCount / 2))];

  const middle = closestSeatsToMiddle(seats, row, seatCount);

  console.log({ middle });
}
