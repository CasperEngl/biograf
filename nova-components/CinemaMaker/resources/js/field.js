import get from 'lodash-es/get';
import eachRight from 'lodash-es/eachRight';
import replace from 'lodash-es/replace';

Nova.booting((Vue) => {
  Vue.prototype.trans = (string, args) => {
    let value = get(window.i18n, string);

    eachRight(args, (paramVal, paramKey) => {
      value = replace(value, `:${paramKey}`, paramVal);
    });

    return value;
  };

  Vue.component('index-cinema-maker', require('./components/IndexField.vue'));
  Vue.component('detail-cinema-maker', require('./components/DetailField.vue'));
  Vue.component('form-cinema-maker', require('./components/FormField.vue'));
  Vue.component('cinema-maker', require('./components/CinemaMaker.vue'));
  Vue.component('cinema-layout', require('./components/CinemaLayout.vue'));
});
