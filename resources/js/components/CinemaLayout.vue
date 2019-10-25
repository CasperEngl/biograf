<template>
  <section class="relative container p-4 bg-gray-900">
    <h3 class="text-xl text-center py-4" v-if="cinema.name">{{ cinema.name }}</h3>
    <span
      v-html="svg('screen')"
      class="block mx-auto text-red-700"
      :style="{
        maxWidth: `${cinemaWidth * 1.15}px`,
        // color: `${showing.film.colors && showing.film.colors.pop()}` || false,
      }"
    ></span>
    <table class="my-8 mx-auto" ref="cinema">
      <col width="35" />
      <col width="30" v-for="(seat, index) in singleRow" :key="index" />
      <thead>
        <tr>
          <th></th>
          <th
            class="pb-1 text-gray-600 font-bold text-sm"
            v-for="(seat, index) in singleRow"
            :key="index"
          >{{ seat.column + 1 }}</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, letter) in cinemaRows" :key="letter">
          <td class="text-gray-600 font-bold text-sm text-center">{{ letter.toUpperCase() }}</td>
          <td class="py-1" v-for="(seat, index) in row" :key="index">
            <template v-if="findSeat(seat)">
              <button
                @click.prevent="selectSeat(seat)"
                class="w-full h-full flex justify-center"
                :class="[
                  (findSeat(seat).selected && findSeat(seat).currentReserver && 'text-green-700 hover:text-green-800')
                  ||
                  (findSeat(seat).currentReserver && 'text-green-600 hover:text-green-700')
                  ||
                  (findSeat(seat).reservation && 'text-red-600 hover:text-red-700')
                  ||
                  (findSeat(seat).selected && 'text-green-600 hover:text-green-700')
                  ||
                  (findSeat(seat).disability && 'text-blue-500 hover:text-blue-600')
                  ||
                  'text-gray-700 hover:text-gray-800'
                ]"
                :disabled="disabled"
                :ref="`seat-${seat.rowIndex}-${seat.column}`"
                @focus="focusedBtn = seat"
                @blur="focusedBtn = null"
                v-html="svg('seat')"
              >&nbsp;</button>
            </template>
          </td>
          <td class="text-gray-600 font-bold text-sm text-center">{{ letter.toUpperCase() }}</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th></th>
          <td
            class="pb-1 text-gray-600 font-bold text-sm"
            v-for="(seat, index) in singleRow"
            :key="index"
          >{{ seat.column + 1 }}</td>
          <th></th>
        </tr>
      </tfoot>
    </table>
    <cinema-seat-explainer class="mx-auto" :style="{
      maxWidth: `${cinemaWidth * 1.15}px`,
    }"></cinema-seat-explainer>
  </section>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import groupBy from 'lodash-es/groupBy';

import { reverseObject, alphabet, getMissingSeats } from '../util';

import {
  assertTicketAndSeatCountEqual,
  assertReservationsDoNotExist,
} from '../assertions';

