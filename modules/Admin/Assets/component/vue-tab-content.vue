<template>
	<div class="ui tab" :data-tab="dataTab" :class="{active:active}">
		<slot></slot>
	</div>
</template>

<script>
	module.exports = {
		props: {
			active: { required: false, type: Boolean, default: false },
			dataTab: { required: true, type: String }
		}
	}
</script>