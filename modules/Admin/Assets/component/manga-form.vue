<style>
	.ui.button.upload {
		margin-top:1em;
	}
	.ui.button.upload + input[type="file"] {
		display: none;
	}
	.ui.upload.progress {
		margin-top:1em;
		margin-bottom: 0;
	}
	#img-cover-preview {
		max-height: 212px;
	}
</style>

<template>
<div class="ui form" :class="{transition:isHidden, hidden:isHidden}" :id="formId">

	<div class="ui secondary inverted green segment form-title">
		<div class="title" v-text="title_form"></div>
		<div class="control">
			<div class="ui icon small buttons">
				<button v-if="is_edit" class="ui blue button" @click="showPage"><i class="icon upload"></i></button>
				<button class="ui blue button" @click="save"><i class="icon save"></i></button>
				<button class="ui red button" @click="cancel"><i class="icon remove"></i></button>
			</div>
		</div>
	</div>

	<div class="ui segment form-field">
		<div class="field"><label>Title</label><input type="text" v-model="manga_title"></div>
		<div class="field"><label>Description</label><textarea cols="20" rows="3" v-model="manga_desc"></textarea></div>
		<div class="field"><label>Category</label><select class="ui category-dropdown addition search dropdown" id="category-dropdown"><option value="">Category</option></select></div>
		<div class="field">
			<label>Tags</label>
			<select class="ui tags-dropdown addition search dropdown" multiple id="tags-dropdown">
				<option value="">Tags</option>
			</select>
		</div>
		<div class="field">
			<label>Cover</label>
			<!-- <img :src="url_image" class="ui small image" id="img-cover-preview"> -->
			<a v-text="manga_cover" :href="url_image" target="_blank"></a>
			<button class="ui labeled icon button upload">
				Browse
				<i class="icon upload"></i>
			</button>
			<input type="file" accept="image/*" id="file-upload-input">
			<div class="ui indicating progress upload" id="file-upload-progress" data-percent="0"><div class="bar"><div class="progress"></div></div></div>
		</div>
	</div>

</div>
</template>

<script>
	module.exports = {
		props: {
			formId: { required:true, type:String },
			isHidden: { required:false, type:Boolean, default: false }
		},
		computed: {
			is_edit: function () {
				return (this.manga_id != null);
			},
			title_form: function () {
				return (this.manga_id != null)?'Edit Manga':'New Manga';
			},
			url_image : function () {
				return (this.manga_cover != null)?'/manga/image/thumb/' + this.manga_cover:'/manga/image/original/dummy.png';
			}
		},
		data: function () {
			return {
				manga_id:null,
				manga_title:null,
				manga_desc:null,
				manga_cover:null
			};
		},
		methods: {
			showPage: function () {
				var data = {
					manga_id: this.manga_id,
					manga_title: this.manga_title
				};
				this.$dispatch('show-page', data);
			},
			save: function () {
				var data = {
					data: {
						manga_id: this.manga_id,
						manga_title: this.manga_title,
						manga_desc: this.manga_desc,
						manga_cover: this.manga_cover,
						manga_category: $('.category-dropdown').dropdown('get value'),
						manga_tags: $('.tags-dropdown').dropdown('get value')
					},
					callback: 'save-manga-callback',
					client_action: 'save-manga'
				};
				this.$dispatch('ajax-action', data);
			},
			cancel: function () {
				this.$emit('hide-form-manga');
			},
			file_upload: function (event) {
				var image = event.currentTarget.files[0];
				var formData = new FormData();
				var that = this;

				formData.append('image', image);

				this.$http({
					url: '/manga/upload/image',
					method: 'POST',
					data: formData,
					upload: {
						onloadstart: function (e) {
							$('#file-upload-progress').show();
							$('#file-upload-progress').progress({value: 0});
						},
						onerror: function (e) {},
						onload: function (e)  {
							$('#file-upload-progress').progress({value: 100});
						},
						onprogress: function(e) {
							var val = e.loaded/e.total * 100;
							$('#file-upload-progress').progress({value: val});
						},
						onloadend: function (e) {
							$('#file-upload-progress').hide();
						}
					}
				}).then(function (response) {
					if (response.data.success) {
						that.manga_cover = response.data.data.filename;
					}
				}, function (response) {console.log('something error');});
				$('#file-upload-input').val('');
			},
			is_visible: function () {
				return $('#'+this.formId).transition('is visible');
			}
		},
		events: {
			'get-tags-callback': function (data) {
				var html = '';
				$.each(data.data, function (index, item) {
					html += "<option value='" + item.name + "'>" + item.name + "</option>";
				});

				$('#tags-dropdown').html(html);
				$('#tags-dropdown').dropdown({
					allowAdditions:true
				}).dropdown('refresh');
			},
			'get-category-callback': function (data) {
				var html = '';
				$.each(data.data, function (index, item) {
					html += "<option value='" + item.id + "'>" + item.category + "</option>";
				});

				$('#category-dropdown').html(html);
				$('#category-dropdown').dropdown({
					allowAdditions:true
				}).dropdown('refresh');
			},
			'save-manga-callback': function (data) {
				var notify = {};
				if (data.success) {
					notify = {title: 'Save Success', text: data.message};
				} else {
					notify = {title: 'Save Failed', text: data.message, type:'error'};
				}
				this.$dispatch('app-notify', notify);
				this.$dispatch('refresh-manga');
				this.$emit('get-tags');
				this.$emit('get-category');
				this.$emit('hide-form-manga');
			},
			'new-manga': function () {
				this.manga_id = null;
				this.manga_title = null;
				this.manga_desc = null;
				this.manga_cover = null;
				$('.category-dropdown').dropdown('clear');
				$('.tags-dropdown').dropdown('clear');
				this.$emit('show-form-manga');
			},
			'edit-manga': function (data) {
				this.manga_id = data.manga_id;
				this.manga_title = data.manga_title;
				this.manga_desc = data.manga_desc;
				this.manga_cover = data.manga_cover;
				$('.category-dropdown').dropdown('set selected', data.manga_category);
				$('.tags-dropdown').dropdown('set exactly', data.manga_tags);
				this.$emit('show-form-manga');
			},
			'show-form-manga': function () {
				if (! this.is_visible()) $('#'+this.formId).transition('fade');
			},
			'hide-form-manga':function () {
				if (this.is_visible()) $('#'+this.formId).transition('fade');
			},
			'get-tags':function () {
				this.$dispatch('ajax-action', {client_action:'get-tags', callback:'get-tags-callback', data: {}});
			},
			'get-category': function () {
				this.$dispatch('ajax-action', {client_action:'get-category', callback:'get-category-callback', data: {}});
			}
		},
		ready: function() {
			var that = this;

			this.$emit('get-tags');
			this.$emit('get-category');

			$('#file-upload-progress').hide();
			$('#file-upload-input').on('change', function (e) {return that.file_upload(e);});
		}
	}
</script>