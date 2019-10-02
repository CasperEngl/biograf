import Vue from 'vue';
import AsyncComputed from 'vue-async-computed';
import PortalVue from 'portal-vue';
import VueYouTubeEmbed from 'vue-youtube-embed';
import vClickOutside from 'v-click-outside';

import 'js-polyfills/keyboard';

import './bootstrap';

Vue.use(AsyncComputed);
Vue.use(PortalVue);
Vue.use(VueYouTubeEmbed, { global: true, componentId: 'youtube-embed' });
Vue.use(vClickOutside);

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
