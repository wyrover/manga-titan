Vue.use(require('vue-resource'));

Vue.http.options.root = 'http://mangatitan.com';
Vue.http.headers.common['Authorization'] = 'Basic YXBpOnBhc3N3b3Jk';

Vue.component('app-page',			require('./component/app-page.vue'));
Vue.component('manga-form',			require('./component/manga-form.vue'));
Vue.component('manga-list',			require('./component/manga-list.vue'));
Vue.component('manga-page',			require('./component/manga-page.vue'));
Vue.component('vue-form',			require('./component/vue-form.vue'));
Vue.component('vue-form-content',	require('./component/vue-form-content.vue'));
Vue.component('vue-form-field',		require('./component/vue-form-field.vue'));
Vue.component('vue-form-fields',	require('./component/vue-form-fields.vue'));
Vue.component('vue-form-footer',	require('./component/vue-form-footer.vue'));
Vue.component('vue-form-title',		require('./component/vue-form-title.vue'));
Vue.component('vue-row-control',	require('./component/vue-row-control.vue'));