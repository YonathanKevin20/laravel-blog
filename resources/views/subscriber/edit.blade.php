@extends('layouts.backend')

@section('title','Subscriber')

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
				<form action="{{ route('subscriber.update',$subscriber->id) }}" method="POST">
					@csrf
					@method('PATCH')
					<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
						<label>Email</label>
						<input type="email" name="email" class="form-control" value="{{ $subscriber->email }}">
						@if($errors->has('email'))
							<p class="help-block">{{ $errors->first('email') }}</p>
						@endif
					</div>
					<div class="checkbox">
						<label>
							<input {{ ($subscriber->status == 'on') ? 'checked' : '' }} data-toggle="toggle" type="checkbox" name="status">
						</label>
					</div>
					<input type="submit" value="Update" class="btn btn-primary">
				</form>
			</div>
		</div>
	</div>
</div>
@endsection