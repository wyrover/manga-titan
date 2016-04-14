<template>
	<div class="ui grid" id="admin-grid">
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
			'form-close': function (name) { return this.$broadcast('form-close', name);},
			'form-edit': function (data,name) {return this.$broadcast('form-edit', data, name);},
			'form-refresh': function () {return this.$broadcast('form-refresh');},
			'form-new': function (name) {return this.$broadcast('form-new',name);},
			'form-detail': function (data, name) {return this.$broadcast('form-detail',data, name);},
			'new-manga': function() {return this.$broadcast('new-manga');},
			'edit-manga': function (data) {return this.$broadcast('edit-manga',data);},
			'refresh-manga': function() {return this.$broadcast('refresh-manga');},
			'hide-form-manga': function () {return this.$broadcast('hide-form-manga');},
			'show-page': function (data) {return this.$broadcast('show-page',data);},
			'app-notify': function(data) {return this.appNotify(data);},
			'app-confirm': function (data) {return this.appConfirm(data);},
			'app-input': function (data) {return this.appInput(data);},
			'ajax-action': function (data) {return this.appAjax(data);}
		},
		ready: function () {
		}
	}
</script>