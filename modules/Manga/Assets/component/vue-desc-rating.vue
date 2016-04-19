<template>
	<div class="ui star desc rating"></div> ({{dataDesc.rating}}) {{dataDesc.votes}} {{dataDesc.votes | pluralize 'Vote'}}
</template>

<script>
	module.exports = {
		props: {
			dataDesc: {
				required: false,
				type: Object,
				default: function () {
					return { rating: 0, votes: 0, enable: false };
				}
			}
		},
		watch: {
			'dataDesc': function (val, old) {
				//
			}
		},
		data: function () {
			return {};
		},
		computed: {
			dataRating: function () {
				return parseInt(Math.floor(this.dataDesc.rating));
			}
		},
		methods: {
			rateme: function (rate) {
				//
			}
		},
		ready: function () {
			var that = this;
			this.$nextTick(function () {
				$(".ui.star.rating.desc").rating({
					initialRating: 3,
					maxRating: 5,
					clearable: false,
					interactive: that.dataDesc.enable,
					onRate: function (rate) {
						that.rateme(rate);
					}
				});
			});
		}
	}
</script>