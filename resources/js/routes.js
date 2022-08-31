import Vue from "vue";
import Router from "vue-router";

import AllProduct from './components/AllProduct.vue';
import CreateProduct from './components/CreateProduct.vue';
import EditProduct from './components/EditProduct.vue';

import AllCategories from './components/AllCategories.vue';
import CreateCategory from './components/CreateCategory.vue';
import EditCategory from './components/EditCategory.vue';

Vue.use(Router);

const routes = new Router({
    mode: "history",
    routes: [{
            name: 'home',
            path: '/',
            component: AllProduct
        },
        {
            name: 'create',
            path: '/create',
            component: CreateProduct
        },
        {
            name: 'edit',
            path: '/edit/:id',
            component: EditProduct
        },
        {
            name: 'allCategories',
            path: '/allCategories',
            component: AllCategories
        },
        {
            name: 'createCategory',
            path: '/createCategory',
            component: CreateCategory
        },
        {
            name: 'editCategory',
            path: '/editCategory/:id',
            component: EditCategory
        },
    ]
})

export default routes;