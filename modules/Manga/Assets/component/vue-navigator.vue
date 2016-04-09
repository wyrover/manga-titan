<style>
	.ui.fullwidth.rail {
		left:calc( 50% - 90px);
		width: 190px !important;
	}
	.ui.link.dropdown.page.item {
		border: none !important;
		border-radius: 0;
		min-width: unset;
	}
	.ui.link.dropdown.page.item > .icon.dropdown {
		display: none;
	}
</style>

<template>
<div class="ui fullwidth rail">
	<div class="ui sticky" id="navigator">
		<div class="ui compact menu">
			<a class="item icon" @click="prevPage"><i class="icon chevron circle left"></i></a>
			<select class="ui link dropdown item page">
				<option v-for="i in max_page" :value="i + 1">Page {{ i + 1 }}</option>
			</select>
			<a class="item icon" @click="nextPage"><i class="icon chevron circle right"></i></a>
		</div>
	</div>
</div>
</template>

<script>
	module.exports = {
		props: {
			page: { required: true, type: Number },
			maxPage: { required: true, type: Number }
		},
		data: function () {
			return {
				max_page: 0,
				page_num: 0
			}
		},
		methods: {
			nextPage: function () {
				if (this.page_num < this.max_page)
					this.page_num++;
				this.$emit('page-change');
			},
			prevPage: function () {
				if (this.page_num > 1)
					this.page_num--;
				this.$emit('page-change');
			},
			pageSelected: function (page) {
				this.page_num = page;
				this.$emit('page-change');
			}
		},
		events: {
			'page-change': function () {
				$('.ui.dropdown.link.item.page').dropdown('set selected', this.page_num);
				this.$dispatch('page-changed', this.page_num);
			}
		},
		ready: function () {
			var that = this;
			this.max_page = this.maxPage;
			this.page_num = this.page;
			$('#navigator').sticky({context:$('#context') });
			$('.ui.dropdown.link.page.item').dropdown({
				onChange: function (val) {
					that.pageSelected(val);
				}
			});
			$(document).keyup(function (e) {
				var keyCode = e.keyCode;
				switch (keyCode) {
					case 37:
						that.prevPage();
						break;
					case 39:
						that.nextPage();
						break;
				}
			});
			setTimeout(function () {that.$emit('page-change');}, 200);
		}
	}
</script>