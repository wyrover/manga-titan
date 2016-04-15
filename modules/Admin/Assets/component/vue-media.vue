<style>
	.ui.modal.form-modal {
		border-radius: 0;
	}
	.ui.grid > form.no-style {
		padding:0;
	}
	.form-modal .sortable.grid li .extra.content {
		display: none;
	}
	.form-modal .sortable.grid li .dimm {
		top: 0px;
	}
</style>

<template>
	<div class="ui long fullscreen modal form-modal" :id="id_form + '-modal'">
		<div class="header">
			{{ title }}
			<div class="ui small icon buttons right floated">
				<button class="ui green button" @click="triggerUpload"><i class="icon upload"></i></button>
				<button class="ui primary button" @click="mediaSubmit"><i class="icon checkmark"></i></button>
				<button class="ui red button" @click="mediaClose"><i class="icon remove"></i></button>
			</div>
		</div>
		<div class="content" style="min-height:350px;">
			<form :name="id_form" method="post" class="no-style form-admin" :id="id_form">
				<vue-form-list
				list-type="grid"
				primary-id="image"
				:can-edit="false"
				:can-delete="false"
				:can-detail="false"
				:maps="{
				title: 'page',
				image: 'image'
				}"
				></vue-form-list>
				<vue-file-upload
				name="modal-form-upload"
				type="image"
				:multiple="true"
				:is-show="false"></vue-file-upload>
				<vue-progress-bar :name="name"></vue-progress-bar>
			</form>
		</div>
	</div>
</template>

<script>
	module.exports = {
		props: {
			name: { required: true, type:String },
			title: { required:false, type:String, default:'Media Manager'},
			formAction: { required: false, type:Object, default:function () {return {};} },
			formTargetSet: { required:true, type:String },
			optionalParam: { required:false, type:Object, default:function () {return {};} }
		},
		computed: {
			id_form: function () {
				return 'form-' + this.name;
			}
		},
		methods: {
			mediaSubmit: function () {
				this.$emit('media-submit');
			},
			mediaClose: function () {
				this.$emit('media-close');
			},
			triggerUpload: function() {
				this.$broadcast('input-field');
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
			'media-submit' : function () {
				this.$dispatch('form-save', this.getFormValues(), this.formTargetSet);
				this.$emit('media-close');
			},
			'media-close': function () {
				$('#' + this.id_form + '-modal').modal('hide');
			},
			'form-new': function (name) {
				if (this.name == name) {
					this.$broadcast('clear-field');
					$('#' + this.id_form + '-modal').modal({observeChanges:true}).modal('show');
				}
			},
			'upload-progress': function (command, value) {
				switch (command) {
					case 'progress-set':
						this.$broadcast(command, value, this.name);break;
					case 'progress-complete':
					case 'progress-hide':
					case 'progress-show':
					case 'progress-reset':
						this.$broadcast(command, this.name);break;
				}
			},
			'upload-complete': function () {
				var values = this.getFormValues();
				var newval = [];
				$.each(values['modal-form-upload'], function(index, item) {
					newval.push({id:index, image: item, page: 'Page ' + (index+1) });
				});
				this.$broadcast('row-flash', newval, true);
				this.$broadcast('clear-field');
			}
		},
		ready: function () {}
	}
</script>