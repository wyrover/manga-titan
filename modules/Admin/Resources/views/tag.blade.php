@extends('admin::master')

@section('title')
@parent - Tags
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
			title="Tag List"
			icon="tags"
			:button-add="true"
			:button-refresh="true"
			:button-delete="true"
			></vue-form-title>
			<vue-form-list
			primary-id="id"
			:maps="{
			tag: 'Tag',
			desc: 'Desc',
			used: 'Used'
			}"
			></vue-form-list>
			<vue-form-footer></vue-form-footer>
		</vue-form>
	</div>
	<div class="seven wide column form-admin" id="admin-side-right">
		<vue-form
		name="tag-form"
		:form-action="{save:'tag-save'}"
		:is-hidden="true"
		>
			<vue-form-title
			title="Tag Form"
			icon="tag"
			:button-save="true"
			:button-cancel="true"
			></vue-form-title>

			<vue-form-fields>
				<vue-form-field name="id" type="hidden"></vue-form-field>
				<vue-form-field
				name="tag"
				label="Tag Name"
				placeholder="Tag Name"
				type="text"></vue-form-field>

				<vue-form-field
				name="desc"
				label="Description"
				placeholder="Tag Description"
				type="textarea"></vue-form-field>
			</vue-form-fields>
		</vue-form>
		@include('admin::empty')
	</div>
</div>
@endsection