<template>
<div class="row">
	<div class="sixteen wide column">
	<div class="ui pagination menu" v-if="pages > 0">
		<a class="item" :class="{active: (i + min_pos == page_num)}" v-for="i in pages" @click="pageClicked(i + min_pos)">
			{{ i + min_pos}}
		</a>
	</div>
	</div>
</div>
</template>

<script>
	module.exports = {
		data: function () {
			return {
				page_num: 1,
				max_page: 0
			};
		},
		computed: {
			min_pos: {
				get:function () {
					if (this.page_num - 5 > 1 && this.page_num > 5)
						return this.page_num-5;
					else
						return 1;
				}
			},
			max_pos: {
				get: function () {
					if (this.page_num + 5 <= this.max_page && this.page_num > 5)
						return this.page_num+5;
					else
						if (this.page_num <= 5 && this.max_page > 10)
							return 10;
						else
							return this.max_page;
				}
			},
			pages: {
				get: function() {
					return this.max_pos - this.min_pos + 1;
				}
			}
		},
		methods: {
			pageClicked: function (page) {
				this.$dispatch('changed-page', {page: page});
			}
		},
		events: {
			'change-page': function (data) {
				this.page_num = data.page_num;
				this.max_page = data.max_page;
			}
		}
	};
</script>