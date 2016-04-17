@extends('admin::master')

@section('title')
@parent - Category
@endsection

@section('content')
<div class="ui grid">
	<div class="nine wide column form-admin" id="admin-side-left">
		<vue-form
		name="category-list"
		form-target-add="category-form"
		form-target-edit="category-form"
		:form-action="{get:'get-category', delete: 'delete-category'}"
		>
			<vue-form-title
			title="Category List"
			icon="filter"
			:button-add="true"
			:button-refresh="true"
			:button-delete="true"
			></vue-form-title>
			<vue-form-list
			primary-id="id"
			:maps="{
			category: 'Category',
			used: 'Used'
			}"
			:can-detail="false"
			></vue-form-list>
			<vue-form-footer></vue-form-footer>
		</vue-form>
	</div>
	<div class="seven wide column form-admin" id="admin-side-right">
		<vue-form
		name="category-form"
		:form-action="{save:'save-category'}"
		:is-hidden="true"
		>
			<vue-form-title
			title="Category Form"
			icon="filter"
			:button-save="true"
			:button-cancel="true"
			></vue-form-title>

			<vue-form-fields>
				<vue-form-field name="id" type="hidden"></vue-form-field>
				<vue-form-field
				name="category"
				label="Category Name"
				placeholder="Category Name"
				type="text"></vue-form-field>

				<vue-form-field
				name="desc"
				label="Description"
				placeholder="Category Description"
				type="textarea"></vue-form-field>

				<vue-file-upload
				label="Category Thumb"
				type="image"
				name="thumb"
				></vue-file-upload>
			</vue-form-fields>
		</vue-form>
		@include('admin::empty')
	</div>
</div>
@endsection