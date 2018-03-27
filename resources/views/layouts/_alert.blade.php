@if($message = Session::get('success'))
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>{{ $message }}</strong>
	</div>
@endif

@if($message = Session::get('danger'))
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>{{ $message }}</strong>
	</div>
@endif

@if($message = Session::get('warning'))
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>{{ $message }}</strong>
	</div>
@endif

@if($message = Session::get('info'))
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>{{ $message }}</strong>
	</div>
@endif

@if($errors->any())
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Please check the form below for errors
	</div>
@endif