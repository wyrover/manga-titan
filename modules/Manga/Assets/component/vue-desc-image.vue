<template>
	<img :src="src" class="ui image medium">
</template>

<script>
	module.exports = {
		props: {
			name: {
				required: true,
				type: String
			}
		},
		computed: {
			src: function () {
				if (this.image == null || this.image == '')
					return '/manga/image/thumb/dummy.png';

				return '/manga/image/thumb/' + this.image;
			}
		},
		data: function () {
			return {
				image: null
			};
		},
		events: {
			'row-flash': function (data) {
				if (this.name in data)
					this.image = data[this.name];
			}
		}
	}
</script>