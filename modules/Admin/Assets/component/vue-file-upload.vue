<template>
	<div class="field">
		<label>{{ label }}</label>
		<img :src="fileurl" class="ui small image" v-if="!multiple && files.length > 0">
		<button class="ui labeled icon button upload" type="button" :disabled="is_disabled" @click="showBrowse">
			Browse
			<i class="icon upload"></i>
		</button>
		<input type="file" :accept="accept" :id="name + '-upload-input'" :multiple = "multiple">
		<vue-progress-bar :name="name"></vue-progress-bar>
		<input type="hidden" v-if="multiple && files.length > 0" v-for="file in files" :name="name + '[]'" :value="file">
		<input type="hidden" v-if="!multiple && files.length > 0" :name="name" :value="files[0]">
	</div>
</template>

<script>
	module.exports = {
		props: {
			label: { required:false, type:String, default:null },
			type: { required:true, type:String },
			name: { required:true, type:String },
			files: { required:false, type:Array, default:[] },
			multiple: { required:false, type:Boolean, default:null },
			disableOnEdit: { required: false, type:Boolean, default:false }
		},
		computed: {
			is_disabled:function () {
				if (this.is_edit)
					return this.disableOnEdit;
			},
			accept: function () {
				if (this.type == 'image')
					return "image/*"
				else
					return "*"
			},
			fileurl: function () {
				if (this.type == 'image' && this.files.length > 0)
					return '/manga/image/thumb/' + this.files[0];
				else
					return '/manga/image/thumb/dummy.png';
			}
		},
		data: function () {
			return {
				is_edit: false,
				is_uploading: false,
				currentfile: 0,
				errorfile: 0,
				images: []
			};
		},
		watch: {
			'currentfile': function (val, oldval) {
				if (val > oldval)
					this.uploadnext();
			}
		},
		methods: {
			showBrowse: function () {
				$('#' + this.name + '-upload-input').trigger('click');
			},
			uploadexec: function (formData, uploadParams) {
				var that = this;
				this.$http({
					url: '/manga/upload/image',
					method: 'POST',
					data: formData,
					upload: uploadParams
				}).then(function (response) {
					if (response.data.success) {
						that.files.push(response.data.data.filename);
					} else {
						that.errorfile++;
					}
					this.currentfile++;
				}, function () {
					that.errorfile++;
					this.currentfile++;
				});
			},
			uploadstart: function (event) {
				this.images = event.currentTarget.files;
				this.currentfile = 0;
				this.errorfile = 0;
				this.files = [];

				this.$broadcast('progress-show', this.name);
				this.$broadcast('progress-reset', this.name);

				this.uploadnext();
			},
			uploadnext: function () {
				if (this.currentfile == this.images.length) {
					this.uploadfinish();
				} else {
					var upload = {};
					var that = this;
					var formData = new FormData;
					formData.append('image', this.images[this.currentfile]);
					if (this.images.length == 1) {
						upload = {
							onload: function (e)  {
								that.$broadcast('progress-complete', that.name);
							},
							onprogress: function(e) {
								var val = e.loaded/e.total * 100;
								that.$broadcast('progress-set', val, that.name);
							}
						};
					} else {
						this.$broadcast('progress-set', (this.currentfile / this.images.length * 100), this.name);
					}
					this.uploadexec(formData, upload);
				}
			},
			uploadfinish: function () {
				if (this.errorfile > 0) {
					var notify = {title: 'Upload Failed', text: '', type:'error'};
					notify.text = this.errorfile + ' of ' + this.images + ' files error while upload';
					this.$dispatch('app-notify', notify);
				}
				this.images = [];
				this.$broadcast('progress-hide', this.name);
				$('#' + this.name + '-upload-input').val();
			}
		},
		events: {
			'flash-field': function (data) {
				if (! this.multiple && this.name in data) {
					this.multiple = [];
					this.multiple.push(data[this.name]);
				}
				this.is_edit = true;
			},
			'clear-field': function () {
				this.files = [];
			}
		},
		ready: function () {
			var that = this;
			$('#' + this.name + '-upload-input').on('change', function (e) {that.uploadstart(e);});
		}
	}
</script>