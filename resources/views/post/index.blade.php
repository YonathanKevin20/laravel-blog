@extends('layouts.backend')

@section('title')
	Post
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('post.create') }}" class="btn btn-md btn-primary">Create</a>
		<div class="pull-right">
			<a href="{{ route('export.excel') }}" class="btn btn-md btn-default">Excel</a>
			<a href="{{ route('export.pdf') }}" class="btn btn-md btn-default">PDF</a>
			<a href="{{ route('export.word') }}" class="btn btn-md btn-default">Word</a>
		</div>
		<br><br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">List</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="post-table" style="width: 100%">
						<thead>
							<tr>
								@if(Auth::user()->role == 'editor')
								<th>#</th>
								<th>Title</th>
								<th>Slug</th>
								<th>Content</th>
								<th>Category</th>
								<th>Status</th>
								<th>Action</th>
								@else
								<th>#</th>
								<th>Title</th>
								<th>Slug</th>
								<th>Content</th>
								<th>Category</th>
								<th>User</th>
								<th>Status</th>
								<th>Action</th>
								@endif
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Revision</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="post_id">
				<div class="form-group has-feedback {{ $errors->has('note') ? 'has-error' : '' }}">
					<label>Note</label>
					<textarea id="note" class="form-control" style="resize: vertical;">{{ old('note') }}</textarea>
					@if($errors->has('note'))
						<p class="help-block">{{ $errors->first('note') }}</p>
					@endif
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Close</button>
				<button class="btn btn-primary" onclick="Revision()">Submit</button>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$('#post-table').DataTable({
	    processing: true,
	    serverSide: false,
	    ajax: '{{ route('data.post') }}',
		columns: [
		    {data: 'DT_Row_Index', orderable: false, searchable: false},
		    {data: 'title', name: 'title'},
		    {data: 'slug', name: 'slug'},
		    {data: 'content', name: 'content'},
		    {data: 'category.name', name: 'category.name'},
		    @if(Auth::user()->role != 'editor')
		    	{data: 'user.name', name: 'user.name'},
		    @endif
		    {data: 'status', render: function(data, type, row, meta) {
		    	return post_status(row.status);
		    }},
		    {data: ['status','id'], render: function(data, type, row, meta) {
		    	@switch(Auth::user()->role)
		    		@case('leader')
		    			return '<a href="{{ url('back/post').'/' }}'+row.id+'" class="btn btn-xs btn-primary">Read</a> <button class="btn btn-xs btn-default" onclick="Approval('+row.id+',3)" '+check_leader_btn(row.status)+'>Approval</button>';
		    			@break
		    		@case('chief')
                        return '<a href="{{ url('back/post').'/' }}'+row.id+'" class="btn btn-xs btn-primary">Read</a> <button class="btn btn-xs btn-default" onclick="Verification('+row.id+',1)" '+check_chief_btn(row.status)+'>Accept</button> <button class="btn btn-xs btn-danger modalrevision" data-id="'+row.id+'" '+check_chief_btn(row.status)+'>Revision</button>';
		    			@break
		    		@case('editor')
                        return '<form action="{{ url('back/post').'/' }}'+row.id+'" method="POST" onsubmit="return ConfirmDelete()"><a href="{{ url('back/post').'/' }}'+row.id+'/edit" class="btn btn-xs btn-warning">Edit</a><input type="hidden" name="_method" value="DELETE">{{ csrf_field() }} <button type="submit" class="btn btn-xs btn-danger">Delete</button></form>';
		    			@break
		    	@endswitch
		    }, orderable: false, searchable: false}
		]
	});

    $(document).on('click','.modalrevision',function() {
    	var id = $(this).data('id');
    	$('#post_id').val(id);
    	$('#modalmodal').modal('show');
    });
</script>
@endpush