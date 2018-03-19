@extends('layouts.backend')

@section('title')
	Search
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('export.excel','search='.$_GET['search']) }}" class="btn btn-md btn-default">Excel</a>
		<br><br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">List</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered" style="width: 100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Category</th>
								<th>User</th>
								<th>Status</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@php
								$no = 1;
							@endphp
							@foreach($posts as $p)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $p->title }}</td>
									<td>{{ $p->category->name }}</td>
									<td>{{ $p->user->name }}</td>
									<td>{!! post_status($p->status) !!}</td>
									<td>{{ $p->created_at->format('M d, Y \a\t h:i A') }}</td>
									<td></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection