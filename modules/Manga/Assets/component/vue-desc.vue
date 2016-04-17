<template>
	<div :class="leftClass">
		<slot name="left"></slot>
	</div>
	<div :class="rightClass">
		<slot name="right"></slot>
	</div>
</template>

<script>
	module.exports = {
		props: {
			leftSize: {
				required: false,
				type: String,
				default: 'four'
			},
			rightSize: {
				required: false,
				type: String,
				default: 'twelve'
			}
		},
		computed: {
			leftClass: function () {
				return [this.leftSize, 'wide', 'column'];
			},
			rightClass: function () {
				return [this.rightSize, 'wide', 'column'];
			}
		}
	}
</script>