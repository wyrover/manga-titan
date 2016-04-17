<template>
<table class="ui basic definition table">
  <tbody>
    <tr>
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
    <tr><td>Rating</td><td><div class="ui star rating" data-rating="3"></div> (3.5) 1267 Votes</td></tr>
    <tr><td>Uploaded At</td><td>One day ago</td></tr>
    <tr><td>Views</td><td>124 Views</td></tr>
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
				tmpdata: []
			}
		},
        events: {
            'row-flash': function (data) {
                //
            }
        }
	}
</script>