@extends('layouts.backend')

@section('title','Category')

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('category.create') }}" class="btn btn-md btn-primary">Create</a>
		<br><br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">List</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="category-table" style="width: 100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
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
    $('#category-table').DataTable({
        processing: true,
        serverSide: false,
        ajax: '{{ route('data.category') }}',
	    columns: [
	        {data: 'DT_Row_Index', orderable: false, searchable: false},
	        {data: 'name', name: 'name'},
	        {data: 'id', render: function(data, type, row, meta) {
	        	return '<form action="{{ url('back/category').'/' }}'+row.id+'" method="POST" onsubmit="return ConfirmDelete()"><a href="{{ url('back/category').'/' }}'+row.id+'/edit" class="btn btn-xs btn-warning">Edit</a><input type="hidden" name="_method" value="DELETE">{{csrf_field() }} <button type="submit" class="btn btn-xs btn-danger">Delete</button></form>';
	        }, orderable: false, searchable: false}
	    ]
    });
</script>
@endpush