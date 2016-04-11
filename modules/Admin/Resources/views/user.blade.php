@extends('admin::master')

@section('title')
@parent - Users
@endsection

@section('content')
<div class="ui grid">
	<div class="nine wide column form-admin" id="admin-side-left">
		<vue-form
		name="user-list"
		form-target-add="user-form"
		form-target-edit="user-form"
		:form-action="{get:'get-user', delete: 'user-delete'}"
		>
			<vue-form-title
			title="Users Control"
			icon="users"
			:button-add="true"
			:button-refresh="true"
			:button-delete="true"
			></vue-form-title>

			<vue-form-content
			primary-id="id"
			:maps="{
			email: 'Email',
			created_at: 'Register at',
			completed: 'Activated'
			}"
			></vue-form-content>
			<vue-form-footer></vue-form-footer>
		</vue-form>
	</div>
	<div class="seven wide column form-admin" id="admin-side-right">
		<vue-form
		name="user-form"
		:form-action="{save:'user-save'}"
		:is-hidden="true"
		>
			<vue-form-title
			title="User Form"
			icon="user"
			:button-save="true"
			:button-cancel="true"
			></vue-form-title>

			<vue-form-fields>
				<vue-form-field name="id" type="hidden"></vue-form-field>

				<vue-form-field
				name="email"
				label="Email"
				placeholder="Email"
				type="text"></vue-form-field>

				<vue-form-field
				name="password"
				value="blablablablabla"
				label="Password"
				type="password"
				:maxlength="32"
				:disable-on-edit="true"
				></vue-form-field>

				<vue-form-field
				name="is_active"
				label="Activate"
				type="checkbox"
				placeholder="Register and active user."></vue-form-field>
			</vue-form-fields>
		</vue-form>
		@include('admin::empty')
	</div>
</div>
@endsection