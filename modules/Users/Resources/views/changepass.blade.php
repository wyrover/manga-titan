@extends('master')

@section('title')
@parent - Change Password
@endsection

@section('pageContent')
<div class="ui grid centered container">
	<div class="six wide column">
		<form class="ui form login" action="" method="post">
			{!! csrf_field() !!}
			<div class="form-title">Log In</div>
			<div class="form-field">
				<div class="field"><label for="">Current Password</label><input type="password" name="current_password"></div>
				<div class="field"><label for="">New Password</label><input type="password" name="password"></div>
				<div class="field"><label for="">Repeat Password</label><input type="password" name="password_repeat"></div>
			</div>
			<div class="form-control">
				<a href="{{ route('manga.home') }}" class="ui right floated button small blue">Back</a>
				<button class="ui right floated button small green">Change Password</button>
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