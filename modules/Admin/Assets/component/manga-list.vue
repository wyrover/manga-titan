<template>
<div class="ui form" :class="{transition:isHidden, hidden:isHidden}" :id="formId">
	<div class="ui secondary inverted green segment form-title">
		<div class="title"><i class="icon book"></i> Manga List</div>
		<div class="control">
			<div class="ui small icon buttons">
				<button class="ui blue button" @click="addManga"><i class="icon plus"></i></button>
				<button class="ui blue button"><i class="icon refresh"></i></button>
				<button class="ui red button"><i class="icon trash"></i></button>
			</div>
		</div>
	</div>

	<div class="ui segment form-content">
		<table class="ui very basic selectable table form-table">
			<thead><tr><th>#</th><th>Title</th><th>Pages</th><th>Uploaded at</th><th></th></tr></thead>
			<tbody>
				<tr v-for="i in 5">
					<td class="collapsing"><div class="ui fitted checkbox"><input type="checkbox"> <label></label></div></td>
					<td>AAA</td>
					<td>192</td>
					<td>19/1/2016</td>
					<td>
						<a href=""><i class="icon blue pencil"></i></a><a href=""><i class="icon blue trash"></i></a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="ui blue segment form-footer">
		<div class="ui small buttons">
			<button class="ui blue icon button"><i class="left chevron icon"></i></button>
			<button class="ui blue basic button">1</button>
			<button class="ui blue icon button"><i class="right chevron icon"></i></button>
		</div>
	</div>
</div>
</template>

<script>
	module.exports = {
		props: {
			formId: { required: true, type:String },
			isHidden: { required:false, type:Boolean, default: false }
		},
		data: function () {
			return {
				manga_list:[],
				page_num:1
			}
		},
		methods: {
			addManga: function () {
				this.$dispatch('new-manga');
			}
		}
	}
</script>