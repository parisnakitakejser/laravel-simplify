var gulp = require('gulp');
var elixir = require('laravel-elixir');

elixir(function(mix) {
  mix.sass([
		'app.scss'
	], 'public/style/app.css')

  mix.scripts([
    'framework/jquery/jquery-3.1.1.js'
  ], 'public/javascript/jquery.min.js')

  mix.scripts([
    'framework/bootstrap4/bootstrap.js',
    'app.js'
  ], 'public/javascript/app.min.js')
});
