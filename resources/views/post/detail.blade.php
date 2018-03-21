@extends('layouts.frontend')

@section('content')
<div class="col-md-8">
	<h1 class="mt-4">{{ $post->title }}</h1>
	<p class="lead">by
		<a href="#">{{ $post->user->name }}</a>
	</p>
	<hr>
	<p>{{ $post->created_at->format('M d, Y \a\t h:i A') }}
		<span class="pull-right">
			<a href="{{ route('category.per',$post->category->id) }}">{{ $post->category->name }}</a>
		</span>
	</p>
	<hr>
	<img class="img-fluid rounded img-responsive" src="{{ Storage::url($post->image) }}" alt="{{ $post->image }}">
	{!! $post->content !!}
</div>

@include('layouts._widget')

@endsection