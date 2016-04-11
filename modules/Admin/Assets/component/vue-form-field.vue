<template>
	<div class="field">
		<label v-if="type_is != 'hidden'">{{ label }}</label>
		<input :type="type" v-model="valueReal" v-if="type_is == 'input'" :name="name" :maxlength="maxlength" :placeholder="placeholder" :disabled="is_disabled">

		<div class="ui toggle checkbox" v-if="type_is == 'checkbox'">
			<input :name="name" type="checkbox" v-model="valueReal">
			<label>{{ placeholder }}</label>
		</div>

		<input type="hidden" v-model="valueReal" v-if="type_is == 'hidden'" :name="name">
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
			multiple: { required:false, type:Boolean, default:null },
			placeholder: { required:false, type:String, default:null },
			sourceData: { required: false, type:Object },
			disableOnEdit: { required: false, type:Boolean, default:false }
		},
		computed: {
			type_is: function () {
				var newtype = '';
				switch (this.type) {
					case 'text':
					case 'password':
					case 'number':
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
				valueReal: null
			};
		},
		events: {
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
		}
	}
</script>