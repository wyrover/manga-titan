@extends('admin::master')

@section('content')
<div class="ui grid">
	<div class="nine wide column form-admin" id="admin-side-left">
		<div class="ui secondary inverted green segment form-title">
			<div class="title"><i class="icon tags"></i> Tags List</div>
			<div class="control">
				<!-- <button class="ui icon small blue button"><i class="icon plus"></i></button> -->
			</div>
		</div>
		<div class="ui segment form-content">
			<table class="ui very basic table form-table">
				<thead><tr><th>#</th><th>Tags</th><th></th></tr></thead>
				<tbody>
					<tr v-for="i in 5">
						<td></td>
						<td>Yuri</td>
						<td>
							<a href=""><i class="icon blue pencil"></i></a><a href=""><i class="icon blue trash"></i></a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="ui blue segment form-footer">
			<div class="ui small buttons">
				<button class="ui blue icon button"><i class="left chevron icon"></i></button>
				<button class="ui blue basic button">1</button>
				<button class="ui blue icon button"><i class="right chevron icon"></i></button>
			</div>
		</div>
	</div>
	<div class="seven wide column ui form form-admin" id="admin-side-right">
		<div class="pusher"></div>
		<div class="ui secondary inverted green segment form-title">
			<div class="title">Edit Tag</div>
			<div class="control">
				<button class="ui icon small blue button"><i class="icon save"></i></button>
				<button class="ui icon small red button"><i class="icon remove"></i></button>
			</div>
		</div>
		<div class="ui segment form-field">
			<div class="field">
				<label for="">Tag</label>
				<input type="text">
			</div>
			<div class="field"><label for="">Description</label><textarea name="" id="" cols="30" rows="10"></textarea></div>
		</div>
	</div>
</div>
@endsection