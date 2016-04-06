<template>
<div class="ui form" :class="{transition:isHidden, hidden:isHidden}" :id="formId">
	<div class="ui secondary inverted green segment form-title">
		<div class="title"><i class="icon book"></i> Manga List</div>
		<div class="control">
			<div class="ui small icon buttons">
				<button class="ui blue button" @click="addManga"><i class="icon plus"></i></button>
				<button class="ui blue button" @click="refreshManga"><i class="icon refresh"></i></button>
				<button class="ui red button" @click="multipleDelete"><i class="icon trash"></i></button>
			</div>
		</div>
	</div>

	<div class="ui segment form-content">
		<table class="ui very basic selectable table form-table">
			<thead><tr><th><div class="ui fitted checkbox"><input type="checkbox" v-model="select_all"> <label></label></div></th><th>Title</th><th>Pages</th><th>Uploaded at</th><th></th></tr></thead>
			<tbody>
				<tr v-for="manga in manga_list">
					<td class="collapsing">
						<div class="ui fitted checkbox">
							<input type="checkbox" :value="manga.manga_id" v-model="manga_check"><label></label>
						</div>
					</td>
					<td>{{ manga.manga_title }}</td>
					<td>192</td>
					<td>{{ manga.manga_upload }}</td>
					<td>
						<a href="#" @click="editManga(manga)"><i class="icon blue pencil"></i></a>
						<a href="#" @click="deleteManga(manga)"><i class="icon blue trash"></i></a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="ui blue segment form-footer">
		<div class="ui small buttons">
			<button @click="prevPage" class="ui blue icon button" :disabled="page_num == 1"><i class="left chevron icon"></i></button>
			<button class="ui blue basic button">{{ page_num }}</button>
			<button @click="nextPage" class="ui blue icon button" :disabled="page_num == max_page || max_page == 0"><i class="right chevron icon"></i></button>
		</div>
	</div>
</div>
</template>

<script>
	module.exports = {
		props: {
			formId: { required: true, type:String },
			isHidden: { required:false, type:Boolean, default: false }
		},
		data: function () {
			return {
				manga_list:[],
				manga_check:[],
				select_all:false,
				page_num:1,
				max_page:0
			}
		},
		watch: {
			'select_all': function (val, oldval) {
				if (val) {
					var values = [];
					$.each(this.manga_list, function (index, item) {
						values.push(item.manga_id);
					});
					this.manga_check = values;
				} else {
					this.manga_check = [];
				}
			}
		},
		methods: {
			multipleDelete: function () {
				var that = this;
				var data = {
					data: {
						manga_id: this.manga_check
					},
					client_action: 'delete-manga',
					callback: 'delete-manga-callback'
				};
				var confirm = {
					title: 'Delete Manga',
					text: 'Are you sure to delete selected manga?',
					onconfirm: function () {
						that.$dispatch('ajax-action', data);
					}
				};
				this.$dispatch('app-confirm', confirm);
			},
			nextPage:function () {
				this.page_num++;
				this.$emit('refresh-manga');
			},
			prevPage:function () {
				this.page_num--;
				this.$emit('refresh-manga');
			},
			addManga: function () {
				this.$dispatch('new-manga');
			},
			editManga: function (manga) {
				this.$dispatch('edit-manga', manga);
			},
			deleteManga: function(manga) {
				var that = this;
				var data = {
					data: {
						manga_id: manga.manga_id,
					},
					client_action: 'delete-manga',
					callback: 'delete-manga-callback'
				};
				var confirm = {
					title: 'Delete Manga',
					text: 'Are you sure to delete this manga?',
					onconfirm: function () {
						that.$dispatch('ajax-action', data);
					}
				};
				this.$dispatch('app-confirm', confirm);
			},
			refreshManga: function () {
				this.$emit('refresh-manga');
			}
		},
		events: {
			'delete-manga-callback': function (data) {
				var notify = {};
				if (data.success) {
					notify = {title: 'Delete Success', text: data.message};
					this.$emit('refresh-manga');
				} else {
					notify = {title: 'Delete Failed', text: data.message, type:'error'};
				}
				this.$dispatch('app-notify', notify);
				this.$dispatch('hide-form-manga');
			},
			'get-manga-callback': function (data) {
				if (data.success) {
					this.manga_list = data.data.manga;
					this.max_page = data.data.max_page;
					this.select_all = false;
					this.manga_check = [];
				}
			},
			'refresh-manga': function () {
				this.$dispatch('ajax-action', {client_action:'get-manga', callback:'get-manga-callback', data: {page_num:this.page_num}});
			}
		},
		ready: function () {
			this.$emit('refresh-manga');
		}
	}
</script>