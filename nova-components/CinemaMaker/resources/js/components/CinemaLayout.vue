<template>
  <section class="relative container mx-0 p-4 bg-gray-900 rounded">
    <div class="my-2 row-tight justify-center">
      <div class="col w-full">
        <h3 class="text-center text-2xl text-white">
          {{ trans('cinema.columns') }}
          <span class="text-gray-500">({{ columns + 1 }})</span>
        </h3>
      </div>
      <div class="col">
        <button type="button" class="py-1 px-5 bg-gray-800 text-2xl text-white" @click="setWidth(columns - 1)">-</button>
      </div>
      <div class="col">
        <button type="button" class="py-1 px-5 bg-gray-800 text-2xl text-white" @click="setWidth(columns + 1)">+</button>
      </div>
    </div>
    <div class="my-2 row-tight justify-center">
      <div class="col w-full">
        <h3 class="text-center text-2xl text-white">
          {{ trans('cinema.rows') }}
          <span class="text-gray-500">({{ rows + 1 }})</span>
        </h3>
      </div>
      <div class="col">
        <button type="button" class="py-1 px-5 bg-gray-800 text-2xl text-white" @click="setHeight(rows - 1)">-</button>
      </div>
      <div class="col">
        <button type="button" class="py-1 px-5 bg-gray-800 text-2xl text-white" @click="setHeight(rows + 1)">+</button>
      </div>
    </div>
    <table class="my-8 mx-auto">
      <thead>
        <tr>
          <th></th>
          <th
            class="pb-1 text-gray-600 font-bold text-sm"
            v-for="(seat, index) in singleRow"
            :key="index"
          >
            <button type="button" @click="setWidth(index)">{{ seat.column + 1 }}</button>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, letter) in cinemaRows" :key="letter">
          <td class="text-gray-600 font-bold text-sm text-center">
            <button type="button" @click="setHeight(alphabetIndex(letter))">{{ letter.toUpperCase() }}</button>
          </td>
          <td class="py-1" v-for="(seat, index) in row" :key="index">
            <button
              @click.prevent="toggleSeat(seat)"
              class="w-full h-full flex justify-center"
              :class="[
                (findSeat(seat).selected && 'text-red-600 hover:text-red-700')
                ||
                (findSeat(seat).disability && 'text-blue-500 hover:text-blue-600')
                ||
                'text-green-600 hover:text-green-700'
              ]"
              :disabled="disabled"
              :ref="`seat-${seat.rowIndex}-${seat.column}`"
              @focus="focusedBtn = seat"
              @blur="focusedBtn = null"
            >
              <svg width="20" class="fill-current" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="20" height="20" rx="7"/>
              </svg>
            </button>
            <input
              v-if="!inputsDisabled"
              type="hidden"
              :name="`seats[${seat.row}][${seat.column}]`"
              :value="findSeat(seat).selected"
            />
          </td>
          <td class="text-gray-600 font-bold text-sm text-center">
            <button type="button" @click="setHeight(alphabetIndex(letter))">{{ letter.toUpperCase() }}</button>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th></th>
          <td
            class="pb-1 text-gray-600 font-bold text-sm"
            v-for="(seat, index) in singleRow"
            :key="index"
          >
            <button type="button" @click="setWidth(index)">{{ seat.column + 1 }}</button>
          </td>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </section>
</template>

<script>
import groupBy from 'lodash-es/groupBy';
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

/**
 * @param {string} letter
 */
function alphabetIndex(letter) {
  const letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

  return letters.indexOf(letter);
}

export function reverseObject(obj) {
  return Object.keys(obj).sort().reverse().reduce((result, key) => {
    const ref = result;

    ref[key] = obj[key];

    return ref;
  }, {});
}

export default {
  props: {
    cinemaSeats: {
      type: Array,
      required: true,
    },
  },
  data: (vm) => ({
    seats: JSON.parse(vm.cinemaSeats),
    rows: JSON.parse(vm.cinemaSeats).reduce((value, seat) => (alphabetIndex(seat.row) >= value ? alphabetIndex(seat.row) : value), 0),
    columns: JSON.parse(vm.cinemaSeats).reduce((value, seat) => (seat.column >= value ? seat.column : value), 0),
    alphabetIndex,
  }),
  methods: {
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
      const ref = this.findSeat(seat);

      ref.selected = ref.selected ? 0 : 1;
    },
    findSeat({ row, column }) {
      return this.seats.find((seat) => seat.row === row && seat.column === column);
    },
    async getCinemaWidth() {
      await this.$nextTick();

      const el = this.$refs.cinema;
      const rect = el.getBoundingClientRect();

      return `${Math.ceil(rect.width * 1.15)}px`;
    },
    setHeight(index) {
      this.rows = index;

      this.generateSeats();
    },
    setWidth(index) {
      this.columns = index;

      this.generateSeats();
    },
    generateSeats() {
      const seats = [];

      for (let rowIndex = 0; rowIndex <= this.rows; rowIndex++) {
        const row = alphabet(rowIndex, true);

        for (let column = 0; column <= this.columns; column++) {
          if (this.findSeat({ row: rowIndex, column })) {
            seats.push(this.findSeat({ row: rowIndex, column }));
          } else {
            seats.push({
              rowIndex,
              row,
              column,
              selected: 0,
              disability: 0,
            });
          }
        }
      }

      this.seats = seats;

      return seats;
    },
  },
  watch: {
    seats: {
      deep: true,
      handler(value) {
        this.$emit('updatedSeats', value);
      },
    },
  },
  computed: {
    cinemaRows() {
      return reverseObject(groupBy(this.seats, 'row'));
    },
    singleRow() {
      return Object.values(this.cinemaRows).find(() => true);
    },
  },
};
</script>
