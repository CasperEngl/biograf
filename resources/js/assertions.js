export function assertTicketAndSeatCountEqual(ticketCount, seatCount) {
  if (ticketCount !== seatCount) {
    throw new Error('Billet og sæde antal er ikke det samme');
  }
}

export function assertReservationsDoNotExist(seats) {
  for (const seat of seats) {
    if (seat.reservation) {
      throw new Error('Et af de valgte sæder er allerede reserveret');
    }
  }
}
