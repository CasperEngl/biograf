<template>
  <section class="relative container p-4 bg-gray-900">
    <h3 class="text-xl text-center py-4" v-if="cinema.name">{{ cinema.name }}</h3>
    <span
      v-html="svg('screen', 'block mx-auto text-red-700')"
      class="block mx-auto"
      :style="{
        maxWidth: `${cinemaWidth * 1.15}px`,
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
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, letter) in cinemaRows" :key="letter">
          <td
            class="text-gray-600 font-bold text-sm text-center"
          >{{ letter.toUpperCase() }}</td>
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
        </tr>
      </tbody>
    </table>
    <cinema-seat-explainer class="mx-auto" :style="{
      maxWidth: `${cinemaWidth * 1.15}px`,
    }"></cinema-seat-explainer>
  </section>
</template>

<script>
import groupBy from 'lodash-es/groupBy';

import { reverseObject } from '../util';

export default {
  props: {
    cinema: {
      type: Object,
      required: true,
    },
    seats: {
      type: Array,
      required: false,
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
    console.log(this.seats);
  },
  data: (vm) => ({
    seatmaxWidth: 0,
    rows: vm.cinema.row_count,
    columns: vm.cinema.column_count,
    alphabet: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'],
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
      const refs = [];

      Array.from(Array(this.$store.getters.ticketsCount)).forEach((_, i) => {
        for (const s of this.seats) { // eslint-disable-line
          s.selected = 0;

          if (s.row === row && s.column === column + i) {
            refs.push(s);
          }
        }
      });

      refs.forEach((ref) => {
        ref.selected = ref.selected ? 0 : 1;
      });

      this.$forceUpdate();
    },
  },
  computed: {
    singleRow() {
      return Object.values(this.cinemaRows).find(() => true);
    },
    cinemaRows() {
      const rows = [];

      for (let rowIndex = 0; rowIndex < this.rows; rowIndex++) {
        const row = this.alphabet[rowIndex];

        for (let column = 0; column < this.columns; column++) {
          rows.push({
            row,
            column,
          });
        }
      }

      const ordered = reverseObject(groupBy(rows, 'row'));

      return ordered;
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
