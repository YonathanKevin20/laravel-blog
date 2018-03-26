@extends('layouts.backend')

@section('title','Post')

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
				{{ Form::open(array('route'=>'post.store','enctype'=>'multipart/form-data')) }}
					<div class="form-group has-feedback {{ $errors->has('title') ? 'has-error' : '' }}">
						<label>Title</label>
						<input type="text" name="title" class="form-control" value="{{ old('title') }}">
						@if($errors->has('title'))
							<p class="help-block">{{ $errors->first('title') }}</p>
						@endif
					</div>
					<div class="form-group has-feedback {{ $errors->has('content') ? 'has-error' : '' }}">
						<label>Content</label>
						<textarea id="editor" name="content" class="form-control" style="resize: vertical;">{{ old('content') }}</textarea>
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
					<div class="form-group has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
						<label>Image</label>
						{{ Form::file('image', array('id' => 'inputgambar')) }}
						<br>
						@if($errors->has('image'))
							<p class="help-block">{{ $errors->first('image') }}</p>
						@endif	
						<img src="http://placehold.it/100x100" id="showgambar" style="max-width:200px; max-height:200px;" class="img-responsive">
					</div>
					<input type="submit" value="Save" class="btn btn-primary">
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#showgambar').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#inputgambar").change(function () {
		readURL(this);
	});
</script>
@endpush