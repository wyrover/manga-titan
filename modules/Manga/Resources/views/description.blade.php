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
				{label:'Artist', key: 'artist', type:'link', format:'{0}', class:['ui','tag','label','yellow']},
				{label:'Category', key:'category', type:'link', format:'{0}'},
				{label:'Tags', key:'tags', type:'link', format:'{0}', class:['ui','tag','label','green']},
				{label:'Rating', key:'rating', type:'rating'},
				{label:'Views', key:'views', type:'number', pluralize:'View'},
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
	<vue-form :form-action="{get:'get-comment'}" :optional-param="{id_manga: {{$id_manga}} }" id="comment-list">
		<vue-list
		list-type="comment"
		:maps="{author:'author', image: 'image', comment: 'comment', created_at: 'created_at'}"
		:with-extra="true"></vue-list>
	</vue-form>
	<vue-form :form-action="{save:'save-comment'}" :optional-param="{id_manga: {{$id_manga}} }" id="comment">
		<div class="ui form" style="max-width:650px;width:100%;">
			<div class="field">
				<textarea name="comment"></textarea>
			</div>
			<button class="ui blue labeled submit icon button" type="submit">
				<i class="icon edit"></i> Add Comment
			</button>
		</div>
	</vue-form>
</div>
@endsection