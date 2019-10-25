<template>
  <div>
    <heading class="mb-6 text-3xl uppercase font-black">Tmdb Import</heading>

    <card class="bg-90 flex flex-col items-center justify-center">
      <div class="py-16 container">
        <input type="text" class="mb-4 field" v-model="query" @change="search(query)" placeholder="Søg..." />
        <div class="mb-2 row-tight items-center justify-between">
          <div class="col w-1/3 flex justify-start">
            <button v-if="page > 1" class="btn btn-ghost" @click.prevent="search(query, page -1)"><i class="fa fa-caret-left"></i></button>
          </div>
          <div class="col w-1/3 flex justify-center">
            <p v-if="page && pages" class="text-white">Side ({{ page }}/{{ pages }})</p>
          </div>
          <div class="col w-1/3 flex justify-end">
            <button v-if="page < pages" class="btn btn-ghost" @click.prevent="search(query, page + 1)"><i class="fa fa-caret-right"></i></button>
          </div>
        </div>
        <transition name="fade">
          <div class="row-tight" v-if="films.length && !loading">
            <div class="my-1 col w-1/3" v-for="film in films" :key="film.id">
              <div class="p-2 h-full bg-gray-900 rounded">
                <div class="h-full row-tight">
                  <div class="col w-1/2">
                    <figure class="overflow-hidden h-full flex justify-center rounded">
                      <img :src="`//image.tmdb.org/t/p/w780${film.poster_path}`" :alt="film.title" class="object-cover" />
                    </figure>
                  </div>
                  <div class="col w-1/2 flex flex-col">
                    <div class="main-content">
                      <h3 class="text-2xl text-white">{{ film.title }}</h3>
                    </div>
                    <button @click.prevent="importFilm(film.id)" class="btn">Import</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </card>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data: () => ({
    query: '',
    films: [],
    page: 0,
    pages: 0,
  }),
  methods: {
    async search(query, page = 1) {
      Swal.fire({
        type: 'info',
        title: 'Indlæser',
      });

      try {
        const { data } = await axios({
          method: 'GET',
          url: '/nova-vendor/tmdb-import',
          params: {
            query,
            page,
          },
        });

        console.log(data);

        this.pages = data.total_pages;
        this.page = data.page;
        this.films = data.results;
      } catch (error) {
        console.error(error);
      } finally {
        Swal.close();
      }
    },
    async importFilm(id) {
      Swal.fire({
        type: 'info',
        title: 'Importerer',
      });

      try {
        const { data } = await axios({
          method: 'POST',
          url: '/nova-vendor/tmdb-import/import',
          data: {
            id,
          },
        });

        console.log(data);

        if (data.status === 'success') {
          Swal.close();

          Swal.fire({
            type: 'success',
            title: 'Success!',
            timer: 2000,
          });
        }
      } catch (error) {
        console.error(error);

        Swal.close();
      }
    },
  },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
