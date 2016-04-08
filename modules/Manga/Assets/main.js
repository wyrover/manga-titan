Vue.use(require('vue-resource'));

Vue.http.options.root = 'http://mangatitan.com';
Vue.http.headers.common['Authorization'] = 'Basic YXBpOnBhc3N3b3Jk';

Vue.component('app-page',			require('./component/app-page.vue'));
Vue.component('manga-list',			require('./component/manga-list.vue'));
Vue.component('vue-filter',			require('./component/vue-filter.vue'));
Vue.component('vue-page',			require('./component/vue-page.vue'));
Vue.component('vue-list',			require('./component/vue-list.vue'));