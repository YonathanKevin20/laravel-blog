<template>
	<div>
		<div class="form-group">
			<router-link :to="{name: 'indexCategory'}" class="btn btn-default">Back</router-link>
		</div>

		<form v-on:submit="updateForm()">
			<div class="form-group">
				<label>Name</label>
				<input type="text" v-model="category.name" class="form-control">
			</div>
			<div class="form-group">
				<button class="btn btn-success">Update</button>
			</div>
		</form>
	</div>
</template>

<script>
	export default {
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.categoryId = id;
			axios.get('/api/category/show/' + id)
				.then(function(resp) {
					app.category = resp.data;
				})
				.catch(function() {
					alert("Could not load your category")
				});
		},
		data: function() {
			return {
				categoryId: null,
				category: {
					name: '',
				}
			}
		},
		methods: {
			updateForm() {
				var app = this;
				var newCategory = app.category;
				axios.post('/api/category/update/'+app.categoryId, newCategory)
					.then(function(resp) {
						app.$router.replace('/');
						alert("Updated");
					})
					.catch(function(resp) {
						console.log(resp);
						alert("Could not update your category");
					});
			}
		}
	}
</script>