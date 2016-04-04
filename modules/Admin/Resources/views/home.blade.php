@extends('admin::master')

@section('content')
<div class="ui inverted blue secondary segment admin-title"><i class="icon home"></i> Home</div>
<div id="admin-grid" class="ui grid">
	<div class="ten wide column" id="admin-side-left"><div class="ui secondary inverted green segment admin-title"><i class="icon settings"></i> Settings</div></div>
	<div class="six wide column" id="admin-side-right"><div class="ui secondary inverted green segment admin-title"><i class="icon comments"></i> Last Comments</div></div>
</div>
@endsection