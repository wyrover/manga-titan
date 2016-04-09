<style>
	.sortable {
		width: 100%;
		padding:0em 1em;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	.sortable.grid {
		overflow: hidden;
	}
	.sortable li {
		list-style: none;
		border: 1px solid #CCC;
		background-color: #F6F6F6;
		background-repeat: no-repeat;
		background-size: 100% 100%;
		background-position: center center;
		color: #1C94C4;
		margin: 5px;
		padding: 5px;
		height: 22px;
	}
	.sortable.grid li {
		float: left;
		width: 150px;
		height: 225px;
		position: relative;
	}
	.sortable.grid li .content {
		background-color: rgba(0, 0, 0, 0.5);
		position: absolute;
		color: white;
		padding: 5px;
		left: 0px;
		right: 0px;
	}
	.sortable.grid li .content:not(.extra) {
		bottom: 0px;
	}
	.sortable.grid li .content.extra {
		top:0px;
	}
	.sortable.grid li .content .header {
		color:#FAFAFA;
	}
</style>

<template>
	<div class="row manga-list">
		<ul class="sortable grid" v-if="manga_list.length > 0">
			<li class="manga" v-for="manga in manga_list" :style="getBackground(manga)">
				<a :href="getHref(manga)">
					<div class="content"><span class="header" >{{ manga.manga_title }}</span></div>
					<div class="extra content">
						<span><i class="icon unhide"></i>{{ manga.manga_views }}</span>
						<span><i class="icon file"></i>{{ manga.manga_pages }}</span>
					</div>
				</a>
			</li>
		</ul>
		<!-- <div class="column" v-for="manga in manga_list" v-if="manga_list.length > 0">
			<div class="ui manga card fluid">
				<a class="image" :href="getHref(manga)">
					<div class="ui left corner red label"><i class="heart icon"></i></div>
					<div class="image container"></div>
					<img :src="getBackground(manga)" class="ui image">
				</a>
				<div class="content">
					<a class="header" :href="getHref(manga)">{{ manga.manga_title }}</a>
				</div>
				<div class="extra content">
					<a><i class="icon unhide"></i>{{ manga.manga_views }}</a>
					<a><i class="icon file"></i>{{ manga.manga_pages }}</a>
				</div>
			</div>
		</div> -->
		<div class="sixteen wide column" v-else><div class="ui message warning">No there manga to share with you. I'm serious.</div></div>
	</div>
</template>

<script>
	module.exports = {
		data: function () {
			return {
				manga_list: []
			};
		},
		methods: {
			getBackground: function (manga) {
				if (manga.manga_cover == '')
					return {backgroundImage:"url('/manga/image/original/dummy.png')"};
				// 	return '/manga/image/thumb/dummy.png';
				
				// return '/manga/image/thumb/' + manga.manga_cover;
				return {backgroundImage:"url('" + '/manga/image/thumb/' + manga.manga_cover + "')"};
			},
			getHref: function (manga) {
				return '/manga/desc/' + manga.manga_id;
			}
		},
		events: {
			'update-list': function (arrlist) {
				this.manga_list = arrlist;
			}
		}
	};
</script>