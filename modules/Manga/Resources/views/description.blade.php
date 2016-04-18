@extends('manga::master')

@section('title')
@parent - Description
@endsection

@set('routeurl',route('manga.read',[$id_manga, '{page}']))
@set('routeurl', str_ireplace(['%7B','%7D'],['{','}'], $routeurl))
@section('content')
<div class="sixteen wide column">
	<h3 class="ui header dividing">Description</h3>
	<vue-form
	id="category"
	:form-action="{get: 'detail-manga'}"
	:optional-param="{id: {{$id_manga}} }">
		<vue-desc>
			<vue-desc-image slot="left" name="thumb"></vue-desc-image>
			<vue-desc-content slot="right" :maps="[
				{label:'Title', key:'title', type:'text'},
				{label:'Synopsis', key:'description', type:'text'},
				{label:'Artist', key: 'artist', type:'label'},
				{label:'Category', key:'category', type:'text'},
				{label:'Tags', key:'tags', type:'label'},
				{label:'Rating', key:'rating', type:'rating'},
				{label:'Views', key:'views', type:'text'},
				{label:'Uploaded at', key:'created_at', type:'text'},
				{label:'Uploader', key:'uploader', type:'text'}
			]"></vue-desc-content>
		</vue-desc>
	</vue-form>
	<h3 class="ui header dividing">Thumbs</h3>
	<vue-form :form-action="{get:'get-thumb-page'}" :optional-param="{id_manga: {{$id_manga}} }" id="thumb">
		<vue-list
		list-type="grid"
		:maps="{title: 'title',image: 'image'}"
		:with-link = "true"
		link-format="{{$routeurl}}"></vue-list>
		<vue-pagination></vue-pagination>
	</vue-form>
</div>
@endsection