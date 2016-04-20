 <template>
	<form :id="id_form" :name="id_form" v-on:submit.prevent="submit">
		<div class="ui stackable grid manga-grid">
			<slot></slot>
		</div>
		<input type="hidden" :name="item.name" :value="item.value" v-for="item in additionalParam">
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
			optionalParam: {
				required:false,
				type:Object,
				default:function () {return {};}
			}
		},
		computed: {
			id_form: function () {
				return 'form-' + this.id;
			},
			name: function () {
				return this.id;
			},
			additionalParam: function () {
				var param = [];
				$.each(this.optionalParam, function (key, item) {
					if (typeof item == 'Array') {
						$.each(item, function (index, value) {
							param.push({name:key + '[]', value:value});
						});
					} else {
						param.push({name:key, value:item});
					}
				});
				return param;
			}
		},
		methods: {
			submit: function() {
				this.$emit('form-save',{},this.id_form);
			},
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
			'form-save-callback': function (data, name) {
				if (this.id_form == name) {
					if (data.success && name == this.id_form) {
						var notify = {title: 'Save Success', text: data.message};
						this.$dispatch('form-refresh');
						this.$dispatch('app-notify', notify);
						this.$emit('form-reset');
						if (this.hideOnSave) this.$emit('form-cancel');
					} else {
						var notify = {title: 'Save Failed', text: data.message, type:'error'};
						this.$dispatch('app-notify', notify);
					}
				}
			},
			'form-refresh-callback': function (data, name) {
				if (data.success && name == this.id_form) {
					this.$broadcast('change-page', {page_num:data.data.page_num, max_page:data.data.max_page});
					this.$broadcast('row-flash', data.data.data);
				}
			},
			'form-reset': function () {
				$('#' + this.id_form)[0].reset();
			},
			'form-refresh': function () {
				if (! ("get" in this.formAction)) return;
				var param = this.getFormValues();
				var data = {
					data: param,
					client_action: this.formAction.get,
					callback: 'form-refresh-callback',
					name: this.id_form
				};
				this.$dispatch('ajax-action', data);
			},
			'form-save': function (newparam, name) {
				if (! ("save" in this.formAction)) return;

				var objectsubmit = this.getFormValues();
				if (typeof name != 'undefined' && typeof newparam != 'undefined' && this.id_form == name)
					objectsubmit = $.extend({},objectsubmit, newparam);

				var data = {
					data: objectsubmit,
					client_action: this.formAction.save,
					callback: 'form-save-callback',
					name: this.id_form
				};

				this.$dispatch('ajax-action', data);
			},
			'page-changed': function () {
				this.$emit('form-refresh');
			}
		},
		ready: function () {
			this.$emit('form-refresh');
		}
	}
</script>