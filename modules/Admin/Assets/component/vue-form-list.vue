<style>
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
		position: relative;
	}
	.sortable.grid.mini li {
		width: 120px;
		height: 180px;
	}
	.sortable.grid li .content {
		background-color: rgba(0, 0, 0, 0.5);
		position: absolute;
		color: white;
		padding: 5px;
		left: 0px;
		right: 0px;
		word-break: break-all;
		word-wrap: break-word;
	}
	.sortable.grid li .dimm {
		position: absolute;
		top:0px;
		bottom: 0px;
		left:0px;
		right:0px;
		cursor: pointer;
		color:white;
		text-align: center;
		z-index: 3;
	}
	.sortable.grid li input {
		display: none;
	}
	.sortable.grid li input[type="checkbox"]:checked + .dimm {
		background-color:rgba(0, 0, 0, 0.5);
	}
	.sortable.grid li .dimm i.icon {
		margin-top:calc(50% - 28px);
		display: none;
	}
	.sortable.grid li input[type="checkbox"]:checked + .dimm i.icon {
		display: inline-block;
	}
	.sortable.grid li .content:not(.extra) {
		bottom: 0px;
	}
	.sortable.grid li .content.extra {
		top:0px;
	}
	.sortable.grid li .content .header {
		color:#FAFAFA;
	}
</style>

<template>
	<div class="ui segment form-content">
		<table class="ui very basic selectable table form-table" v-if="listType=='table'">
			<thead>
				<tr>
					<th><div class="ui fitted checkbox"><input type="checkbox" v-model="checkall"> <label></label></div></th>
					<th v-for="col in columns">{{ col }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in data_list" v-if="data_list.length > 0">
					<td class="collapsing">
						<div class="ui fitted checkbox">
							<input type="checkbox" name="id[]" :value="item[primaryId]" v-model="check_list"><label></label>
						</div>
					</td>
					<td v-for="key in keys" v-html="item[key]"></td>
					<td>
						<vue-row-control
						:can-detail="canDetail"
						:can-edit="canEdit"
						:can-delete="canDelete"
						:data-row="item"></vue-row-control>
					</td>
				</tr>
			</tbody>
		</table>

		<ul class="sortable mini grid" v-if="listType=='grid' && data_list.length > 0">
			<li v-for="item in data_list" :style="getBackground(item[maps.image])">
				<div class="content"><span class="header" >{{ item[maps.title] }}</span></div>
				<input type="checkbox" name="id[]" :value="item[primaryId]" v-model="check_list">
				<div class="dimm">
					<i class="icon huge checkmark"></i>
				</div>
				<div class="extra content">
					<vue-row-control
					:can-detail="canDetail"
					:can-edit="canEdit"
					:can-delete="canDelete"
					:data-row="item"
					:class="['icon']"></vue-row-control>
				</div>
			</li>
		</ul>
	</div>
</template>

<script>
	module.exports = {
		props: {
			maps: { required:true, type:Object },
			canDetail: { required:false, type:Boolean, default:true },
			canEdit: { required:false, type:Boolean, default:true },
			canDelete: { required:false, type:Boolean, default:true },
			primaryId: { required:false, type: String, default:'id' },
			listType: { required:false, type: String, default:'table'}
		},
		data:function () {
			return {
				data_list: [],
				check_list: []
			};
		},
		computed: {
			checkall: {
				set: function (val) {
					this.check_list = [];
					if (val) {
						var that = this;
						$.each (this.data_list, function (index, item) {
							that.check_list.push(item[that.primaryId]);
						});
					}
				},
				get: function () {
					if (this.check_list.length == this.data_list.length && this.data_list.length > 0)
						return true;
					return false;
				}
			},
			columns: function () {
				var col = $.map(this.maps, function (item, index) {
					return item;
				});
				return col;
			},
			keys: function () {
				var key = $.map(this.maps, function (item, index) {
					return index;
				});
				return key;
			}
		},
		methods: {
			getBackground: function (image) {
				if (image == '')
					return {backgroundImage:"url('/manga/image/original/dummy.png')"};

				return {backgroundImage:"url('" + '/manga/image/thumb/' + image + "')"};
			}
		},
		events: {
			'row-flash': function (data, selectall) {
				var that=this;
				if (typeof data != 'undefined') {
					this.check_list = [];
					this.data_list = data;
					this.$nextTick(function () {
						$('.sortable.grid li').on('click','.dimm', function () {
							$(this).parent().find('input').trigger('click');
						});
						if (selectall) that.checkall = true;
					});
				}
			},
			'row-clear': function () {
				this.check_list = [];
				this.data_list = [];
			},
			'row-detail': function () {return true;},
			'row-edit': function () {return true;},
			'row-delete': function () {return true;}
		},
		ready: function () {
			$('.sortable.grid li').on('click','.dimm', function () {
				$(this).parent().find('input').trigger('click');
			});
		}
	}
</script>