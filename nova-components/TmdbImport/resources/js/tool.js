Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'tmdb-import',
      path: '/tmdb-import',
      component: require('./components/Tool'),
    },
  ]);
});
