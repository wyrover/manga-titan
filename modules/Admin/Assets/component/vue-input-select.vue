<template>
	<div class="field">
		<label>{{ label }}</label>
		<select v-if="multiple" :name="name + '[]'" class="ui addition dropdown search" :multiple="multiple" :id="name + '-dropdown'" v-model="values">
			<option v-text="opt.text" :value="opt.value" v-for="opt in options_value"></option>
		</select>

		<select v-else :name="name" class="ui addition dropdown search" :multiple="multiple" :id="name + '-dropdown'" v-model="value">
			<option v-text="opt.text" :value="opt.value" v-for="opt in options_value"></option>
		</select>
	</div>
</template>

<script>
	module.exports = {
		props: {
			label: { required:false, type:String, default:null },
			name: { required:true, type:String },
			multiple: { required:false, type:Boolean, default:false },
			sourceData: { required: false, type:Object },
			allowAddValue: { required: false, type:Boolean, default:false }
		},
		data: function () {
			return {
				value: null,
				values: [],
				options_value: [],
				is_edit:false
			};
		},
		events: {
			'refresh-field': function () {
				if ("url" in this.sourceData && "client_action" in this.sourceData) {
					var that = this;
					var data = {
						client_action: this.sourceData.client_action
					};
					this.$http.post(this.sourceData.url, data, {emulateJSON:true,timeout: 15000}).then(function (response) {
						var resdata = $.extend(response.data);

						Vue.http.headers.common['X-CSRF-TOKEN'] = resdata.new_csrf;
						that.options_value = resdata.data;
						setTimeout(function () {$('#' + that.name + '-dropdown').dropdown({allowAdditions:true}).dropdown('clear');}, 400);
					});
				}
			},
			'flash-field': function (data) {
				if (this.name in data) {
					$('#' + this.name + '-dropdown').parent().dropdown('set exactly',data[this.name]).dropdown('refresh');
				}
				this.is_edit = true;
			},
			'clear-field': function () {
				this.value = null;
				this.values = [];
				$('#' + this.name + '-dropdown').dropdown('clear');
			}
		},
		ready: function () {
			this.$emit('refresh-field');
		}
	}
</script>