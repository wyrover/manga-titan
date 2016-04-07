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
			appNotify: function (data) {
				swal({
					title:data.title,
					text:data.text,
					type: ("type" in data)?data.type:'success',
					timer: 1000,
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

					that.$broadcast(data.callback, resdata);
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
			'new-manga': function() {return this.$broadcast('new-manga');},
			'edit-manga': function (data) {return this.$broadcast('edit-manga',data);},
			'refresh-manga': function() {return this.$broadcast('refresh-manga');},
			'hide-form-manga': function () {return this.$broadcast('hide-form-manga');},
			'show-page': function (data) {return this.$broadcast('show-page',data);},
			'app-notify': function(data) {return this.appNotify(data);},
			'app-confirm': function (data) {return this.appConfirm(data);},
			'ajax-action': function (data) {return this.appAjax(data);}
		},
		ready: function () {
			$('.ui.button.upload').click(function (){
				$(this).parent().find("input[type='file']").trigger('click');
			});
		}
	}
</script>