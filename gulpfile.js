var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');

    mix.styles(['css/bootstrap.css', 'css/bootstrap-notifications.css', 'css/bootstrap-datetimepicker.min.css','css/select2.css', 'css/tip-twitter.css', 'components/emojione/assets/css/emojione.min.css', 'css/app.css', 'fancybox/source/jquery.fancybox.css','fancybox/source/helpers/jquery.fancybox-buttons.css','fancybox/source/helpers/jquery.fancybox-thumbs.css','components/jquery-bracket/dist/jquery.bracket.min.css'],null,'public');
    mix.scripts(['js/jquery.js', 'js/bootstrap.min.js', 'js/bootstrap-datetimepicker.min.js', 'js/jquery.poshytip.min.js', 'components/typeahead.js/dist/typeahead.bundle.min.js', 'components/autosize/dist/autosize.min.js', 'js/jquery.infinitescroll.min.js', 'js/jquery.textcomplete.js', 'components/emojione/lib/js/emojione.js', 'js/jquery.dotimeout.min.js', 'js/select2.full.min.js', 'js/gauge.min.js', 'fancybox/lib/jquery.mousewheel-3.0.6.pack.js','fancybox/source/jquery.fancybox.js','fancybox/source/helpers/jquery.fancybox-buttons.js','fancybox/source/helpers/jquery.fancybox-thumbs.js','fancybox/source/helpers/jquery.fancybox-media.js', 'components/jquery-bracket/dist/jquery.bracket.min.js', 'js/main.js'],null,'public');

    mix.version(['css/all.css','js/all.js']);
});