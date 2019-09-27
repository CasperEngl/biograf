<template>
  <section class="relative p-4 bg-gray-900">
    <div class="w-full min-h-8 bg-white" ref="screen" :style="{
      width: `calc(100% - ${seatWidth / 2}px)`,
      marginLeft: `${seatWidth / 2}px`,
    }">
      <h3 class="text-xl text-center py-2" v-if="cinemaName">{{ cinemaName }}</h3>
    </div>
    <div :style="screenShadow"></div>
    <table class="w-full mt-8">
      <col width="1">
      <thead>
        <tr>
          <th ref="walkway"></th>
          <th class="text-gray-600 font-bold text-sm" v-for="(seat, index) in singleRow" :key="index" ref="seat">{{ seat.column }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, letter) in rows" :key="letter">
          <td class="text-gray-600 font-bold text-sm" :style="{
            paddingRight: `${seatWidth / 4}px`
          }">{{ letter.toUpperCase() }}</td>
          <td v-for="(seat, index) in row" :key="index">
            <button
              @click.prevent="toggleSeat(seat)"
              class="w-full h-full max-w-4 block mx-auto"
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
import debounce from 'lodash-es/debounce';

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
  created() {
    this.updateScreenShadow();

    document.addEventListener('resize', debounce(this.updateScreenShadow, 250));
  },
  destroyed() {
    document.removeEventListener('resize', debounce(this.updateScreenShadow, 250));
  },
  data: (vm) => ({
    rows: vm.cinemaRows,
    screenShadow: {},
    screenWidth: 0,
    seatWidth: 0,
  }),
  methods: {
    toggleSeat(seat) {
      const ref = seat;

      ref.active = seat.active ? 0 : 1;
    },
    updateScreenShadow() {
      this.$nextTick().then(() => {
        this.screenWidth = this.$refs.screen.clientWidth;
        this.seatWidth = this.$refs.seat[0].clientWidth;

        this.screenShadow = {
          pointerEvents: 'none',
          position: 'absolute',
          right: `${this.seatWidth / 4}px`,
          marginTop: '-1px',
          marginLeft: `${this.seatWidth / 2}px`,
          borderWidth: `0 ${this.screenWidth / 2 - this.seatWidth / 4}px ${this.screenWidth / 10}px`,
          borderImage: 'linear-gradient(to bottom, rgba(255, 255, 255, .1), transparent) 100% / 1.1 / 0 stretch',
          height: 0,
          width: `${this.screenWidth - this.seatWidth}px`,
        };
      });
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
