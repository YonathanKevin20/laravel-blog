@extends('layouts.backend')

@section('title')
	User
@endsection

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
				{{ Form::open(array('route'=>['user.update',$user->id])) }}
				@method('PATCH')
					<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="{{ $user->name }}">
						@if($errors->has('name'))
							<p class="help-block">{{ $errors->first('name') }}</p>
						@endif
					</div>
					<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
						<label>Email</label>
						<input type="text" name="email" class="form-control" value="{{ $user->email }}">
						@if($errors->has('email'))
							<p class="help-block">{{ $errors->first('email') }}</p>
						@endif
					</div>
					<div class="form-group">
						<label>Role</label><br>
						<span>{{ ucwords($user->role) }}</span>
					</div>
					<input type="submit" value="Update" class="btn btn-primary">
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@endsection