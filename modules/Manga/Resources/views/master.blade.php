@extends('master')

@section('pageScript')
<script src="{{ Module::asset('manga:js/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection

@section('pageStyle')
<link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">
@endsection

@section('pageContent')
@include('manga::menubar')
<app-page url-ajax="{{ route('core.ajax') }}">
	@yield('content')
</app-page>
@include('manga::footer')
@endsection
