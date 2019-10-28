import Vue from 'vue';
import AsyncComputed from 'vue-async-computed';
import PortalVue from 'portal-vue';
import VueYouTubeEmbed from 'vue-youtube-embed';
import vClickOutside from 'v-click-outside';
import VueMq from 'vue-mq';
import StarRating from 'vue-star-rating';
import { VPopover } from 'v-tooltip';

import get from 'lodash-es/get';
import eachRight from 'lodash-es/eachRight';
import replace from 'lodash-es/replace';

import 'js-polyfills/keyboard';

import { store } from './store';
import './bootstrap';

Vue.prototype.svg = require('./svg');

Vue.prototype.trans = (string, args) => {
  let value = get(window.i18n, string);

  eachRight(args, (paramVal, paramKey) => {
    value = replace(value, `:${paramKey}`, paramVal);
  });

  return value;
};

Vue.use(AsyncComputed);
Vue.use(PortalVue);
Vue.use(VueYouTubeEmbed, { global: true, componentId: 'youtube-embed' });
Vue.use(vClickOutside);
Vue.use(VueMq, {
  breakpoints: {
    sm: 640,
    md: 768,
    lg: 1024,
    xl: Infinity,
  },
  defaultBreakpoint: 'md',
});

// Vue.component('vue-star-rating', (resolve) => {
//   import('vue-star-rating' /* webpackChunkName: 'js/vue-star-rating' */).then((AsyncComponent) => {
//     resolve(AsyncComponent.default);
//   });
// });

// Vue.component('v-popover', (resolve) => {
//   import('v-tooltip' /* webpackChunkName: 'js/v-tooltip' */).then((AsyncComponent) => {
//     resolve(AsyncComponent.VPopover);
//   });
// });

Vue.component('vue-star-rating', StarRating);
Vue.component('v-popover', VPopover);

const files = require.context('./', true, /\.vue$/i);

files
  .keys()
  .map(
    (key) => Vue.component(key.split('/')
      .pop()
      .split('.')[0], files(key).default),
  );

// const files = require.context('./', true, /\.vue$/i, 'lazy').keys();

// files.forEach((file) => {
//   Vue.component(file.split('/').pop().split('.')[0], () => import(`${file}`));
// });

const app = new Vue({ // eslint-disable-line
  el: '#app',
  store,
});
