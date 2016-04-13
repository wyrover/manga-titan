<style>
	.expand-transition {
	  transition: all .3s ease;
	}

	.expand-enter, .expand-leave {
	  opacity: 0;
	}
</style>

<template>
	<form :id="id_form" :name="id_form" class="ui form" v-show="!isHidden" transition="expand" method="post">
		<slot></slot>
	</form>
</template>

<script>
	module.exports = {
		props: {
			name: { required: true, type:String },
			formTargetAdd: { required: false, type:String, default:null },
			formTargetEdit: { required: false, type:String, default:null },
			formAction: { required: false, type:Object },		//get, delete, save
			isHidden: { required: false, type:Boolean }
		},
		data: function () {
			return {
				page_num: 0
			};
		},
		computed: {
			id_form: function () {
				return 'form-' + this.name;
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
						this.$emit('form-cancel', true);
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
				var data = {
					data: {
						page_num: (this.page_num == 0)?1:this.page_num
					},
					client_action: this.formAction.get,
					callback: 'form-refresh-callback',
					name: this.name
				};
				this.$dispatch('ajax-action', data);
			},
			'form-delete': function () {
				if (! ("delete" in this.formAction)) return;
				var submitdata = $('#' + this.id_form).serializeArray();
				var ids = [], id = null;
				$.each(submitdata, function (index, item) {
					if (item.name == 'id')
						id = item.value;
					if (item.name == 'id[]')
						ids.push(item.value);
				});
				var that = this;
				var confirm = {
					title: "Delete Selected",
					text: "Are you sure to delete selected data?",
					onconfirm: function () {
						var param = {
							data: {
								id: (id!=null)?id:ids
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
			'form-save': function () {
				if (! ("save" in this.formAction)) return;
				var submitdata = $('#' + this.id_form).serializeArray();
				var objectsubmit = {};
				$.map(submitdata, function (item, index) {
					objectsubmit[item.name] = item.value;
				});

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
				this.$dispatch('form-edit', data, this.formTargetEdit);
			},
			'row-detail': function (data) {
				var data2 = null; //I don't have idea for this
			},
			/////////////////////////////////////////////////////////////////////////////////
			'page-changed': function (page_num) {
				this.page_num = page_num;
				this.$emit('form-refresh');
			}
		},
		ready: function () {
			this.$emit('form-refresh');
		}
	}
</script>