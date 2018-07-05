<template>
	<div>
		<div class="form-group">
			<router-link :to="{name: 'indexCategory'}" class="btn btn-default">Back</router-link>
		</div>

		<form v-on:submit="saveForm()">
			<div class="form-group">
				<label>Name</label>
				<input type="text" v-model="category.name" class="form-control">
			</div>
			<div class="form-group">
				<button class="btn btn-success">Create</button>
			</div>
		</form>
	</div>
</template>

<script>
	export default {
		data: function() {
			return {
				category: {
					name: '',
				}
			}
		},
		methods: {
			saveForm() {
				var app = this;
				var newCategory = app.category;
				axios.post('/api/category/store/', newCategory)
					.then(function(resp) {
						app.$router.push('/');
						alert("Created");
					})
					.catch(function(resp) {
						console.log(resp);
						alert("Could not create your category");
					});
			}
		}
	}
</script>