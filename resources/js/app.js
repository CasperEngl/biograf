import Vue from 'vue';

import './bootstrap';

const files = require.context('./', true, /\.vue$/i);

files
  .keys()
  .map(
    (key) => Vue.component(key.split('/')
      .pop()
      .split('.')[0], files(key).default),
  );

const app = new Vue({ // eslint-disable-line
  el: '#app',
});
