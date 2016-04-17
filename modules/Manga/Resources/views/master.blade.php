@extends('master')

@section('pageContent')
@include('manga::menubar')
<app-page url-ajax="{{ route('core.ajax') }}">
	@yield('content')
</app-page>
@include('manga::footer')
@endsection

@section('pageScript')
<script src="{{ Module::asset('manga:js/main.js') }}" type="text/javascript"></script>
@endsection