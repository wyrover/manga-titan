<template>
	<i class="icon file"></i> {{rowData.page}} <i class="icon unhide"></i> {{rowData.views}}
</template>

<script>
	module.exports = {
		props: {
			rowData: {
				required: true,
				type: Object
			}
		}
	}
</script>