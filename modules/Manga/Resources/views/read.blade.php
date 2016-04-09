@extends('manga::master')

@section('title')
@parent - Read "{{ $manga->title }}"
@endsection 

@section('content')
<div class="sixteen wide column">
	<manga-read :manga-id="{{ $manga->id }}">
		<vue-navigator :page="{{ $page }}" :max-page="{{ $manga->mangapages->count() }}"></vue-navigator>
		<vue-image></vue-image>
	</manga-read>
</div>
@endsection