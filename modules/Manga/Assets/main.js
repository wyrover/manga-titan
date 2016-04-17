Vue.use(require('vue-resource'));

Vue.http.options.root = 'http://mangatitan.com';
Vue.http.headers.common['Authorization'] = 'Basic YXBpOnBhc3N3b3Jk';

Vue.component('app-page',			require('./component/app-page.vue'));
Vue.component('manga-list',			require('./component/manga-list.vue'));
Vue.component('manga-read',			require('./component/manga-read.vue'));
Vue.component('manga-thumb',		require('./component/manga-thumb.vue'));
Vue.component('vue-filter',			require('./component/vue-filter.vue'));
Vue.component('vue-pagination',			require('./component/vue-pagination.vue'));
Vue.component('vue-list',			require('./component/vue-list.vue'));
Vue.component('vue-navigator',		require('./component/vue-navigator.vue'));
Vue.component('vue-image',			require('./component/vue-image.vue'));