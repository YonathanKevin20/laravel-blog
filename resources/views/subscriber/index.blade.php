@extends('layouts.backend')

@section('title','Subscriber')

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('subscriber.create') }}" class="btn btn-md btn-primary">Create</a>
		<br><br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">List</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="subscriber-table" style="width: 100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Email</th>
								<th>Status</th>
								<th>Action</th>
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
@endsection

@push('scripts')
<script type="text/javascript">
    $('#subscriber-table').DataTable({
        processing: true,
        serverSide: false,
        ajax: '{{ route('data.subscriber') }}',
	    columns: [
	        {data: 'DT_Row_Index', orderable: false, searchable: false},
	        {data: 'email', name: 'email'},
	        {data: 'status', name: 'status'},
	        {data: 'id', render: function(data, type, row, meta) {
	        	return '<form action="{{ url('back/category').'/' }}'+row.id+'" method="POST" onsubmit="return ConfirmDelete()"><a href="{{ url('back/post').'/' }}'+row.id+'/edit" class="btn btn-xs btn-warning">Edit</a><input type="hidden" name="_method" value="DELETE">{{csrf_field() }} <button type="submit" class="btn btn-xs btn-danger">Delete</button></form>';
	        }, orderable: false, searchable: false}
	    ]
    });
</script>
@endpush