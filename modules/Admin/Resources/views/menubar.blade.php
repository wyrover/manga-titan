@set('user', Sentinel::getUser())

<div id="admin-menu" class="ui borderless menu">
	<div class="ui container">
		<div class="item">
			<img src="{{ asset('logo.png') }}">
		</div>
		<div class="right menu">
			<div class="ui pointing dropdown link item">
				<span class="text">{{ $user->first_name }} {{ $user->last_name }}</span>
				<i class="dropdown icon"></i>
				<div class="menu">
					<a href="{{ route('manga.home') }}" class="item">Back to Manga</a>
					<div class="divider"></div>
					<a href="{{ route('user.profile') }}" class="item">Profile</a>
					<a href="{{ route('user.changepass') }}" class="item">Change Password</a>
					<a href="{{ route('user.logout') }}" class="item">Log Out</a>
				</div>
			</div>
		</div>
	</div>
</div>