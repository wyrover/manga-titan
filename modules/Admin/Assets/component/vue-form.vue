<style>
.expand-transition {
  transition: all .3s ease;
}

.expand-enter, .expand-leave {
  opacity: 0;
}
</style>

<template>
<form :id="id_form" :name="id_form" class="ui form" v-if="!isHidden" transition="expand" method="post">
	<slot></slot>
</form>
</template>

<script>
	module.exports = {
		props: {
			name: { required: true, type:String },
			formTargetAdd: { required: false, type:String },
			formTargetEdit: { required: false, type:String },
			formAction: { required: false, type:Object },		//get, delete, save
			isHidden: { required: false, type:Boolean }
		},
		computed: {
			id_form: function () {
				return 'form-' + this.name;
			}
		},
		events: {
			'form-refresh-callback': function (data, name) {
				if (data.success && name == this.name) {
					this.$broadcast('row-flash', data.data.data);
					this.$broadcast('change-page', {page_num:data.data.page_num, max_page:data.data.max_page});
				}

			},
			////////////////////////////////////////////////////////////////////////////
			'form-add': function () {
				this.$dispatch('form-new', this.formTargetAdd);
			},
			'form-refresh': function () {
				if (! ("get" in this.formAction)) return;
				var data = {
					data: {},
					client_action: this.formAction.get,
					callback: 'form-refresh-callback',
					name: this.name
				};
				this.$dispatch('ajax-action', data);
			},
			'form-delete': function () {
				//
			},
			'form-cancel': function () {
				this.isHidden = true;
			},
			'form-save': function () {
				//
			},
			'form-new': function (name) {
				if (this.name == name)
					this.isHidden = false;
			},
			'form-edit': function (name, data) {
				//
			}
		},
		ready: function () {
			this.$emit('form-refresh');
		}
	}
</script>