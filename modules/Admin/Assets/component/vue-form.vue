<style>
	.expand-transition {
	  transition: all .3s ease;
	}

	.expand-enter, .expand-leave {
	  opacity: 0;
	}
</style>

<template>
	<form :id="id_form" :name="id_form" class="ui form" v-show="!isHidden" transition="expand" method="post" v-on:submit.prevent="submit">
		<slot></slot>
		<input type="hidden" :name="item.name" :value="item.value" v-for="item in additionalParam">
	</form>
</template>

<script>
	module.exports = {
		props: {
			name: { required: true, type:String },
			formTargetAdd: { required: false, type:String, default:null },
			formTargetEdit: { required: false, type:String, default:null },
			formAction: { required: false, type:Object, default:function () {return {};} },		//get, delete, save
			hideOnSave: { required: false, type:Boolean, default: true },
			isHidden: { required: false, type:Boolean },
			optionalParam: { required:false, type:Object, default:function () {return {};} }
		},
		data: function () {
			return {};
		},
		computed: {
			id_form: function () {
				return 'form-' + this.name;
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
			submit: function () {
				this.$emit('form-save', {}, this.name);
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
			'form-delete-callback': function (data, name) {
				if (this.name == name) {
					if (data.success) {
						var notify = {title: 'Save Success', text: data.message};
						this.$dispatch('form-refresh');
						this.$dispatch('form-close', this.formTargetAdd);
						this.$dispatch('form-close', this.formTargetEdit);
						this.$dispatch('app-notify', notify);
					} else {
						var notify = {title: 'Delete Failed', text: data.message, type:'error'};
						this.$dispatch('app-notify', notify);
					}
				}
			},
			'form-save-callback': function (data, name) {
				if (this.name == name) {
					if (data.success && name == this.name) {
						var notify = {title: 'Save Success', text: data.message};
						this.$dispatch('form-refresh');
						this.$dispatch('app-notify', notify);
						if (this.hideOnSave) this.$emit('form-cancel');
					} else {
						var notify = {title: 'Save Failed', text: data.message, type:'error'};
						this.$dispatch('app-notify', notify);
					}
				}
			},
			'form-refresh-callback': function (data, name) {
				if (data.success && name == this.name) {
					this.$broadcast('change-page', {page_num:data.data.page_num, max_page:data.data.max_page});
					this.$broadcast('row-flash', data.data.data);
				}
			},
			////////////////////////////////////////////////////////////////////////////
			'form-add': function () {
				this.$dispatch('form-new', this.formTargetAdd);
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
			},
			'form-delete': function () {
				if (! ("delete" in this.formAction)) return;
				var objectsubmit = this.getFormValues();
				var that = this;
				var confirm = {
					title: "Delete Selected",
					text: "Are you sure to delete selected data?",
					onconfirm: function () {
						var param = {
							data: {
								id: objectsubmit.id
							},
							client_action:that.formAction.delete,
							callback:'form-delete-callback',
							name: that.name
						};
						that.$dispatch('ajax-action', param);
					}
				};
				this.$dispatch('app-confirm', confirm);
			},
			'form-cancel': function () {
				this.isHidden = true;
			},
			'form-save': function (newparam, name) {
				if (! ("save" in this.formAction)) return;

				var objectsubmit = this.getFormValues();
				if (typeof name != 'undefined' && typeof newparam != 'undefined' && this.name == name)
					objectsubmit = $.extend({},objectsubmit, newparam);

				var data = {
					data: objectsubmit,
					client_action: this.formAction.save,
					callback: 'form-save-callback',
					name: this.name
				};

				this.$dispatch('ajax-action', data);
			},
			'form-new': function (name) {
				if (this.name == name) {
					this.$broadcast('clear-field');
					this.isHidden = false;
				}
			},
			'form-edit': function (data, name) {
				if (this.name == name) {
					this.$broadcast('flash-field', data);
					this.isHidden = false;
				}
			},
			'form-close': function (name) {
				if (this.name == name)
					this.$emit('form-cancel');
			},
			'form-detail': function (data, name) {
				if (this.name == name) {
					this.$emit('form-refresh');
					this.isHidden = false;
				}
			},
			///////////////////////////////////////////////////////////////////////////////
			'row-delete': function (data) {
				if (!("delete" in this.formAction)) return;
				var that = this;
				var confirm = {
					title: 'Delete data',
					text: 'Are you sure to delete this data?',
					onconfirm: function (newvalue) {
						var param = {
							data: data,
							client_action:that.formAction.delete,
							callback:'form-delete-callback',
							name: that.name
						};
						that.$dispatch('ajax-action', param);
					}
				};
				this.$dispatch('app-confirm', confirm);
			},
			'row-edit': function (data) {
				if (this.formTargetEdit == null) return;
				this.$dispatch('form-edit', data, this.formTargetEdit);
			},
			'row-detail': function (data) {
				if (this.formTargetDetail == null) return;
				this.$dispatch('form-detail', data, this.formTargetDetail);
			},
			/////////////////////////////////////////////////////////////////////////////////
			'page-changed': function () {
				this.$emit('form-refresh');
			}
		},
		ready: function () {
			this.$emit('form-refresh');
		}
	}
</script>