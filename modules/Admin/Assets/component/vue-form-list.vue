<template>
	<div class="ui segment form-content">
		<table class="ui very basic selectable table form-table">
			<thead>
				<tr>
					<th><div class="ui fitted checkbox"><input type="checkbox" v-model="checkall"> <label></label></div></th>
					<th v-for="col in columns">{{ col }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in data_list" v-if="data_list.length > 0">
					<td class="collapsing">
						<div class="ui fitted checkbox">
							<input type="checkbox" name="id[]" :value="item[primaryId]" v-model="check_list"><label></label>
						</div>
					</td>
					<td v-for="key in keys" v-html="item[key]"></td>
					<td>
						<vue-row-control
						:can-detail="canDetail"
						:can-edit="canEdit"
						:can-delete="canDelete"
						:data-row="item"></vue-row-control>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	module.exports = {
		props: {
			maps: { required:true, type:Object },
			canDetail: { required:false, type:Boolean, default:true },
			canEdit: { required:false, type:Boolean, default:true },
			canDelete: { required:false, type:Boolean, default:true },
			primaryId: { required:true, type: String }
		},
		data:function () {
			return {
				data_list: [],
				check_list: []
			};
		},
		computed: {
			checkall: {
				set: function (val) {
					this.check_list = [];
					if (val) {
						var that = this;
						$.each (this.data_list, function (index, item) {
							that.check_list.push(item[that.primaryId]);
						});
					}
				},
				get: function () {
					if (this.check_list.length == this.data_list.length)
						return true;
					return false;
				}
			},
			columns: function () {
				var col = $.map(this.maps, function (item, index) {
					return item;
				});
				return col;
			},
			keys: function () {
				var key = $.map(this.maps, function (item, index) {
					return index;
				});
				return key;
			}
		},
		events: {
			'row-flash': function (data) {
				if (typeof data != 'undefined')
					this.data_list = data;
			},
			'row-clear': function () {
				this.data_list = [];
			},
			'row-detail': function () {return true;},
			'row-edit': function () {return true;},
			'row-delete': function () {return true;}
		}
	}
</script>