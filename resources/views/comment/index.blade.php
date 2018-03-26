@extends('layouts.backend')

@section('title','Comment')

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('comment.create') }}" class="btn btn-md btn-primary">Create</a>
		<br><br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">List</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="comment-table" style="width: 100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Slug</th>
								<th>Content</th>
								<th>Category</th>
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

@section('scripts')
<script type="text/javascript">
    $('#comment-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('data.post') }}',
	    columns: [
	        {data: 'DT_Row_Index', orderable: false, searchable: false},
	        {data: 'title', name: 'title'},
	        {data: 'slug', name: 'slug'},
	        {data: 'content', name: 'content'},
	        {data: 'category.name', name: 'category.name'},
	        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });
</script>
@endsection