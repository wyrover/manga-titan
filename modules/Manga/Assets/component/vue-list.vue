<template>
	<div class="row manga-list">
		<div class="column" v-for="manga in manga_list" v-if="manga_list.length > 0">
			<div class="ui manga card fluid">
				<a class="image" :href="getHref(manga)">
					<div class="ui left corner red label"><i class="heart icon"></i></div>
					<img :src="getBackground(manga)">
				</a>
				<div class="content">
					<a class="header" :href="getHref(manga)">{{ manga.manga_title }}</a>
				</div>
				<div class="extra content">
					<a><i class="icon unhide"></i>{{ manga.manga_views }}</a>
					<a><i class="icon file"></i>{{ manga.manga_pages }}</a>
				</div>
			</div>
		</div>
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
				if (manga.thumb_path == '')
					return '/manga/image/thumb/dummy.png';

				return '/manga/image/thumb/' + manga.manga_cover;
			},
			getHref: function (manga) {
				return '/manga/desc/' + manga.id;
			}
		},
		events: {
			'update-list': function (arrlist) {
				this.manga_list = arrlist;
			}
		}
	};
</script>