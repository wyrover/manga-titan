<template>
	<a href="#" v-if="canDetail" @click="rowDetail"><i class="icon blue detail"></i></a>
	<a href="#" v-if="canEdit" @click="rowEdit"><i class="icon blue pencil"></i></a>
	<a href="#" v-if="canDelete" @click="rowDelete"><i class="icon blue trash"></i></a>
</template>

<script>
	module.exports = {
		props: {
			canDetail: { required:false, type:Boolean, default:true },
			canEdit: { required:false, type:Boolean, default:true },
			canDelete: { required:false, type:Boolean, default:true },
			dataRow: { required:true, type: Object }
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