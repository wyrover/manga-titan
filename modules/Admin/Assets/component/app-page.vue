<template>
	<div class="ui grid" id="admin-grid">
		<slot></slot>
	</div>
</template>

<script>
	module.exports = {
		data: function () {
			return {};
		},
		events: {
			'new-manga': function() {return this.$broadcast('new-manga');}
		},
		ready: function () {
			$('.ui.button.upload').click(function (){
				$(this).parent().find("input[type='file']").trigger('click');
			});
		}
	}
</script>