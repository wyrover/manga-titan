@extends('master')

@section('pageScript')
<script src="{{ Module::asset('admin:js/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection

@section('pageStyle')
<link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">
@endsection

@section('pageContent')
@include('admin::menubar')
<app-page url-ajax="{{ route('manga.ajax') }}">
	@include('admin::sidebar')
	<div id="admin-area" class="thirteen wide column">
		@yield('content')
	</div>
</app-page>
@endsection

