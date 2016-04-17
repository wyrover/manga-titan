<template>
	<div class="ui pointing secondary menu form-tab" :id="id_name">
		<a class="item" :class="{active:tab.isactive}" href="#" v-for="tab in tabs" :data-tab="tab.datatab">{{ tab.title }}</a>
	</div>
</template>

<script>
	module.exports = {
		props: {
			name: { required: true, type: String },
			tabs: { required: true, type: Array }
		},
		computed: {
			id_name: function () {
				return this.name + '-tab';
			}
		},
		ready: function () {
			$('#' + this.id_name + ' .item').tab();
		}
	}
</script>