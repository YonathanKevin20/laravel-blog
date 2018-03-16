@extends('layouts.backend')

@section('title')
	Post
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ URL::previous() }}" class="btn btn-md btn-default">Back</a>
		<br><br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">Edit</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('post.update',$post->id) }}" method="POST">
					@csrf
					@method('PATCH')
					<div class="form-group has-feedback {{ $errors->has('title') ? 'has-error' : '' }}">
						<label>Title</label>
						<input type="text" name="title" class="form-control" value="{{ $post->title }}">
						@if($errors->has('title'))
							<p class="help-block">{{ $errors->first('title') }}</p>
						@endif
					</div>
					<div class="form-group has-feedback {{ $errors->has('content') ? 'has-error' : '' }}">
						<label>Content</label>
						<textarea name="content" class="form-control" style="resize: vertical;">{{ $post->content }}</textarea>
						@if($errors->has('content'))
							<p class="help-block">{{ $errors->first('content') }}</p>
						@endif
					</div>
					<div class="form-group">
						<label>Category</label>
						@foreach ($categories as $c)
							@php
							$category[$c->id] = $c->name;
							@endphp
						@endforeach
						{{ Form::select('category_id',$category,$post->category_id,['class'=>'form-control']) }}
					</div>
					<input type="submit" value="Update" class="btn btn-primary">
				</form>
			</div>
		</div>
	</div>
</div>
@endsection