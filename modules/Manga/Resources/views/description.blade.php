@extends('manga::master')

@section('title')
@parent - "{{ $manga->title }}"
@endsection

@section('content')
<div class="sixteen wide column">
	<h3 class="ui header dividing">Description</h3>
	<div class="ui grid">
		<div class="four wide column">
			<img src="{{ route('imagecache', ['template' => 'read', 'filename' => $manga->thumb_path]) }}" alt="" class="ui medium image">
		</div>
		<div class="twelve wide column">
			<div class="ui list">
				<div class="item">
					<div class="content">
						<a class="header">Title</a>
						<div class="description">{{ $manga->title }}</div>
					</div>
				</div>
				<div class="item">
					<div class="content">
						<a class="header">Description</a>
						<div class="description">{{ $manga->description }}</div>
					</div>
				</div>
				<div class="item">
					<div class="content">
						<a class="header">Category</a>
						<div class="description">{{ $manga->category->category }}</div>
					</div>
				</div>
				<div class="item">
					<div class="content">
						<a class="header">Tags</a>
						<div class="description">
						@foreach($manga->tags as $tag)
							<div class="ui tag label">{{ $tag->name }}</div>
						@endforeach
						</div>
					</div>
				</div>
			</div>
			<a href="{{ route('manga.read', ['id'=> $manga->id]) }}" class="ui green button">Read Manga</a>
		</div>
	</div>
	<manga-thumb></manga-thumb>
</div>
@endsection