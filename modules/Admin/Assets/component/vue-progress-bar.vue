<template>
	<div v-show="! isHidden" class="ui indicating progress upload" :id="name + '-progress'" :data-percent="value"><div class="bar"><div class="progress"></div></div></div>
</template>

<script>
	module.exports = {
		props: {
			name: { required:true, type:String },
			isHidden: { required:false, type:Boolean, default:true }
		},
		watch: {
			'value' : function (val, oldval) {
				$('#' + this.name + '-progress').progress({percent:val});
			}
		},
		data: function () {
			return {
				value: 0
			};
		},
		events: {
			'progress-set' : function (value, name) {
				if (this.name == name)
					this.value = parseInt(value);
			},
			'progress-reset' : function (name) {
				if (this.name == name)
					this.value = 0;
			},
			'progress-complete': function (name) {
				if (this.name == name)
					this.value = 100;
			},
			'progress-hide': function (name) {
				if (this.name == name)
					this.isHidden = true;
			},
			'progress-show': function (name) {
				if (this.name == name)
					this.isHidden = false;
			}
		},
		ready: function () {
			//
		}
	}
</script>