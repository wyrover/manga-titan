<template>
	<a v-if="typeof items == 'string'" :href="getUrl(items)" :class="customClass">{{ items }}</a>
	<a v-else :href="getUrl(item)" :class="customClass" v-for="item in items" track-by="$index" v-text="getText(item, $index)"></a>
</template>

<script>
	module.exports = {
		props: {
			items: {
				required: false,
				type: [Array, String],
				default: function () { return []; },
			},
			format: {
				required: false,
				type: String,
				default: "{item}"
			},
			customClass: {
				required: false,
				type: Array,
				default: function () { return []; }
			}
		},
		methods: {
			getUrl: function (item) {
				var target = /\{\w+\}/ig;
				var ret = '';
				ret = this.format.replace(target, item);
				return ret;
			},
			getText: function (item, index) {
				if (index == this.items.length - 1)
					return item;
				return item + ' ';
			}
		}
	}
</script>