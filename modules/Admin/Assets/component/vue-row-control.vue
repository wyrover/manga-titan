<style>
	.ui.link {
		cursor: pointer;
	}
</style>

<template>
	<span class="ui link" v-if="canDetail" @click="rowDetail"><i class="list" :class="class"></i></span>
	<span class="ui link" v-if="canEdit" @click="rowEdit"><i class="pencil" :class="class"></i></span>
	<span class="ui link" v-if="canDelete" @click="rowDelete"><i class="trash" :class="class"></i></span>
</template>

<script>
	module.exports = {
		props: {
			canDetail: { required:false, type:Boolean, default:true },
			canEdit: { required:false, type:Boolean, default:true },
			canDelete: { required:false, type:Boolean, default:true },
			dataRow: { required:true, type: Object },
			class: { required:false, type:Array, default: function () {return ['icon','blue'];} }
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
		}
	}
</script>