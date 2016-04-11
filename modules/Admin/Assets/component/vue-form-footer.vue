<template>
	<input name="page-num" type="hidden" v-model="page_num">
	<input name="max_page" type="hidden" v-model="max_page">
	<div class="ui blue segment form-footer">
		<div class="ui small buttons">
			<button disabled="" class="ui blue icon button"><i class="left chevron icon"></i></button>
			<button disabled="" class="ui blue basic button">1</button>
			<button disabled="" class="ui blue icon button"><i class="right chevron icon"></i></button>
		</div>
	</div>
</template>

<script>
	module.exports = {
		props: {
			maxPage: { required: false, type:Number, default:0 },
			pageNum: { required: false, type:Number, default:0 }
		},
		data: function () {
			return {
				max_page: 0,
				page_num: 0
			}
		},
		events: {
			'change-page': function (data) {
				this.page_num = data.page_num;
				this.max_page = data.max_page;
			}
		},
		ready: function () {
			this.max_page = this.maxPage;
			this.page_num = this.pageNum;
		}
	}
</script>