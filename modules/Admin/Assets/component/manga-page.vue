<style>

		#demos section {
			overflow: hidden;
		}
		.sortable {
			width: 100%;
			padding:0em 1em;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
		.sortable.grid {
			overflow: hidden;
		}
		.sortable li {
			list-style: none;
			border: 1px solid #CCC;
			background-color: #F6F6F6;
			background-repeat: no-repeat;
			background-size: 100% 100%;
			background-position: center center;
			color: #1C94C4;
			margin: 5px;
			padding: 5px;
			height: 22px;
		}
		.sortable.grid li {
			float: left;
			width: 150px;
			height: 225px;
		}
		.handle {
			cursor: move;
		}
		.sortable.connected {
			width: 200px;
			min-height: 100px;
			float: left;
		}
		li.disabled {
			opacity: 0.5;
		}
		li.highlight {
			background: #FEE25F;
		}
		li.sortable-placeholder {
			border: 1px dashed #CCC;
			background: none;
		}
		#page-upload-progress {
			margin-top: 0px;
		}

</style>

<template>
<div class="ui form" :class="{transition:isHidden, hidden:isHidden}" :id="formId">
	
	<div class="ui secondary inverted green segment form-title">
		<div class="title"><i class="icon file"></i> Manga Pages "{{manga_title}}"</div>
		<div class="control">
			<div class="ui small icon buttons">
				<button class="ui blue button" @click="upload"><i class="icon upload"></i></button>
				<button class="ui red button" @click="deleteall"><i class="icon trash"></i></button>
				<button class="ui red button" @click="cancel"><i class="icon share"></i></button>
			</div>
		</div>
	</div>

	<div class="ui segment form-content">
		<div v-if="pages.length == 0" class="ui warning message">You doen't have page in this manga. <a href="#upload" @click="upload">Upload Pages</a></div>
		<ul  v-else class="sortable grid">
			<li v-for="page in pages | orderBy 'page_order'" :style="getBackground(page.img_path)">
				<div class="ui mini icon buttons">
					<button @click="deletepage(page)" class="ui red button"><i class="icon trash"></i></button>
					<button @click="changeOrder(page)" class="ui blue button">{{ page.page_order }}</button>
				</div>
			</li>
		</ul>
	</div>

	<div class="ui blue segment form-footer">
		<div class="control"><div class="ui small buttons">
			<button @click="prevPage" class="ui blue icon button" :disabled="page_num == 1"><i class="left chevron icon"></i></button>
			<button class="ui blue basic button">{{ page_num }}</button>
			<button @click="nextPage" class="ui blue icon button" :disabled="page_num == max_page || max_page == 0"><i class="right chevron icon"></i></button>
		</div></div>
		<div class="notes">
			<div class="note">The page is ordered automatically by filename.</div>
			<div class="ui indicating progress upload" id="page-upload-progress" data-percent="0">
				<div class="bar"><div class="progress"></div></div>
			</div>
		</div>
	</div>

	<input type="file" multiple accept="image/*" id="page-upload-input" style="display: none;">
</div>
</template>

