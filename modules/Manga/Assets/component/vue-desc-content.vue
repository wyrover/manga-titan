<template>
<table class="ui basic definition table">
    <tbody v-if="remap.length > 0">
        <tr v-for="item in remap">
            <td v-text="item.label"></td>
            <td v-if="item.type=='text'" v-text="tmpdata[item.key]"></td>
            <td v-if="item.type=='rating'"><vue-desc-rating :data-desc="tmpdata[item.key]"></vue-desc-rating></td>
            <td v-else></td>
        </tr>
    <!-- <tr>
      <td>Title</td>
      <td>September 14, 2013</td>
    </tr>
    <tr>
      <td>Description</td>
      <td>September 14, 2013</td>
    </tr>
    <tr>
    	<td>Artist</td>
    	<td>Amanis, Hexca</td>
    </tr>
    <tr>
    	<td>Tags</td>
    	<td>
    		<div class="ui green tag labels">
    			<a href="2" class="ui label">Icon Me</a>
    			<div class="ui label">Icon Me</div>
    			<div class="ui label">Icon Me</div>
    			<div class="ui label">Icon Me</div>
    			<div class="ui label">Icon Me</div>
    			<div class="ui label">Icon Me</div>
    			<div class="ui label">Icon Me</div>
    			<div class="ui label">Icon Me</div>
    		</div>
    	</td>
    </tr>
    <tr>
    	<td>Category</td>
    	<td>
    		<a href="hre">Category</a>
    	</td>
    </tr>
    <tr><td>Rating</td><td></td></tr>
    <tr><td>Uploaded At</td><td>One day ago</td></tr>
    <tr><td>Views</td><td>124 Views</td></tr> -->
    </tbody>
</table>
</template>

<script>
	module.exports = {
		props: {
			maps: {
				required: true,
				type: Array
			}
		},
		data: function () {
			return {
				tmpdata: {},
                remap: []
			}
		},
        events: {
            'row-flash': function (data) {
                this.tmpdata = data;
            }
        },
        ready: function () {
            this.remap = this.maps;
        }
	}
</script>