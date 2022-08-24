import Vue from "vue";
import Router from "vue-router";

import AllProduct from './components/AllProduct.vue';
import CreateProduct from './components/CreateProduct.vue';
import EditProduct from './components/EditProduct.vue';

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
        }
    ]
})

export default routes;