export default {
  props: {
    showing: {
      type: Object,
      required: true,
    },
    cinema: {
      type: Object,
      required: true,
    },
    reserverId: {
      type: String,
      required: true,
    },
    disabled: {
      type: Boolean,
      required: false,
      default: true,
    },
    inputsDisabled: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  created() {
    window.addEventListener('keydown', this.keyController);

    this.channel.listen('.reservation-updated', async (data) => {
      try {
        const response = await axios({
          method: 'GET',
          url: route('api.showing', data.showing_id),
        });

        this.seats = this.transformSeats(response.data.cinema.seats);

        const { cinema } = response.data;
        console.log({
          cinema,
        });
      } catch (error) {
        console.error(error);
      }
    });
  },
  destroyed() {
    window.removeEventListener('keydown', this.keyController);
  },
  data: (vm) => ({
    seatmaxWidth: 0,
    rows: vm.cinema.row_count,
    columns: vm.cinema.column_count,
    seats: vm.transformSeats(vm.cinema.seats),
    focusedBtn: null,
    channel: Echo.channel(`showing-${vm.showing.id}`),
  }),
  methods: {
    arrowKeyHandler(event, row, column) {
      event.preventDefault();

      if (this.focusedBtn.column + column === -1 || this.focusedBtn.column + column === this.columns) {
        return;
      }

      if (this.focusedBtn.rowIndex + row === -1 || this.focusedBtn.rowIndex + row === this.rows) {
        return;
      }

      const search = `seat-${this.focusedBtn.rowIndex + row}-${this.focusedBtn.column + column}`;

      if (this.$refs[search]) {
        const [btn] = this.$refs[search];

        btn.focus();
      } else {
        if (row < 0) {
          this.arrowKeyHandler(event, row + -1, column);
        }
        if (row > 0) {
          this.arrowKeyHandler(event, row + 1, column);
        }
        if (column < 0) {
          this.arrowKeyHandler(event, row, column + -1);
        }
        if (column > 0) {
          this.arrowKeyHandler(event, row, column + 1);
        }
      }
    },
    keyController(event) {
      if (event.key === 'ArrowDown') {
        this.arrowKeyHandler(event, -1, 0);
      }
      if (event.key === 'ArrowUp') {
        this.arrowKeyHandler(event, 1, 0);
      }
      if (event.key === 'ArrowLeft') {
        this.arrowKeyHandler(event, 0, -1);
      }
      if (event.key === 'ArrowRight') {
        this.arrowKeyHandler(event, 0, 1);
      }
    },
    seatColor(seat) {
      const s = this.findSeat(seat);

      switch (true) {
        case s.selected && s.currentReserver:
          return 'text-green-600 hover:text-green-700';
        case s.currentReserver:
          return 'text-yellow-600 hover:text-yellow-700';
        case s.reservation:
          return 'text-red-600 hover:text-red-700';
        case s.selected:
          return 'text-green-600 hover:text-green-700';
        case s.disability:
          return 'text-blue-500 hover:text-blue-600';

        default:
          return 'text-gray-700 hover:text-gray-800';
      }
    },
    toggleSeat(seat) {
      const ref = seat;

      ref.selected = seat.selected ? 0 : 1;
    },
    findSeat({ row, column }) {
      return this.seats.find((seat) => seat.row === row && seat.column === column);
    },
    async selectSeat({ row, column }) {
      const { ticketsCount } = this.$store.getters;

      this.seats.forEach((seat) => seat.selected = 0);

      // Get the actual row
      let seats = groupBy(this.seats, 'row')[row];
      // Get offset for deleted seats
      const columnOffset = column - getMissingSeats(seats, column);

      // Apply mutation with column offset
      seats = seats.slice(
        columnOffset,
        columnOffset + ticketsCount,
      );

      try {
        assertTicketAndSeatCountEqual(ticketsCount, seats.length);
        assertReservationsDoNotExist(seats);

        // Set selected seats determined by column offset
        seats.forEach((seat) => seat.selected = Number(!seat.selected));

        const data = {
          email: this.email,
          seats: seats.filter((seat) => seat.selected),
          ticket_count: {
            regular: this.$store.getters.regularCount,
            senior: this.$store.getters.seniorCount,
          },
        };

        try {
          await axios({
            method: 'POST',
            url: route('reservation.store', this.showing.id),
            data,
          });
        } catch (error) {
          console.error(error);
        }

        this.$forceUpdate();
      } catch (error) {
        Swal.fire({
          title: error.message,
        });
      }
    },
    transformSeats(seats) {
      return seats.map((seat) => ({
        ...seat,
        currentReserver: seat.reservation && seat.reservation.reserver_id === this.reserverId,
      }));
    },
  },
  computed: {
    singleRow() {
      return Object.values(this.cinemaRows).find(() => true);
    },
    cinemaRows() {
      const rows = [];

      for (let rowIndex = 0; rowIndex < this.rows; rowIndex++) {
        const row = alphabet(rowIndex, true);

        for (let column = 0; column < this.columns; column++) {
          rows.push({
            rowIndex,
            row,
            column,
          });
        }
      }

      return reverseObject(groupBy(rows, 'row'));
    },
  },
  asyncComputed: {
    async cinemaWidth() {
      await this.$nextTick();

      const el = this.$refs.cinema;
      const rect = el.getBoundingClientRect();

      return rect.width;
    },
  },
};
</script>
