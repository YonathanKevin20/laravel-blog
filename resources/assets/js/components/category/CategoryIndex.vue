<template>
	<div>
		<div class="row">
			<div class="col-sm-6 form-group">
				<router-link :to="{name: 'createCategory'}" class="btn btn-success">Create</router-link>
			</div>
			<div class="col-sm-3 form-group pull-right">
				<input class="form-control input-sm" type="text" v-model="params.search" @keyup="doSearch" placeholder="Search">
			</div>
		</div>

		<table class="table table-bordered" style="width: 100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="category, index in categories">
					<td>{{ index+1 }}</td>
					<td>{{ category.name }}</td>
					<td>
						<router-link :to="{name: 'editCategory', params: {id: category.id}}" class="btn btn-xs btn-default">Edit</router-link>
						<a href="#" class="btn btn-xs btn-danger" @click="deleteEntry(category.id, index)">Delete</a>
						<button class="btn btn-primary btn-xs" @click="showModal(category)">Show</button>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Modal title</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" v-model="category.name" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
	export default {
		data() {
			return {
				categories: [],
				params: {
					search: '',
				},
				category: {
					name: '',
				}
			}
		},
		mounted() {
			this.getData();
		},
		methods: {
			deleteEntry(id, index) {
				if(confirm("Do you really want to delete it?")) {
					var app = this;
					axios.post('/api/category/destroy/'+id)
						.then(function(resp) {
							app.categories.splice(index, 1);
							alert("Deleted");
						})
						.catch(function(resp) {
							alert("Could not delete category");
						});
				}
			},
			doSearch() {
				var app = this;
				if(app.params.search != '') {
					var search = app.params;
					axios.post('/api/category/search/', search)
						.then(function(resp) {
							app.categories = resp.data;
						})
						.catch(function(resp) {
							console.log(resp);
							alert("Could not search");
						});
					}
				else {
					this.getData();
				}
			},
			getData() {
				var app = this;
				axios.get('/api/category/index/')
					.then(function(resp) {
						app.categories = resp.data;
					})
					.catch(function(resp) {
						console.log(resp);
						alert("Could not load categories");
					});
			},
			showModal(item) {
				this.category.name = item.name;
				$("#myModal").modal('show');
			}
		}
	}
</script>