@extends('master')

@section('title')
@parent - Register
@endsection

@section('pageContent')
<div class="ui grid centered container">
	<div class="six wide column">
		<form class="ui form login" action="" method="post">
			{!! csrf_field() !!}
			<div class="form-title">Register</div>
			<div class="form-field">
				<div class="field">
					<label for="">Email</label>
					<input type="text" name="email" placeholder="Email Address">
				</div>
				<div class="field">
					<label for="">Password</label>
					<input type="password" name="password" placeholder="Password" maxlength="24">
				</div>
				<div class="field">
					<label for="">Repeat Password</label>
					<input type="password" name="password_repeat" placeholder="Repeat Password" maxlength="24">
				</div>
				<div class="field">
					<label for="">Fullname</label>
					<input type="text" name="name" placeholder="Fullname">
				</div>
			</div>
			<div class="form-control">
				<a href="{{ route('user.login') }}" class="ui right floated button small blue">Login</a>
				<button class="ui right floated button small green">Register</button>
			</div>
		</form>

		@if($errors->count() > 0)
					
			@foreach ($errors->all() as $error)
			<div class="ui message warning">{{ $error }}</div>
			@endforeach
			
		@endif
		@if (session('message'))

			<div class="ui message success">{{ session('message') }}</div>

		@endif
	</div>
</div>
@endsection