@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Posts</div>
				<div class="panel-body">

					<div class="row">
						<div class="col-md-4">
							<!-- pagination links -->	
							<nav v-cloak>
								<ul class="pagination">
									<li v-if="posts.links.prev">
										<a @click.prevent="getPosts(posts.links.prev)" :href="posts.links.prev">@lang('pagination.previous')</a>
									</li>
									<li v-if="posts.links.next">
										<a @click.prevent="getPosts(posts.links.next)" :href="posts.links.next">@lang('pagination.next')</a>
									</li>
								</ul>	
							</nav>
						</div>

						<div class="col-md-8 text-right">
							Display from @{{ posts.meta.from }} to @{{ posts.meta.to }} of @{{ posts.meta.total }} data.
						</div>
					</div>

					<div class="table-responsive">
						<table class="table table-striped" v-cloak>
							<thead>
								<th>Title</th>
								<th>Created</th>
								<th>Updated</th>
								<th>Actions</th>
							</thead>

							<tbody>
								<tr v-for="(post, index) in posts.data">
									<td>@{{ post.title }}</td>
									<td>@{{ post.created_at }}</td>
									<td>@{{ post.updated_at }}</td>
									<td>
										<button class="btn btn-info btn-xs">Edit</button>
										<button class="btn btn-danger btn-xs">Delete</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<!-- pagination links -->	
					<nav v-cloak>
						<ul class="pagination">
							<li v-if="posts.links.prev">
								<a @click.prevent="getPosts(posts.links.prev)" :href="posts.links.prev">@lang('pagination.previous')</a>
							</li>
							<li v-if="posts.links.next">
								<a @click.prevent="getPosts(posts.links.next)" :href="posts.links.next">@lang('pagination.next')</a>
							</li>
						</ul>
					</nav>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection