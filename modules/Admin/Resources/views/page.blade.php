@extends('admin::master')

@section('title')
@parent - Page
@endsection

@section('content')
<div class="ui grid">
	<div class="sixteen wide column form-admin" id="admin-side-left">
		<vue-form
		name="page-list"
		form-target-add="page-form"
		form-target-edit="page-form"
		:form-action="{get:'get-page', delete: 'delete-page'}"
		:optional-param="{id_manga:{{$id_manga}}}"
		>
			<vue-form-title
			title="Page List"
			icon="file"
			:button-add="true"
			:button-refresh="true"
			:button-delete="true"
			></vue-form-title>
			<vue-form-list
			list-type="grid"
			:maps="{
			title: 'title',
			image: 'image'
			}"
			></vue-form-list>
			<vue-form-footer></vue-form-footer>
		</vue-form>
	</div>
	<vue-media
	name="page-form"></vue-media>
</div>
@endsection