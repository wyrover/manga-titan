<style>
	.sortable {
		width: 100%;
		padding:1em 0em;
		margin:0em;
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
		margin-right: 10px;
		margin-bottom:10px;
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
		width: 140px;
		height: 210px;
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
	.sortable.grid li a.link {
		display:block;
		cursor: pointer;
		position: absolute;
		top:0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 3;
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

	.ui.segment.form-content .ui.comments {
		padding:1em;
	}
</style>

<template>
<div class="sixteen wide column">
	<div class="ui message warning" v-if="data_list.length ==0 " style="margin:1em 0">
		Nothing data to show
	</div>

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
						<input type="checkbox" :name="primaryId + '[]'" :value="item[primaryId]" v-model="check_list"><label></label>
					</div>
				</td>
				<td v-for="key in keys" v-html="item[key]"></td>
				<td>
					<vue-row-control
					:data-row.once="item"
					:is-href.once="isHref"
					:can-detail.once="canDetail"
					:can-edit.once="canEdit"
					:can-delete.once="canDelete"
					></vue-row-control>
				</td>
			</tr>
		</tbody>
	</table>

	<ul class="sortable mini grid" v-if="listType=='grid' && data_list.length > 0">
		<li v-for="item in data_list" :style="getBackground(item[maps.image])">
			<a class="link" v-if="withLink" :href="getLinks(item)"></a>
			<div class="content"><span class="header" >{{ item[maps.title] }}</span></div>
			<div class="extra content" v-if="withExtra">
				<vue-extra-content :row-data="item"></vue-extra-content>
			</div>
		</li>
	</ul>

	<div class="ui comments" v-if="listType=='comment'">
		<div class="comment" v-for="n in 5">
			<a class="avatar"><img src="/manga/image/thumb/dummy.png" alt=""></a>
			<div class="content">
				<a class="author">Joe Henderson</a>
				<div class="metadata">
					<span class="date">5 days ago</span>
				</div>
				<div class="text">Thanks</div>
			</div>
		</div>
	</div>
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
			listType: { required:false, type: String, default:'table'},
			withExtra: { required:false, type: Boolean, default: false },
			withLink: { required:false, type: Boolean, default: true },
			linkFormat: { required: false, type: String, default: '{0}'},
			isHref: {required:false, type:Object, default:function (){return {};} }
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
			},
			getLinks: function (item) {
				var target = /\{\w+\}/ig;
				var keytarget = '';
				var ret = '';
				keytarget = target.exec(this.linkFormat);
				if (keytarget != null) {
					keytarget = keytarget[0].substring(keytarget[0].length-1,1);
					ret = this.linkFormat.replace(target, item[keytarget]);
				}
				return ret;
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
			}
		},
		ready: function () {
			$('.sortable.grid li').on('click','.dimm', function () {
				$(this).parent().find('input').trigger('click');
			});
		}
	}
</script>