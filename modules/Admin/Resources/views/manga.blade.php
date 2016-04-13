@extends('admin::master')

@section('title')
@parent - Manga
@endsection

@section('content')
<div class="ui grid">
	<div class="nine wide column form-admin" id="admin-side-left">
		<vue-form
		name="manga-list"
		form-target-add="manga-form"
		form-target-edit="manga-form"
		:form-action="{get:'get-manga', delete: 'delete-manga'}"
		>
			<vue-form-title
			title="Manga List"
			icon="book"
			:button-add="true"
			:button-refresh="true"
			:button-delete="true"
			></vue-form-title>
			<vue-form-list
			primary-id="id"
			:maps="{
			title: 'Manga',
			page: 'Page Count',
			created_at: 'Uploaded At'
			}"
			></vue-form-list>
			<vue-form-footer></vue-form-footer>
		</vue-form>
	</div>
	<div class="seven wide column form-admin" id="admin-side-right">
		<vue-form
		name="manga-form"
		:form-action="{save:'save-manga'}"
		:is-hidden="false"
		>
			<vue-form-title
			title="Manga Form"
			icon="book"
			:button-save="true"
			:button-cancel="true"
			></vue-form-title>
			<vue-form-fields>
				<vue-form-field name="id" type="hidden"></vue-form-field>

				<vue-form-field
				name="title"
				label="Manga Title"
				placeholder="Manga Title"
				type="text"></vue-form-field>

				<vue-form-field
				name="description"
				label="Description"
				placeholder="Description"
				type="textarea"></vue-form-field>

				<vue-form-field
				name="category"
				label="Category"
				type="select"
				:source-data="{url:'{{route('core.ajax')}}', client_action: 'source-category'}"></vue-form-field>

				<vue-form-field
				name="tags"
				label="Tags"
				type="select"
				:multiple="true"
				:source-data="{url:'{{route('core.ajax')}}', client_action: 'source-tags'}"></vue-form-field>

				<vue-file-upload
				label="Manga Thumbnail"
				type="image"
				name="thumb"
				:show-image = "false"
				></vue-file-upload>
			</vue-form-fields>
		</vue-form>
		@include('admin::empty')
	</div>
</div>
<div class="ui grid grid-fade">
	<div class="sixteen wide column form-admin">
		<!-- <manga-page form-id="manga-page" :is-hidden="true"></manga-page> -->
	</div>
</div>
@endsection