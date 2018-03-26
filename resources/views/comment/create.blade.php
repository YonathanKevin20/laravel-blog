@extends('layouts.backend')

@section('title','Comment')

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ URL::previous() }}" class="btn btn-md btn-link">&laquo;Back</a>
		<br><br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">Create</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('post.store') }}" method="POST">
					@csrf
					<div class="form-group has-feedback {{ $errors->has('title') ? 'has-error' : '' }}">
						<label>Title</label>
						<input type="text" name="title" class="form-control" value="{{ old('title') }}">
						@if($errors->has('title'))
							<p class="help-block">{{ $errors->first('title') }}</p>
						@endif
					</div>
					<div class="form-group has-feedback {{ $errors->has('content') ? 'has-error' : '' }}">
						<label>Content</label>
						<textarea name="content" class="form-control" style="resize: vertical;">{{ old('content') }}</textarea>
						@if($errors->has('content'))
							<p class="help-block">{{ $errors->first('content') }}</p>
						@endif						
					</div>
					<div class="form-group">
						<label>Category</label>
						<select name="category_id" class="form-control">
							@foreach ($categories as $c)
								<option value="{{ $c->id }}">{{ $c->name }}</option>
							@endforeach
						</select>
					</div>
					<input type="submit" value="Save" class="btn btn-primary">
				</form>
			</div>
		</div>
	</div>
</div>
@endsection