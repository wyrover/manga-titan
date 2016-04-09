<template>
<div class="ui one column grid">
	<div class="row">
	<div class="column">
		<slot></slot>
	</div>
	</div>
</div>
</template>

<script type="text/javascript">
	module.exports = {
		props: {
			mangaId: {required: true, type: Number}
		},
		data: function () {
			return {
				manga_id: 0
			};
		},
		events: {
			'get-page-callback': function (data) {
				if (data.success) {
					this.$broadcast('flash-page', data.data);
				}
			},
			'get-page': function () {
				var data = {
					data: {
						manga_id: this.manga_id
					},
					client_action: 'get-pages-for-view',
					callback: 'get-page-callback'
				};
				this.$dispatch('ajax-action', data);
			},
			'page-changed': function (data) {
				return this.$broadcast('change-page',data);
			}
		},
		ready: function () {
			this.manga_id = this.mangaId;
			this.$emit('get-page');
		}
	}
</script>