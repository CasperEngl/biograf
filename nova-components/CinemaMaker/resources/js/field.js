Nova.booting((Vue, router, store) => {
  Vue.component('index-cinema-maker', require('./components/IndexField'));
  Vue.component('detail-cinema-maker', require('./components/DetailField'));
  Vue.component('form-cinema-maker', require('./components/FormField'));
  Vue.component('cinema-maker', require('./components/CinemaMaker.vue'));
  Vue.component('cinema-layout', require('./components/CinemaLayout.vue'));
});
