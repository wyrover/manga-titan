<style>
	.ui.modal.form-modal {
		border-radius: 0;
	}
	.ui.grid > form.no-style {
		padding:0;
	}
</style>

<template>
	<div class="ui long fullscreen modal form-modal" :id="id_form + '-modal'">
		<i class="icon close"></i>
		<div class="header">{{ title }}</div>
		<div class="content" style="min-height:350px;">
			<form :name="id_form" method="post" class="no-style form-admin" :id="id_form">
				<vue-form-list
				list-type="grid"
				:can-edit="false"
				:can-delete="false"
				:can-detail="false"
				:maps="{
				title: 'image',
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
		<div class="actions">
			<button class="ui labeled icon button" @click="triggerUpload" type="button"><i class="icon upload"></i> Upload</button>
			<button class="ui labeled icon approve green button"><i class="checkmark icon"></i>Select</button>
			<button class="ui labeled cancel red icon button"><i class="icon remove"></i> Cancel</button>
		</div>
	</div>
</template>

<script>
	module.exports = {
		props: {
			name: { required: true, type:String },
			title: { required:false, type:String, default:'Media Manager'},
			formAction: { required: false, type:Object, default:function () {return {};} },
			optionalParam: { required:false, type:Object, default:function () {return {};} }
		},
		computed: {
			id_form: function () {
				return 'form-' + this.name;
			}
		},
		methods: {
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
			'form-save': function () {
				//
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
					newval.push({id:index, image: item});
				});
				this.$broadcast('row-flash', newval, true);
			}
		},
		ready: function () {}
	}
</script>