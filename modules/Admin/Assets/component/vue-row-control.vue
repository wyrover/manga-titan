<style>
	.ui.link {
		cursor: pointer;
	}
</style>

<template>
	<a v-if="isHref.detail.enable" :href="getUrl.detail"><i class="list" :class="class"></i></a>
	<span v-else class="ui link" v-if="canDetail" @click="rowDetail"><i class="list" :class="class"></i></span>

	<a v-if="isHref.edit.enable" :href="getUrl.edit"><i class="pencil" :class="class"></i></a>
	<span v-else class="ui link" v-if="canEdit" @click="rowEdit"><i class="pencil" :class="class"></i></span>

	<a v-if="isHref.delete.enable" :href="getUrl.delete"><i class="trash" :class="class"></i></a>	
	<span v-else class="ui link" v-if="canDelete" @click="rowDelete"><i class="trash" :class="class"></i></span>
</template>

<script>
	module.exports = {
		props: {
			canDetail: { required:false, type:Boolean, default:true },
			canEdit: { required:false, type:Boolean, default:true },
			canDelete: { required:false, type:Boolean, default:true },
			isHref : {required:false, type:Object, default:function () {return {
				detail:{
					enable:false,
					format:'{0}'
				}, edit:{
					enable:false,
					format:'{0}'
				}, delete:{
					enable:false,
					format:'{0}'
				}
			};}},
			dataRow: { required:true, type: Object },
			class: { required:false, type:Array, default: function () {return ['icon','blue'];} }
		},
		computed: {
			getUrl: function () {
				var that = this;
				var target = /\{\w+\}/ig;
				var keytarget = '';
				var ret = {};
				var hreff = $.extend(true, {}, this.isHref);
				$.map(hreff, function (item, index) {
					keytarget = target.exec(item.format);
					if (keytarget != null) {
						keytarget = keytarget[0].substring(keytarget[0].length-1,1);
						ret[index] = item.format.replace(target, that.dataRow[keytarget]);
					}
				});
				return ret;
			}
		},
		methods: {
			rowDetail: function () {
				this.$dispatch('row-detail', this.dataRow);
			},
			rowEdit: function () {
				this.$dispatch('row-edit', this.dataRow);
			},
			rowDelete: function () {
				this.$dispatch('row-delete', this.dataRow);
			}
		},
		ready: function() {
			//
		}
	}
</script>