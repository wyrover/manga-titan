<template>
	<form :id="id_name">
		<slot></slot>
	</form>
</template>

<script>
	module.exports = {
		props: {
			id: {
				required: true,
				type: String
			},
			formAction: {
				required: false,
				type: Object,
				default: function () {return {};}
			},
		},
		computed: {
			id_name: function () {
				return 'form-' + this.id;
			}
		},
		methods: {
			getFormValues: function () {
				var submitdata = $('#' + this.id_form).serializeArray();
				var objectsubmit = {};
				$.each(submitdata, function (index, item) {
					if (item.name.endsWith("[]") && ! (item.name.replace('[]','') in objectsubmit))
						objectsubmit[item.name.replace('[]','')] = [];
					if (item.name.endsWith("[]")) 
						objectsubmit[item.name.replace('[]','')].push(item.value);
					else 
						objectsubmit[item.name] = item.value;
				});

				return objectsubmit;
			}
		},
		events: {
			'form-refresh-callback': function (data, name) {
				if (data.success && name == this.name) {
					this.$broadcast('change-page', {page_num:data.data.page_num, max_page:data.data.max_page});
					this.$broadcast('row-flash', data.data.data);
					console.log(data.data.data);
				}
			},
			'form-refresh': function () {
				if (! ("get" in this.formAction)) return;
				var param = this.getFormValues();
				var data = {
					data: param,
					client_action: this.formAction.get,
					callback: 'form-refresh-callback',
					name: this.name
				};
				this.$dispatch('ajax-action', data);
			}
		},
		ready: function () {
			this.$emit('form-refresh');
		}
	}
</script>