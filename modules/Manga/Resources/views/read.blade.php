@extends('manga::master')

@section('title')
@parent - Read ""
@endsection 

@section('content')
<div class="sixteen wide column">
	<manga-read :manga-id="{{ $id_manga }}">
		<vue-navigator :page="{{ $page }}"></vue-navigator>
		<vue-image></vue-image>
	</manga-read>
</div>
@endsection