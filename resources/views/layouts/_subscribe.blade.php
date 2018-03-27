<div class="jumbotron" style="margin: 0;">
	<h1 class="display-4 text-center">Subscribe</h1>
	<form action="{{ route('subscriber.store') }}" method="POST">
		@csrf
		<div class="form-group">
			<input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('email') }}">
			@if($errors->has('email'))
				<p class="invalid-feedback">{{ $errors->first('email') }}</p>
			@endif
			<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
		</div>
		<div class="text-center">
			<button type="submit" class="btn btn-outline-dark btn-lg">Submit</button>
		</div>
	</form>
</div>