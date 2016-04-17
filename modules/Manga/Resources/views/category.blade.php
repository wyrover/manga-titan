@extends('manga::master')

@section('title')
@parent - Category
@endsection

@section('content')
<div class="sixteen wide column">
	<h3 class="ui header dividing">Category</h3>
	<vue-form id="category"
	:form-action="{get: 'get-home-category'}">
		<vue-list
		primary-id="value"
		:maps = "{
		image: 'image',
		title: 'text'
		}"
		:can-edit="false"
		:can-delete="false"
		:can-detail="false"
		list-type="grid"></vue-list>
	</vue-form>
</div>
@endsection
