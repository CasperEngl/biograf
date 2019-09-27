<template>
  <section>
    <div class="row mb-4">
      <div class="col w-full">
        <label for="name">
          <span class="block text-gray-700 text-sm font-bold mb-2">Navn</span>
          <input type="text" class="field" v-model="name">
        </label>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col w-1/2">
        <label for="rows">
          <span class="block text-gray-700 text-sm font-bold mb-2">Rækker</span>
          <select class="field" name="rows" id="rows" v-model.number="rowCount">
            <option :value="option" v-for="option in 20" :key="option">{{ option }}</option>
          </select>
        </label>
      </div>
      <div class="col w-1/2">
        <label for="columns">
          <span class="block text-gray-700 text-sm font-bold mb-2">Kolonner</span>
          <select class="field" name="columns" id="columns" v-model.number="columnCount">
            <option :value="option" v-for="option in 20" :key="option">{{ option }}</option>
          </select>
        </label>
      </div>
    </div>
    <cinema-layout :cinema-name="name" :cinema-rows="rows" :disabled="false" :inputs-disabled="false"></cinema-layout>
    <button type="submit" class="btn btn-primary mt-4" @click="() => submitting = true">Opret biograf</button>
  </section>
</template>

<script>
import groupBy from 'lodash-es/groupBy';

function reverseObject(obj) {
  return Object.keys(obj).sort().reverse().reduce((result, key) => {
    const ref = result;

    ref[key] = obj[key];

    return ref;
  }, {});
}

export default {
  data: () => ({
    name: '',
    rowCount: 8,
    columnCount: 10,
    rows: {},
    seats: [],
    submitting: false,
  }),
  created() {
    this.renderSeats(this.rowCount, this.columnCount);
  },
  watch: {
    rowCount() {
      this.renderSeats(this.rowCount, this.columnCount);
    },
    columnCount() {
      this.renderSeats(this.rowCount, this.columnCount);
    },
  },
  methods: {
    renderSeats(rowCount, columnCount) {
      this.rows = {};
      this.seats = [];

      const alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

      for (let row = 0; row < rowCount; row++) {
        const letter = alphabet[row];

        for (let column = 0; column < columnCount; column++) {
          this.seats.push({
            row: letter,
            column,
            active: true,
          });
        }
      }

      this.rows = reverseObject(groupBy(this.seats, 'row'));
    },
  },
};
</script>
