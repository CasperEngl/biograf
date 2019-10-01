<template>
  <section class="relative p-4 bg-gray-900">
    <div class="relative w-full min-h-12 flex items-center justify-center bg-white" ref="screen" :style="{
      width: 'calc(90% - 25px)',
      marginLeft: 'calc(5% + 25px)',
    }">
      <h3 class="text-xl text-center py-2" v-if="cinemaName">{{ cinemaName }}</h3>
      <div :style="{
        position: 'absolute',
        top: '48px',
        height: '200px',
        width: '100%',
        background: 'linear-gradient(to bottom, rgba(255, 255, 255, .1) 0%, transparent 100%)',
        clipPath: 'polygon(5% 0%, 95% 0%, 100% 100%, 0% 100%)',
      }"></div>
    </div>
    <table class="w-full mt-16 table-fixed">
      <col width="25">
      <thead>
        <tr>
          <th></th>
          <th class="pb-1 text-gray-600 font-bold text-sm" v-for="(seat, index) in singleRow" :key="index" ref="seat">{{ seat.column }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, letter) in rows" :key="letter">
          <td class="text-gray-600 font-bold text-sm text-center" :style="{
            paddingRight: `${seatWidth / 4}px`
          }" v-if="letter">{{ letter.toUpperCase() }}</td>
          <td v-for="(seat, index) in row" :key="index">
            <button
              @click.prevent="toggleSeat(seat)"
              class="w-full h-full block mx-auto"
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
            <input v-if="!inputsDisabled" type="hidden" :name="`seats[${seat.row}][${seat.column}]`" :value="seat.active">
          </td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<script>
export default {
  props: {
    cinemaName: {
      type: String,
      required: true,
    },
    cinemaRows: {
      type: Object,
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
      default: true,
    },
  },
  data: (vm) => ({
    rows: vm.cinemaRows,
    seatWidth: 0,
  }),
  methods: {
    toggleSeat(seat) {
      const ref = seat;

      ref.active = seat.active ? 0 : 1;
    },
  },
  watch: {
    cinemaRows(value) {
      this.rows = value;
    },
  },
  computed: {
    singleRow() {
      return Object.values(this.rows).find(() => true);
    },
  },
};
</script>
