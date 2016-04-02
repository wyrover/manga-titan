@extends('master')

@section('title')
@parent - Login
@endsection

@section('content')
<div class="ui grid centered container">
	<div class="six wide column">
		<form class="ui form login" action="" method="post">
			{!! csrf_field() !!}
			<div class="form-title">Log In</div>
			<div class="form-field">
				<div class="field">
					<label for="">Email</label>
					<input type="text" name="email" placeholder="Email Address">
				</div>
				<div class="field">
					<label for="">Password</label>
					<input type="password" name="password" placeholder="Password">
				</div>
				<div class="field">
					<label for="">Remember Me</label>
					<input type="checkbox" name="remember_me">
				</div>
				
			</div>
			<div class="form-control">
				<a href="{{ route('user.register') }}" class="ui right floated button small blue">Register</a>
				<button class="ui right floated button small green">Log In</button>
			</div>
		</form>
		@if($errors->count() > 0)
					
			@foreach ($errors->all() as $error)
			<div class="ui message warning">{{ $error }}</div>
			@endforeach
			
		@endif
	</div>
</div>
@endsection