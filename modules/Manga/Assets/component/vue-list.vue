<template>
	<div class="row manga-list">
		<div class="column" v-for="manga in manga_list" v-if="manga_list.length > 0">
			<div class="ui manga card fluid">
				<div class="blurring dimmable image">
					<div class="ui dimmer">
						<div class="content">
							<div class="center">
								<a :href="getHref(manga)" class="ui blue tiny button">Read</a>
							</div>
						</div>
					</div>
					<a :href="getHref(manga)" class="ui left corner red label"><i class="heart icon"></i></a>
					<img :src="getBackground(manga)">
				</div>
				<div class="content">
					<a class="header">{{ manga.manga_title }}</a>
				</div>
				<div class="extra content">
					<a><i class="icon unhide"></i>{{ manga.manga_view }}</a>
					<a><i class="icon file"></i>{{ manga.manga_pages }}</a>
				</div>
			</div>
		</div>
		<div class="sixteen wide column"><div class="ui message warning">No there manga to share with you. I'm serious.</div></div>
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

				return '/manga/image/thumb/' + manga.thumb_path;
			},
			getHref: function (manga) {
				return '/manga/desc/' + manga.id;
			}
		}
	};
</script>