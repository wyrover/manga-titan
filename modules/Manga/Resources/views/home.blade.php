@extends('manga::master')

@section('title')
@parent - Home
@endsection

@section('content')
	<div class="twelve wide column">
		<manga-list-control></manga-list-control>
		<manga-list></manga-list>
		<manga-page></manga-page>

		<div class="ui four column stackable grid manga-grid">
		<div class="row">
			<div class="sixteen wide column">
				<form action="" class="ui form">
					<div class="three fields">
						<div class="field"><label for="">Length</label><input type="text"></div>
						<div class="field"><label for="">Release Date</label><input type="text"></div>
						<div class="field"><label for="">Keyword</label><input type="text"></div>
					</div>
				</form>
			</div>
		</div>
		<div class="row manga-list">
			<div class="column" v-for="s in 20">
				<div class="ui manga card fluid">
					<div class="blurring dimmable image">
				      <div class="ui dimmer">
				        <div class="content">
				          <div class="center">
				            <div class="ui blue tiny button">Read</div>
				          </div>
				        </div>
				      </div>
				      <a class="ui left corner red label">
				        <i class="heart icon"></i>
				      </a>
				      <img src="{{ route('imagecache', ['template'=> 'thumb', 'filename' => '001.jpg']) }}">
				    </div>
				    <div class="content">
						<a class="header">Team Hessasda dada asda efa sfa e</a>
					</div>
					<div class="extra content">
						<a><i class="icon unhide"></i>2</a>
						<a><i class="icon file"></i>1292</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="sixteen wide column">
			<div class="ui pagination menu">
				<a class="item" v-for="i in 10">
					@{{ i + 1}}
				</a>
			</div>
			</div>
		</div>
		</div>
	</div>
	<div class="four wide column">
		<manga-filter></manga-filter>
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