<template>
  <section class="container">
    <div class="row">
      <div class="col w-1/2">
        <label for="rows">
          <span class="w-full block">Rows</span>
          <input type="number" v-model.number="rows" id="rows" class="w-full" />
        </label>
      </div>
      <div class="col w-1/2">
        <label for="columns">
          <span class="w-full block">Columns</span>
          <input
            type="number"
            v-model.number="columns"
            id="columns"
            class="w-full"
          />
        </label>
      </div>
    </div>
    <table class="table-fixed my-6">
      <tbody>
        <tr class="table-row" v-for="(row, rowIndex) in rows" :key="rowIndex">
          <td colspan="2" class="table-cell pr-3">Row {{ rowIndex + 1 }}</td>
          <td colspan="2" class="table-cell" v-for="(column, columnIndex) in columns" :key="columnIndex">
            <input
              @click="selectSeat"
              type="checkbox"
              :id="`${rowIndex}-${columnIndex}`"
              :value="`${rowIndex}-${columnIndex}`"
            />
            <label :for="`${rowIndex}-${columnIndex}`"></label>
          </td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<script>
export default {
  data: () => ({
    rows: 8,
    columns: 10,
  }),
  methods: {
    selectSeat(e) {
      console.log(e.target);
    },
  },
};
</script>

<style scoped>
tr {
  margin: 0.25rem 0;
  width: 100%;
  display: inline-block;
}

input[type="checkbox"] {
  display: none;
}

input[type="checkbox"] + label {
  margin: 0.1rem;
  width: 24px;
  height: 20px;
  display: inline-block;
  background: #222;
}

input[type="checkbox"]:checked + label {
  background: yellow;
}
</style>
