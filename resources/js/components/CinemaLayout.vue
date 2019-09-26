<template>
  <table class="w-full">
    <col width="1">
    <tbody>
      <tr v-for="(row, letter) in rows" :key="letter">
        <td class="px-2 text-gray-600 font-bold">{{ letter.toUpperCase() }}</td>
        <td v-for="(seat, index) in row" :key="index">
          <button
            @click.prevent="toggleSeat(seat)"
            class="w-full h-full block"
            :class="[
              disabled
                ? `cursor-default ${seat.active ? 'bg-gray-300' : 'bg-yellow-500'}`
                :
                  seat.active
                    ? 'bg-gray-300 hover:bg-gray-500'
                    : 'bg-yellow-500 hover:bg-yellow-600'
            ]"
            :disabled="disabled"
          >
            &nbsp;
          </button>
          <input type="hidden" :name="`seats[${seat.row}][${seat.column}]`" :value="seat.active">
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    cinemaRows: {
      type: Object,
      required: false,
    },
    disabled: {
      type: Boolean,
      required: false,
      default: true,
    },
  },
  data: (vm) => ({
    rows: vm.cinemaRows,
  }),
  methods: {
    toggleSeat(seat) {
      const ref = seat;

      ref.active = seat.active ? 0 : 1;
    },
  },
};
</script>
