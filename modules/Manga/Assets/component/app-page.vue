<template>
	<div class="ui grid container">
		<slot></slot>
	</div>
</template>

<script>
	module.exports = {
		props:{
			urlAjax: {required: true, type:String}
		},
		data: function () {
			return {};
		},
		methods: {
			appInput: function (data) {
				if (! "type" in data) data.type="text";
				if (! "value" in data) data.value="";
				swal({
					title: data.title,
					html: '<p><input id="input-confirm" type="' + data.type + '" value="'+ data.value +'"></p>',
					confirmButtonClass: 'ui button',
					cancelButtonClass: 'ui button',
					closeOnConfirm:false,
					showCancelButton:true,
					showConfirmButton:true,
					allowEscapeKey:false,
					allowOutsideClick: false
				}, function () {
					swal.disableButtons();
					var newvalue = $('#input-confirm').val();
					$('#input-confirm').val('');
					data.onconfirm && data.onconfirm.call( this, newvalue );
				});
			},
			appNotify: function (data) {
				swal({
					title:data.title,
					text:data.text,
					type: ("type" in data)?data.type:'success',
					timer: 1400,
					showConfirmButton:false
				});
			},
			appConfirm: function (data) {
				swal({
					title: data.title,
					text: data.text,
					type: 'warning',
					confirmButtonClass: 'ui button',
					cancelButtonClass: 'ui button',
					showCancelButton:true,
					showConfirmButton:true,
					closeOnConfirm:false,
					allowEscapeKey:false,
					allowOutsideClick: false
				}, function () {
					swal.disableButtons();
					data.onconfirm && data.onconfirm();
				});
			},
			appAjax: function (data) {
				var that = this;
				this.$http.post(this.urlAjax, data, {emulateJSON:true,timeout: 15000}).then(function (response) {
					var resdata = $.extend(response.data);

					Vue.http.headers.common['X-CSRF-TOKEN'] = resdata.new_csrf;

					that.$broadcast(data.callback, resdata, data.name);
				}, function(failresponse) {
					swal({
						title:failresponse.status,
						text:failresponse.statusText,
						type: 'error',
						showConfirmButton:true
					});
				});
			}
		},
		events: {
			'form-refresh': function () {return this.$broadcast('form-refresh');},
			'app-notify': function(data) {return this.appNotify(data);},
			'app-confirm': function (data) {return this.appConfirm(data);},
			'app-input': function (data) {return this.appInput(data);},
			'ajax-action': function (data) {return this.appAjax(data);}
		}
	}
</script>