export function assertTicketAndSeatCountEqual(ticketCount, seatCount) {
  if (ticketCount !== seatCount) {
    throw new Error('Billet og sæde antal er ikke det samme');
  }
}

export function assertReservationsDoNotExist(seats) {
  if (seats.some((seat) => seat.reservation && !seat.currentReserver)) {
    throw new Error('Et af de valgte sæder er allerede reserveret');
  }
}

/**
 *
 * @param {array} seats
 * @param {array} reservation
 */
export function assertSeatsExist(seats, reservation) {
  if (!reservation.every((seat) => seats.includes(seat))) {
    throw new Error('A seat does not exist');
  }
}
