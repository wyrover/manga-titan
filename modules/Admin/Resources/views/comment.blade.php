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
			:button-refresh="true"
			:button-delete="true"></vue-form-title>

			<vue-form-list
			:maps="{
			comments: 'Comment',
			manga: 'Manga',
			user: 'User',
			created_at: 'Comment at'
			}"></vue-form-list>
			<vue-form-footer></vue-form-footer>
		</vue-form>
	</div>
	<div class="seven wide column form-admin" id="admin-side-right">
		<vue-form
		name="comment-list"
		form-target-add="comment-form"
		form-target-edit="comment-form"
		:form-action="{save:'save-comment'}">
			<vue-form-title
			title="Comment Detail"
			icon="comment"
			:button-delete="true"
			:button-cancel="true"
			></vue-form-title>

			<vue-form-fields>
				<div class="field"><label>on manga</label><a class="ui link" href="manga">Manga Link</a></div>
				<div class="field"><label>by user</label><a class="ui link" href="manga">Admin admin</a></div>
				<div class="field"><label>reply from</label><a class="ui link" href="manga">None</a></div>
				<div class="field"><label>comment at</label><a class="ui input" href="manga">12/12/2016 14:00</a></div>
				<div class="field"><label>comment</label><textarea cols="30" rows="2" readonly>safafsfa</textarea></div>
			</vue-form-fields>
		</vue-form>
		@include('admin::empty')
	</div>
</div>
@endsection