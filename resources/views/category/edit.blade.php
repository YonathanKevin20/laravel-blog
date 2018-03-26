@extends('layouts.backend')

@section('title','Category')

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ URL::previous() }}" class="btn btn-md btn-link">&laquo;Back</a>
		<br><br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">Edit</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('category.update',$category->id) }}" method="POST">
					@csrf
					@method('PATCH')
					<div class="form-group has-feedback {{ $errors->has('nometer') ? 'has-error' : '' }}">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="{{ $category->name }}">
						@if($errors->has('name'))
							<p class="help-block">{{ $errors->first('name') }}</p>
						@endif
					</div>
					<input type="submit" value="Update" class="btn btn-primary">
				</form>
			</div>
		</div>
	</div>
</div>
@endsection