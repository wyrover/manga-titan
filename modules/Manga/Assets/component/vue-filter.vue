<template>
	<div class="row">
		<div class="sixteen wide column">
			<form action="" class="ui form">
				<div class="four fields">
					<div class="field">
						<label>Length</label>
						<select id="length" class="ui length dropdown">
							<option value="none">None</option>
							<option value="short">1-20 Pages</option>
							<option value="medium">21-40 Pages</option>
							<option value="long">41-100 Pages</option>
							<option value="mega">101++ Pages</option>
						</select>
					</div>
					<div class="field">
						<label>Release Date</label>
						<select id="length" class="ui recent dropdown">
							<option value="none">None</option>
							<option value="today">Today</option>
							<option value="yesterday">Yesterday</option>
							<option value="week">1 Week Ago</option>
							<option value="month">1 Month Ago</option>
						</select>
					</div>
					<div class="field"><label>Tags</label><select class="ui tags dropdown" multiple>
							<option value="">Tags</option>
							<option value="Yuri">Yuri</option>
							<option value="yara">Yara</option>
							<option value="test">test</option>
							<option value="a">a</option>
						</select></div>
					<div class="field">
						<label>Keyword</label>
						<input type="text">
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	module.exports = {
		data: function () {
			return {
				manga_length: 12,
				manga_time: null,
				manga_keyword: null,
				manga_tags: []
			};
		},
		events: {
			'filter-changed-call': function () {
				var data = {
					manga_time: this.manga_time,
					manga_length: this.manga_length,
					manga_tags: this.manga_tags,
					manga_keyword: this.manga_keyword
				};
				this.$dispatch('filter-changed', data);
			}
		}
	};
</script>