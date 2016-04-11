<template>
	<input type="hidden" name="primaryId" :value="primaryId">
	<div class="ui segment form-content">
		<table class="ui very basic selectable table form-table">
			<thead>
				<tr>
					<th><div class="ui fitted checkbox"><input type="checkbox"> <label></label></div></th>
					<th v-for="col in columns">{{ col }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in data_list" v-if="data_list.length > 0">
					<td class="collapsing">
						<div class="ui fitted checkbox">
							<input type="checkbox" name="ids[]" :value="item[primaryId]"><label></label>
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
	/// { key: '', value: '', filter: '' }
	module.exports = {
		props: {
			maps: { required:true, type:Object },
			primaryId: { required:true, type:String },
			canDetail: { required:false, type:Boolean, default:true },
			canEdit: { required:false, type:Boolean, default:true },
			canDelete: { required:false, type:Boolean, default:true },
		},
		data:function () {
			return {
				data_list: [],
			};
		},
		computed: {
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