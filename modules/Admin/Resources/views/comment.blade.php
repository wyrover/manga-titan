@extends('admin::master')

@section('content')
<div class="ui grid">
	<div class="nine wide column form-admin" id="admin-side-left">
		<vue-form
		name="comment-list"
		form-target-add="comment-form"
		form-target-edit="comment-form"
		:form-action="{get:'get-comment', delete: 'comment-delete'}">

			<vue-form-title
			title="Comments"
			icon="comments"
			:button-add="true"
			:button-refresh="true"
			:button-delete="true"></vue-form-title>

			<vue-form-content
			:maps="{
			comments: 'Comment',
			manga: 'Manga',
			user: 'User',
			created_at: 'Comment at'
			}"></vue-form-content>
			<vue-form-footer></vue-form-footer>
		</vue-form>
	</div>
	<div class="seven wide column form-admin" id="admin-side-right">
		@include('admin::empty')
	</div>
</div>
@endsection