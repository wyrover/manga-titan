@set('user', Sentinel::getUser())
@set('routename', Request::route()->getName())

<div class="ui borderless manga menu">
	<div class="ui container">
		<div class="item">
			<img src="{{ asset('logo.png') }}">
		</div>
		<a href="{{ route('manga.home') }}"			class="item {{$routename!='manga.home'?:'active'}}">Home</a>
		<a href="{{ route('manga.category') }}"		class="item {{$routename!='manga.category'?:'active'}}">Category</a>
		<a href="{{ route('manga.tags') }}"			class="item {{$routename!='manga.tags'?:'active'}}">Tags</a>
		<a href="{{ route('manga.newest') }}"		class="item {{$routename!='manga.newest'?:'active'}}">Newest <span class="ui green label">123</span></a>
		<a href="{{ route('manga.favorite') }}"		class="item {{$routename!='manga.favorite'?:'active'}}">My Favorite</a>
		<div class="right menu">
			<div class="ui pointing dropdown menubar link item">
				<span class="text">{{ $user->first_name }} {{ $user->last_name }}</span>
				<i class="dropdown icon"></i>
				<div class="menu">
					@if (Sentinel::hasAccess('admin'))
					<a href="{{ route('admin.home') }}" class="item">Admin Control</a>
					<div class="divider"></div>
					@endif
					<a href="{{ route('user.profile') }}" class="item">Profile</a>
					<a href="{{ route('user.changepass') }}" class="item">Change Password</a>
					<a href="{{ route('user.logout') }}" class="item">Log Out</a>
				</div>
			</div>
		</div>
	</div>
</div>