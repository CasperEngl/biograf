<template>
  <div class="relative">
    <div class="absolute inset-0 z-10 w-full" style="background: linear-gradient(to right, rgba(26, 32, 44, 1) 7.5%, transparent 17.5%, transparent 82.5%, rgba(26, 32, 44, 1) 92.5%); pointer-events: none;"></div>
    <carousel :per-page="8" :pagination-enabled="false" :scroll-per-page="false">
      <slide></slide>
      <slide></slide>
      <slide>
        <a :href="link('2019-10-03')" class="btn rounded-none w-full">
          <div class="block text-lg">Tors</div>
          <div class="block text-3xl">10-03</div>
          <div class="block text-sm">Okt</div>
        </a>
      </slide>
      <slide>
        <a :href="link('2019-10-04')" class="btn rounded-none w-full">
          <div class="block text-lg">Fre</div>
          <div class="block text-3xl">10-04</div>
          <div class="block text-sm">Okt</div>
        </a>
      </slide>
      <slide>
        <a :href="link('2019-10-05')" class="btn rounded-none w-full">
          <div class="block text-lg">Lør</div>
          <div class="block text-3xl">10-05</div>
          <div class="block text-sm">Okt</div>
        </a>
      </slide>
      <slide>
        <a :href="link('2019-10-06')" class="btn rounded-none w-full">
          <div class="block text-lg">Søn</div>
          <div class="block text-3xl">10-06</div>
          <div class="block text-sm">Okt</div>
        </a>
      </slide>
      <slide>
        <a :href="link('2019-10-07')" class="btn rounded-none w-full">
          <div class="block text-lg">Man</div>
          <div class="block text-3xl">10-07</div>
          <div class="block text-sm">Okt</div>
        </a>
      </slide>
      <slide>
        <a :href="link('2019-10-08')" class="btn rounded-none w-full">
          <div class="block text-lg">Tirs</div>
          <div class="block text-3xl">10-08</div>
          <div class="block text-sm">Okt</div>
        </a>
      </slide>
      <slide>
        <a :href="link('2019-10-09')" class="btn rounded-none w-full">
          <div class="block text-lg">Ons</div>
          <div class="block text-3xl">10-09</div>
          <div class="block text-sm">Okt</div>
        </a>
      </slide>
      <slide>
        <a :href="link('2019-10-10')" class="btn rounded-none w-full">
          <div class="block text-lg">Tors</div>
          <div class="block text-3xl">10-10</div>
          <div class="block text-sm">Okt</div>
        </a>
      </slide>
      <slide>
        <a :href="link('2019-10-11')" class="btn rounded-none w-full">
          <div class="block text-lg">Fre</div>
          <div class="block text-3xl">10-11</div>
          <div class="block text-sm">Okt</div>
        </a>
      </slide>
      <slide>
        <a :href="link('2019-10-12')" class="btn rounded-none w-full">
          <div class="block text-lg">Lør</div>
          <div class="block text-3xl">10-12</div>
          <div class="block text-sm">Okt</div>
        </a>
      </slide>
      <slide></slide>
      <slide></slide>
    </carousel>
  </div>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';

export default {
  components: {
    Carousel,
    Slide,
  },
  created() {
    console.log(this.link('2019-10-03').url());
  },
  methods: {
    link(date) {
      return route('showing.index', date);
    },
  },
};
</script>
