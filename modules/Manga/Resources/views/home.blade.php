@extends('manga::master')

@section('title')
@parent - Home
@endsection

@set('routeurl',route('manga.desc','{id}'))
@set('routeurl', str_ireplace(['%7B','%7D'],['{','}'], $routeurl))
@section('content')
	<div class="twelve wide column">
		<vue-form id="aasf" :form-action="{get:'get-manga'}">
			<vue-filter></vue-filter>
			<vue-list
			list-type="grid"
			:maps="{title: 'title',image: 'thumb'}"
			:with-extra = "true"
			:with-link = "true"
			link-format="{{$routeurl}}"
			></vue-list>
			<vue-pagination></vue-pagination>
		</vue-form>
	</div>
	<div class="four wide column">
		<h4 class="ui dividing header">Tags</h4>
		<div class="ui small tag labels">
			<a href="" class="ui red label">Yaoi</a>
			<a href="" class="ui orange label">Yuri</a>
			<a href="" class="ui yellow label">Big Tits</a>
			<a href="" class="ui olive label">Yaoi</a>
			<a href="" class="ui green label">Yaoi</a>
			<a href="" class="ui teal label">Yaoi</a>
			<a href="" class="ui blue label">Yaoi</a>
			<a href="" class="ui violet label">Yaoi</a>
			<a href="" class="ui purple label">Yaoi</a>
			<a href="" class="ui pink label">Yaoi</a>
			<a href="" class="ui brown label">Yaoi</a>
			<a href="" class="ui label">Yaoi</a>
		</div>
		<h4 class="ui dividing header">Most Popular</h4>
		<div class="ui middle aligned selection divided list manga-side-list">
			<div class="item" v-for="i in 5">
				<div class="right floated content">
					<div class="ui blue horizontal label">#@{{ i+1 }}</div>
				</div>
			    <div class="content">
			      <a>Team Hessasda dada asda efa sfa e asd</a>
			      <div class="description">
			      	<div class="ui star rating" data-rating="3"></div>
					<div class="right floated">1234 <i class="icon unhide"></i></div>
			      </div>
			    </div>
			  </div>
		</div>
		<h4 class="ui dividing header">Newest Manga</h4>
		<div class="ui middle aligned selection divided list manga-side-list">
			<div class="item" v-for="i in 5">
				<!-- <div class="right floated content">
					<div class="ui blue horizontal label">#@{{ i+1 }}</div>
				</div> -->
			    <div class="content">
			      <a>Team Hessasda dada asda efa sfa e asd</a>
			      <div class="description">
			      	<div class="ui star rating" data-rating="3"></div>
			      	<div class="right floated">Posted 1 day ago</div>
			      </div>
			    </div>
			  </div>
		</div>
	</div>
@endsection