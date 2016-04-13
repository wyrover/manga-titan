<template>
	<div class="field">
		<label v-if="type_is != 'hidden'">{{ label }}</label>
		<textarea v-if="type_is == 'textarea'" :name="name" rows="2" v-model="valueReal" :placeholder="placeholder" :disabled="is_disabled"></textarea>

		<input :type="type" v-model="valueReal" v-if="type_is == 'input'" :name="name" :maxlength="maxlength" :placeholder="placeholder" :disabled="is_disabled">

		<div class="ui toggle checkbox" v-if="type_is == 'checkbox'">
			<input :name="name" type="checkbox" v-model="valueReal">
			<label>{{ placeholder }}</label>
		</div>

		<input type="hidden" v-model="valueReal" v-if="type_is == 'hidden'" :name="name">

		<select :name="name" v-if="type_is == 'dropdown'" class="ui dropdown" :multiple="multiple" :id="name + '-dropdown'">
			<option v-text="opt.text" :value="opt.value" v-for="opt in options_value"></option>
		</select>
	</div>
</template>

<script>
	module.exports = {
		props: {
			label: { required:false, type:String, default:null },
			type: { required:true, type:String },
			name: { required:true, type:String },
			maxlength: { required:false, type:Number, default:255 },
			value: { required:false, default:null },
			multiple: { required:false, type:Boolean, default:false },
			placeholder: { required:false, type:String, default:null },
			sourceData: { required: false, type:Object },			//{url:, client_action:}
			disableOnEdit: { required: false, type:Boolean, default:false }
		},
		computed: {
			type_is: function () {
				var newtype = '';
				switch (this.type) {
					case 'text':
					case 'password':
					case 'number':
					case 'email':
						newtype = 'input';
						break;
					case 'select':
						newtype = 'dropdown';
						break;
					case 'checkbox':
						newtype = 'checkbox';
						break;
					case 'file':
						newtype = 'file';
						break;
					case 'hidden':
						newtype = 'hidden';
						break;
					case 'textarea':
						newtype = 'textarea';
						break;
					default:
						newtype = 'undefined';
					break;
				}
				return newtype;
			},
			is_disabled: function () {
				if (this.is_edit)
					return this.disableOnEdit;
			}
		},
		data:function () {
			return {
				is_edit: false,
				valueReal: null,
				options_value: [] //for select if is used
			};
		},
		events: {
			'refresh-field': function () {
				if (this.type == 'select' &&
					"url" in this.sourceData &&
					"client_action" in this.sourceData) {
					var that = this;
					var data = {
						client_action: this.sourceData.client_action
					};
					this.$http.post(this.sourceData.url, data, {emulateJSON:true,timeout: 15000}).then(function (response) {
						var resdata = $.extend(response.data);

						Vue.http.headers.common['X-CSRF-TOKEN'] = resdata.new_csrf;
						that.options_value = resdata.data;
						setTimeout(function () {$('#' + that.name + '-dropdown').dropdown();}, 400);
					});
				}
			},
			'flash-field': function (data) {
				if (this.disableOnEdit) {
					this.valueReal = this.value;
				}
				if (this.name in data) {
					this.valueReal = data[this.name];
				}
				this.is_edit = true;
			},
			'clear-field': function () {
				this.is_edit = false;
				this.valueReal = null;
			}
		},
		ready: function () {
			this.valueReal = this.value;
			this.$emit('refresh-field');
		}
	}
</script>