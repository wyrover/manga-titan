var elixir = require('laravel-elixir');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.browserify('./modules/Manga/Assets/main.js', "public/modules/manga/js/main.js");
	mix.browserify('./modules/Admin/Assets/main.js', "public/modules/admin/js/main.js");
	mix.browserify('lazyload.js','public/js/lazyload.js');
    mix.less('app.less');
});
