<template>
  <div class="relative">
    <div class="absolute inset-0 z-10 w-full" style="background: linear-gradient(to right, rgba(26, 32, 44, 1) 7.5%, transparent 17.5%, transparent 82.5%, rgba(26, 32, 44, 1) 92.5%); pointer-events: none;"></div>
    <carousel :per-page-custom="[[400, 2], [768, 3], [1024, 4], [1400, 8]]" :pagination-enabled="false" :scroll-per-page="false">
      <slide v-if="['lg', 'xl'].includes($mq)"></slide>
      <slide v-for="date in dates" :key="date.format('YYYY-MM-DD')">
        <a :href="link(date.format('YYYY-MM-DD'))" class="btn rounded-none w-full inline-flex flex-col items-center">
          <div class="text-lg">{{ date.toDate().toLocaleString(locale, { weekday: 'short' }) }}</div>
          <div class="text-3xl text-gray-800">{{ date.format('MM-DD') }}</div>
          <div class="text-sm">{{ date.toDate().toLocaleString(locale, { month: 'short' }) }}</div>
        </a>
      </slide>
      <slide mq="md+"></slide>
    </carousel>
  </div>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';
import dayjs from 'dayjs';
import locale from 'browser-locale';

export default {
  components: {
    Carousel,
    Slide,
  },
  data: () => ({
    dates: [],
    locale,
  }),
  created() {
    this.generateDates();
  },
  methods: {
    link(date) {
      return route('showing.index', date);
    },
    generateDates() {
      for (let i = 0; i < 20; i++) {
        this.dates.push(dayjs().add(i, 'day'));
      }
    },
  },
};
</script>
