<template>
	<div class="ui segment form-field">
		<slot></slot>
	</div>
</template>

<script>
	module.exports = {
		events: {
			'flash-field': function (data) {return true;},
			'clear-field': function (data) {return true;}
 		}
	};
</script>