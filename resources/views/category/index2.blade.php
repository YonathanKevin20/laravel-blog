@extends('layouts.backend')

@section('title','Category')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">Category List</div>
			</div>
			<div class="panel-body table-responsive">
				<router-view name="categoryIndex"></router-view>
				<router-view></router-view>
			</div>
		</div>
	</div>
</div>
@endsection