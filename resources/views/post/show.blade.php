@extends('layouts.backend')

@section('title')
	Post
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ URL::previous() }}" class="btn btn-md btn-link">&laquo;Back</a>
		<br><br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">Detail</div>
				<div class="text-right" id="status"></div>
			</div>
			<div class="panel-body">
				@if($post->revision->count() > 0)
					<div class="form-group">
						<label>Note</label><br>
						<ol>
						@foreach($post->revision as $r)
							<li>{{ $r->note }}</li>
						@endforeach
						</ol>
					</div>
				@endif
				<div class="form-group">
					<label>Title</label><br>
					<span>{{ $post->title }}</span>
				</div>
				<div class="form-group">
					<label>Content</label><br>
					<span>{!! $post->content !!}</span>
				</div>
				<div class="form-group">
					<label>Category</label><br>
					<span>{{ $post->category->name }}</span>
				</div>
				<div class="form-group">
					<label>User</label><br>
					<span>{{ $post->user->name }}</span>
				</div>
				<img src="{{ Storage::url($post->image) }}" style="max-height: 200px; max-width: 200px;" class="img-responsive">
				<br>
				<br>
				@if(Auth::user()->role == 'chief')
					<button id="btn-accept" class="btn btn-sm btn-default" onclick="Verification({{ $post->id }},1)">Accept</button>
					<button id="btn-revision" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalrevision">Revision</button>
				@elseif(Auth::user()->role == 'leader')
					<button id="btn-approval" class="btn btn-xs btn-default" onclick="Approval('+row.id+',3)">Approval</button>
				@endif
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalrevision" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Revision</h4>
			</div>
			<form action="{{ route('post.revision',$post->id) }}" method="POST">
				@csrf
				@method('PATCH')
				<div class="modal-body">
					<div class="form-group has-feedback {{ $errors->has('note') ? 'has-error' : '' }}">
						<label>Note</label>
						<textarea name="note" class="form-control" style="resize: vertical;">{{ old('note') }}</textarea>
						@if($errors->has('note'))
							<p class="help-block">{{ $errors->first('note') }}</p>
						@endif
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" value="Submit" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	var status = post_status({{ $post->status }});
	$(document).ready(function() {
		$('#btn-accept').prop('disabled',check_chief_btn({{ $post->status }}));
		$('#btn-revision').prop('disabled',check_chief_btn({{ $post->status }}));
		$('#btn-approval').prop('disabled',check_leader_btn({{ $post->status }}));

		$('div#status').html(status);
	});
</script>
@endpush