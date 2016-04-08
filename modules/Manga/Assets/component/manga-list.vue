<template>
	<slot></slot>
</template>
<script>
	module.exports = {
		data: function () {
			return {
				filter: {},
				page_num: 0
			};
		},
		events: {
			'refresh-manga-callback': function (data) {
				//
			},
			'refresh-manga-list': function () {
				var data = {
					data: {
						filter: this.filter,
						page_num: this.page_num
					},
					client_action: 'filter-manga',
					callback: 'refresh-manga-callback'
				};
				this.$dispatch('ajax-action', data);
			},
			'filter-changed': function (filter) {
				this.filter = filter;
				this.$emit('refresh-manga-list');
			},
			'page-changed': function (page) {
				this.page_num = page;
				this.$emit('refresh-manga-list');
			}
		},
		ready: function () {
			this.$emit('refresh-manga-list');
		}
	};
</script>