<template>
    <div class="container"> 
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link">Products List</router-link>
                    <router-link to="/create" class="nav-item nav-link">Create Product</router-link>
                    <router-link to="/allCategories" class="nav-item nav-link">Categories List</router-link>
                    <router-link to="/createCategory" class="nav-item nav-link">Create Categorie</router-link>
                </div>
            </div>
        </nav>
        <router-view> </router-view>
    </div>
</template>
 
<script>
    import VueTagsInput from '@johmun/vue-tags-input'
    export default {
        components: {
            VueTagsInput,
         },
    }
</script>


