@set('routename', Request::route()->getName())

<div class="three wide column" id="admin-side">
	<div id="admin-info">
		<div class="image">
			<img src="{{ asset('logo.png') }}" alt="" class="ui small image">
		</div>
		<div class="ui header">Manga Titan</div>
		<div class="decription">Admin Panel</div>
	</div>
	<div class="ui vertical menu" id="admin-menu">
		<a class="item {{ ($routename!='admin.home')?:'active' }}" href="{{ route('admin.home') }}"><i class="icon home"></i> Home</a>
		<a class="item {{ ($routename!='admin.manga')?:'active' }}" href="{{ route('admin.manga') }}"><i class="icon book"></i> Manga</a>
		<a class="item {{ ($routename!='admin.tag')?:'active' }}" href="{{ route('admin.tag') }}"><i class="icon tags"></i> Tags</a>
		<a class="item {{ ($routename!='admin.category')?:'active' }}" href="{{ route('admin.category') }}"><i class="icon filter"></i> Categories</a>
		<a class="item {{ ($routename!='admin.comment')?:'active' }}" href="{{ route('admin.comment') }}"><i class="icon comments"></i> Comments</a>
		<a class="item {{ ($routename!='admin.user')?:'active' }}" href="{{ route('admin.user') }}"><i class="icon users"></i> Users</a>
	</div>
	<div id="admin-note">Note Me</div>
</div>