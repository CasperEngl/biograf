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
            ref="seat"
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
                  (findSeat(seat).reservation && 'text-red-600 hover:text-red-700')
                  ||
                  (findSeat(seat).selected && 'text-green-600 hover:text-green-700')
                  ||
                  (findSeat(seat).disability && 'text-blue-500 hover:text-blue-600')
                  ||
                  'text-gray-700 hover:text-gray-800'
                ]"
                :disabled="disabled"
                v-html="svg('seat')"
              >&nbsp;</button>
              <input
                v-if="!inputsDisabled"
                type="hidden"
                :name="`seats[${seat.row}][${seat.column}]`"
                :value="findSeat(seat).selected"
              />
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
            ref="seat"
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
import Swal from 'sweetalert2';
import groupBy from 'lodash-es/groupBy';

import { reverseObject, alphabet, bestSeats } from '../util';

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
    console.log(this.showing);
  },
  data: (vm) => ({
    seatmaxWidth: 0,
    rows: vm.cinema.row_count,
    columns: vm.cinema.column_count,
    seats: vm.cinema.seats,
  }),
  methods: {
    toggleSeat(seat) {
      const ref = seat;

      ref.selected = seat.selected ? 0 : 1;
    },
    findSeat({ row, column }) {
      return this.seats.find((seat) => seat.row === row && seat.column === column);
    },
    selectSeat({ row, column }) {
      const { ticketsCount } = this.$store.getters;

      this.seats.forEach((seat) => seat.selected = 0);

      // Get the actual row
      let seats = groupBy(this.seats, 'row')[row];
      // Get offset for deleted seats
      // Half of ticketsCount is used to determine middle seat, so we can select adjacent seats
      const columnOffset = column + (seats.length - this.columns);

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

        this.$forceUpdate();
      } catch (error) {
        Swal.fire({
          title: error.message,
        });
      }
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
