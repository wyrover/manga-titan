@extends('admin::master')

@section('title')
@parent - Home
@endsection

@section('content')
<div class="ui grid">
	<div class="nine wide column form-admin" id="admin-side-left">
		<vue-tab
		name="home"
		:tabs="[
		{title: 'Basic Info', datatab: 'web', isactive: true },
		{title: 'Graph', datatab: 'graph'}
		]"></vue-tab>
		<vue-tab-content data-tab="web" :active="true">
			<vue-form
			name="manga-form"
			:form-action="{save:'save-manga'}"
			>
				<vue-form-title
				title="Basic Info"
				icon="home"
				:button-save="true"
				></vue-form-title>
				<vue-form-fields>
					<vue-form-field
					name="title"
					label="Web Name"
					placeholder="Manga Titan"
					type="text"></vue-form-field>

					<vue-form-field
					name="desc"
					label="Web Description"
					placeholder="Description"
					type="textarea"></vue-form-field>

					<vue-file-upload
					label="Logo"
					type="image"
					name="thumb"
					:show-image = "true"
					></vue-file-upload>
				</vue-form-fields>
			</vue-form>
		</vue-tab-content>
		<vue-tab-content data-tab="graph">
			<vue-form
			name="manga-form"
			:form-action="{get:'get-graph'}"
			>
				<vue-form-title
				title="Graph visitor"
				icon="line chart"
				:button-refresh="true"
				></vue-form-title>
			</vue-form>
		</vue-tab-content>
	</div>
	<div class="seven wide column form-admin" id="admin-side-right">
		<vue-tab
		name="home"
		:tabs="[
		{title: 'Recent Comment', datatab: 'comment', isactive: true }
		]"></vue-tab>
		<vue-tab-content data-tab="comment" :active="true">
			<vue-form
			name="manga-form"
			:form-action="{save:'save-manga'}"
			>
				<vue-form-list
				list-type="comment"
				:maps="{
				comments: 'Comment',
				user: 'User'
				}"></vue-form-list>
			</vue-form>
		</vue-tab-content>
	</div>
</div>
@endsection