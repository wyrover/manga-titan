@extends('admin::master')

@section('title')
@parent - Category
@endsection

@section('content')
<div class="ui grid">
	<div class="nine wide column form-admin" id="admin-side-left">
		<vue-form
		name="tag-list"
		form-target-add="tag-form"
		form-target-edit="tag-form"
		:form-action="{get:'get-tags-list', delete: 'tags-delete'}"
		>
			<vue-form-title
			title="Category List"
			icon="filter"
			:button-add="true"
			:button-refresh="true"
			:button-delete="true"
			></vue-form-title>
			<vue-form-content
			primary-id="id"
			:maps="{
			tag: 'Category',
			desc: 'Desc',
			used: 'Used'
			}"
			></vue-form-content>
			<vue-form-footer></vue-form-footer>
		</vue-form>
	</div>
	<div class="seven wide column form-admin" id="admin-side-right">
		<vue-form
		name="category-form"
		:form-action="{save:'category-save'}"
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
				name="tag"
				label="Category Name"
				placeholder="Category Name"
				type="text"></vue-form-field>

				<vue-form-field
				name="desc"
				label="Description"
				placeholder="Category Description"
				type="textarea"></vue-form-field>
			</vue-form-fields>
		</vue-form>
		@include('admin::empty')
	</div>
</div>
@endsection