Vue.use(require('vue-resource'));

Vue.http.options.root = 'http://mangatitan.com';
Vue.http.headers.common['Authorization'] = 'Basic YXBpOnBhc3N3b3Jk';

Vue.component('app-page',			require('./component/app-page.vue'));
Vue.component('manga-form',			require('./component/manga-form.vue'));
Vue.component('manga-list',			require('./component/manga-list.vue'));
Vue.component('manga-page',			require('./component/manga-page.vue'));