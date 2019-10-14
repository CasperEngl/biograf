import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    seats: [],
    tickets: {
      regular: {
        count: 0,
        price: 0,
      },
      senior: {
        count: 0,
        price: 0,
      },
    },
  },
  mutations: {
    changeTicketCount(state, count) {
      state.tickets[count.type].count = count.value;
    },
    changeTicketPrice(state, price) {
      state.tickets[price.type].price = price.value;
    },
    changeSeats(state, seats) {
      state.seats = seats;
    },
    selectSeat(state, { row, column }) {
      state.seats.find((s) => s.row === row && s.column === column);
    },
  },
  getters: {
    regularCount: (state) => parseInt(state.tickets.regular.count, 10),
    seniorCount: (state) => parseInt(state.tickets.senior.count, 10),

    regularPrice: (state) => parseInt(state.tickets.regular.price, 10),
    seniorPrice: (state) => parseInt(state.tickets.senior.price, 10),

    ticketsCount: (_, getters) => parseInt(getters.regularCount + getters.seniorCount, 10),
    ticketsPrice: (_, getters) => parseInt((getters.regularCount * getters.regularPrice) + (getters.seniorCount * getters.seniorPrice), 10),
  },
});