<script>
	module.exports = {
		props: {
			formId: { required: true, type: String },
			isHidden: { required:false, type:Boolean, default: false }
		},
		data: function () {
			return {
				manga_id: null,
				manga_title: null,
				pages: [],
				page_num:1,
				max_page:0
			}
		},
		methods: {
			getBackground: function (img_path) {
				return {backgroundImage:"url('" + '/manga/image/thumb/' + img_path + "')"};
			},
			upload: function () {
				$('#page-upload-input').trigger('click');
			},
			uploadprocess: function(event) {
				var images = event.currentTarget.files;
				var formData = new FormData();
				var that = this;

				console.log(images);
				$.each(images, function (key, item) {
					formData.append("image[]",item);
				});

				this.$http({
					url: '/manga/upload/image',
					method: 'POST',
					data: formData,
					upload: {
						onloadstart: function (e) {
							$('#page-upload-progress').show();
							$('#page-upload-progress').progress({value: 0});
						},
						onerror: function (e) {},
						onload: function (e)  {
							$('#page-upload-progress').progress({value: 100});
						},
						onprogress: function(e) {
							var val = e.loaded/e.total * 100;
							$('#page-upload-progress').progress({value: val});
						},
						onloadend: function (e) {
							$('#page-upload-progress').hide();
						}
					}
				}).then(function (response) {
					if (response.data.success) {
						that.$emit('flash-page',response.data.data.filename);
					}
				}, function (response) {console.log('something error');});
				$('#page-upload-input').val();
			},
			deletepage: function (page) {
				var data = {
					data: {
						page_id: page.page_id
					},
					client_action: 'delete-page',
					callback: 'delete-page-callback'
				};
				this.$dispatch('ajax-action', data);
			},
			deleteall: function () {
				var that = this;
				var data = {
					data: {
						manga_id: this.manga_id
					},
					client_action: 'delete-all-pages',
					callback: 'delete-page-callback'
				};
				var confirm = {
					title: 'Delete all pages',
					text: 'Are you sure to delete all pages?',
					onconfirm: function () {
						that.$dispatch('ajax-action', data);
					}
				};
				this.$dispatch('app-confirm', confirm);
			},
			changeOrder: function (page) {
				var that = this;
				var data = {
					title: 'New Page',
					type: 'number',
					value: page.page_order,
					onconfirm: function (newvalue) {
						var param = {
							manga_id: that.manga_id,
							page_id: page.page_id,
							page_order: newvalue,
							page_num: that.page_num
						};
						that.$emit('change-order',param);
					}
				};
				this.$dispatch('app-input', data);
			},
			cancel: function() {
				this.$emit('hide-page');
			},
			prevPage: function() {
				this.page_num--;
				this.$emit('refresh-manga-page');
			},
			nextPage: function () {
				this.page_num++;
				this.$emit('refresh-manga-page');
			},
			is_visible: function () {
				return $('#'+this.formId).transition('is visible');
			}
		},
		events: {
			'delete-page-callback': function (data) {
				var notify = {};
				if (data.success) {
					this.$emit('refresh-manga-page');
					notify = {title: 'Delete Success', text: data.message};
				} else {
					notify = {title: 'Delete Failed', text: data.message, type:'error'};
				}
				this.$dispatch('app-notify', notify);
			},
			'refresh-manga-page-callback': function (data) {
				if (data.success) {
					this.pages = data.data.pages;
					this.max_page = data.data.max_page;
					this.page_num = data.data.cur_page;
				} else {
					var notify = {title: 'Failed get data', text: data.message, type:'error'};
					this.$dispatch('app-notify', notify);
				}
			},
			'flash-page-callback':function (data) {
				var notify = {};
				if (data.success) {
					this.$emit('refresh-manga-page-callback', data);
					this.$dispatch('refresh-manga');
					notify = {title: 'Save Success', text: data.message};
				} else {
					notify = {title: 'Save Failed', text: data.message, type:'error'};
				}
				this.$dispatch('app-notify', notify);
			},
			'change-order-callback': function (data) {
				var notify = {};
				if (data.success) {
					this.$emit('refresh-manga-page-callback', data);
					notify = {title: 'Update Success', text: data.message};
				} else {
					notify = {title: 'Update Failed', text: data.message, type:'error'};
				}
				this.$dispatch('app-notify', notify);
			},
			'flash-page':function (filenames) {
				var data = {
					data: {
						manga_id: this.manga_id,
						pages: filenames
					},
					client_action:'add-page',
					callback:'flash-page-callback'
				};
				this.$dispatch('ajax-action',data);
			},
			'change-order': function (data) {
				var req = {
					data: data,
					callback: 'change-order-callback',
					client_action: 'change-order'
				};
				this.$dispatch('ajax-action', req);
			},
			'show-page': function (data) {
				this.manga_id = data.manga_id;
				this.manga_title = data.manga_title;
				this.$emit('refresh-manga-page');
			},
			'hide-page': function () {
				this.manga_id = null;
				this.manga_title = null;
				this.pages = [];
				this.page_num = 1;
				this.max_page = 0;
				this.$emit('hide-manga-page');
			},
			'refresh-manga-page': function () {
				var data = {
					data: {
						manga_id: this.manga_id,
						page_num: this.page_num
					},
					client_action: 'get-page',
					callback: 'refresh-manga-page-callback'
				};
				this.$dispatch('ajax-action', data);
				this.$emit('show-manga-page');
			},
			'show-manga-page': function () {
				if (! this.is_visible()) $('#'+this.formId).transition('fade');
			},
			'hide-manga-page': function () {
				if (this.is_visible()) $('#'+this.formId).transition('fade');
			}
		},
		ready: function () {
			// $('.sortable.grid').sortable();
			var that = this;
			$('#page-upload-progress').hide();
			$('#page-upload-input').on('change', function (e) {that.uploadprocess(e);});
		}
	};
</script>