<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@section('title') Manga Titan @show</title>
		<link rel="stylesheet" href="{{ asset('css/semantic.min.css')}}">
		<link rel="stylesheet" href="{{ asset('css/app.css')}}">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,800,300italic' rel='stylesheet' type='text/css'>
		<script src="{{ asset('js/jquery-2.2.2.min.js')}}"></script>
		<script src="{{ asset('js/semantic.min.js')}}"></script>
		<script src="{{ asset('js/vue.min.js')}}"></script>

		<!--============================ Page Script Here   ===========================-->
		@yield('pageScript')
	</head>
	<body>
		@yield('sidebar')

		<div class="pusher">
			@yield('pageContent')
		</div>

		<script>
			var vue = new Vue({
				el: 'body',
				ready: function() {
	                Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
	            }
			});
			$(document).ready(function () {
				$('.ui.dropdown').dropdown();
				$('.blurring.image').dimmer({on: 'hover'});
				$('.ui.rating').rating({maxRating:5});
			});
		</script>
		
	</body>
</html>