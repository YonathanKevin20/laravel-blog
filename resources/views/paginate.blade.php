@extends('layouts.frontend')

@section('content')
<div class="col-md-8">
	@if(count($posts))
		@php
		if(Request::segment(2) != '') {
			$id = Request::segment(2);
			$category = App\Models\Category::findOrFail($id);
			echo "<h4>$category->name</h4><br>";
		}
		@endphp
		@foreach($posts as $p)
			<div class="card mb-4">
				<!--
				<img class="card-img-top img-responsive" src="{{ Storage::url($p->image) }}" alt="{{ $p->image }}">
				-->
				<div class="card-body">
					<h2 class="card-title">{{ $p->title }}</h2>
					<p class="card-text">
						@php
						$limit = str_limit(strip_tags($p->content),100,' ...');
						@endphp
						{!! $limit !!}
					</p>
					<a href="{{ route('post.detail',$p->id) }}" class="btn btn-primary">Read More &rarr;</a>
					<span class="pull-right">{{ $p->category->name }}</span>
				</div>
				<div class="card-footer text-muted">Posted on {{ $p->created_at->diffForHumans() }} by
					<a href="#">{{ $p->user->name }}</a>
				</div>
			</div>
		@endforeach
	{{ $posts->links() }}
	@else
		<h1 class="my-4">Not found</h1>
	@endif
</div>

@include('layouts._widget')

@endsection