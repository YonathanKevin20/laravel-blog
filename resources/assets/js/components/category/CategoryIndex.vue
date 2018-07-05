<template>
	<div>
		<div class="form-group">
			<router-link :to="{name: 'createCategory'}" class="btn btn-success">Create</router-link>
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
						<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(category.id, index)">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	export default {
		data: function() {
			return {
				categories: []
			}
		},
		mounted() {
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
			}
		}
	}
</script>