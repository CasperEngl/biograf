<template>
  <div class="row">
    <div class="col w-1/3 mb-6 flex flex-col" v-for="film in filteredFilms" :key="film.id">
      <div class="main-content">
        <a :href="route('film.show', {
          slug: film.slug,
        })" class="overflow-hidden relative block">
          <figure class="relative aspect-ratio-16/9 mb-2 block">
            <img :src="film.backdrops[0]" :alt="film.title" class="absolute">
          </figure>
          <h3 class="text-2xl uppercase font-black">{{ title(film.title, 16) }}</h3>
        </a>
        <div class="row-tight" v-if="film.showings && film.showings.length">
          <div class="col w-1/2" v-for="showing in film.showings" :key="showing.id">
            <a :href="route('showing.show', {
              date: dayjs(showing.start).format('YYYY-MM-DD'),
              showing: showing.id,
            })" class="relative my-1 h-12 bg-gray-700 hover:bg-gray-800 group flex">
              <p class="p-1 pl-4 w-full flex items-center">{{ dayjs(showing.start).format('hh:mm') }}</p>
              <span class="absolute inset-y-0 right-0 text-center block overflow-hidden flex items-center justify-center flex-no-wrap h-8 text-sm bg-orange-500 group-hover:bg-orange-400 p-px w-12" style="transform: rotate(90deg) translate(8px, -7px);">{{ showing.cinema.name }}</span>
            </a>
          </div>
        </div>
        <p class="my-4" v-else>{{ trans('showing.none') }}</p>
      </div>
      <a :href="route('film.show', {
        slug: film.slug,
      })" class="my-1 w-full btn btn-ghost border-gray-500">{{ trans('film.read_more') }}</a>
      <a :href="route('showing.days', {
        slug: film.slug
      })" class="my-1 w-full btn btn-ghost border-gray-500">{{ trans('showing.all_days') }}</a>
    </div>
  </div>
</template>

<script>
import dayjs from 'dayjs';
import locale from 'browser-locale';

export default {
  props: {
    films: {
      type: Array,
      required: true,
    },
    date: {
      type: String,
      required: true,
    },
  },
  data: (vm) => ({
    filteredFilms: vm.films.map((film) => ({
      ...film,
      showings: film.showings.filter((showing) => dayjs(showing.start).isSame(dayjs(vm.date), 'day')),
    })),
    locale: locale().split('-')[0],
    dayjs,
  }),
  methods: {
    url(slug) {
      return route('showing.show', {
        slug,
      });
    },
    title(titleObj, length) {
      const title = titleObj[this.locale];

      if (title.length > length) {
        return `${title.substring(0, length)}...`;
      }

      return title;
    },
    route(name, args) {
      return route(name, args);
    },
  },
};
</script>
