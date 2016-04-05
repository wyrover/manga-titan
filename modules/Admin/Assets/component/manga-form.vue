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
			<button class="ui icon small blue button"><i class="icon save"></i></button>
			<button class="ui icon small red button" @click="cancel"><i class="icon remove"></i></button>
		</div>
	</div>

	<div class="ui segment form-field">
		<div class="field"><label>Title</label><input type="text" v-model="manga_title"></div>
		<div class="field"><label>Description</label><textarea cols="20" rows="3" v-model="manga_desc"></textarea></div>
		<div class="field"><label>Category</label><select class="ui category addition search dropdown"><option value="">Category</option></select></div>
		<div class="field"><label>Tags</label><select class="ui tags addition search dropdown" multiple><option value="">Tags</option></select></div>
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
			title_form: function () {
				return (this.manga_id != null)?'Edit Manga':'New Manga';
			},
			url_image : function () {
				return (this.manga_cover != null)?'/manga/thumb/' + this.manga_cover:'/manga/image/dummy.png';
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
			cancel: function () {
				this.$emit('hide-form-manga');
			},
			file_selected: function (event) {
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
			'new-manga': function () {
				this.manga_id = null;
				this.manga_title = null;
				this.manga_desc = null;
				this.manga_cover = null;
				if (! this.is_visible()) $('#'+this.formId).transition('fade');
				$('#file-upload-progress').hide();
			},
			'hide-form-manga':function () {
				if (this.is_visible()) $('#'+this.formId).transition('fade');
			}
		},
		ready: function() {
			var that = this;
			$('#file-upload-progress').hide();
			$('#file-upload-input').on('change', function (e) {return that.file_selected(e);});

			$('.ui.category.search.dropdown').dropdown({
				allowAdditions:true
			});
			$('.ui.tags.search.dropdown').dropdown({
				allowAdditions:true
			});
		}
	}
</script>