
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import CategoryIndex from './components/category/CategoryIndex.vue';
import CategoryCreate from './components/category/CategoryCreate.vue';
import CategoryEdit from './components/category/CategoryEdit.vue';

const routes = [
    {
        path: '',
        components: {
            categoryIndex: CategoryIndex
        },
        name: 'indexCategory',
    },
    {
        path: '/create',
        component: CategoryCreate,
        name: 'createCategory',
    },
    {
        path: '/edit/:id',
        component: CategoryEdit,
        name: 'editCategory',
    }
]

const router = new VueRouter({
    routes
})

const app = new Vue({ router }).$mount('#app')
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

/*
const app = new Vue({
    el: '#app',
    data: {
        api: {
            post: '/api/post'
        },
    	posts: {
    		links: '',
    		meta: '',
    	},
    },

    mounted() {
        console.log('Vue is ready!')
    	// initial user
    	this.getPosts(this.api.post);
    },

    methods: {
    	getPosts(url) {
    		axios.get(url).then(response => {
    			this.posts = response.data;
    		}).catch(errors => {
    			console.error(errors);
    		})
    	}
    }
});
*/