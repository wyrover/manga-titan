@extends('master')

@section('pageContent')
@include('admin::menubar')
<app-page>
	@include('admin::sidebar')
	<div class="thirteen wide column">
		@yield('content')
	</div>
</app-page>
@endsection

@section('pageScript')
<script src="{{ Module::asset('admin:js/main.js') }}" type="text/javascript"></script>
@endsection