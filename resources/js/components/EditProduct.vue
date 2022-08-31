<template>
    <div>
        <h3 class="text-center">Edit Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateProduct">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <input type="text" class="form-control" v-model="product.detail">
                    </div>
                    <div class="form-group mb-3">
                        <label>Tags</label>
                        <vue-tags-input
                            v-model="tag"
                            :tags="product.tags"
                            @tags-changed="newTags => product.tags = newTags"
                            class="form-control"
                            />
                    </div>
                    <div class="form-group mb-3">
                        <label>Category</label>
                        <select name="" id="" class="form-control" v-model="product.categoryid">
                        <option value="" selected>Selecione uma opção</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id" >{{category.name}}</option>
                        </select>
                    </div>
                    <div class=" b">
                        <button type="submit" class="btn btn-primary" :disabled="disableButton">Create</button>
                        <button class="btn" @click="voltarCampos()">Voltar Campos</button>
                    </div>
                </form>
            </div>
            <div class="container col-md-6">
                <div class="mb-5">
                    <label for="Image" class="form-label">Set a Image</label>
                    <input class="form-control" type="file" id="formFile" @change="preview()" :src="product.picture">
                    <button @click="clearImage()" class="btn btn-primary mt-3">Clear Image</button>
                </div>
                <img id="frame" src="" class="img-fluid" />
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                product: {name: '', detail: '', categoryid: '', tags: [], picture: ''},
                Oldproduct: {name: '', detail: '', categoryid: '', tags: [], picture: ''},
                categories: {},
                verify: {verify: false, text: ''},
                tag: '',
            }
        },
        created() {
            this.axios
                .get(`http://localhost:8000/api/products/${this.$route.params.id}`)
                .then((res) => {
                    this.product = res.data;
                    this.Oldproduct = res.data;
                });
        },
        methods: {
            updateProduct() {
                this.axios
                    .patch(`http://localhost:8000/api/products/${this.$route.params.id}`, this.product)
                    .then((res) => {
                        this.$router.push({ name: 'home' });
                    });
            },
            fetchcategorys(){
                this.axios
                    .get('http://localhost:8000/api/categories/')
                    .then(response => {
                        this.categories = response.data;
                });
            },
            voltarCampos(){
               this.product = this.Oldproduct;
            },
            verifyBarcode(){
                this.axios
                    .get('http://localhost:8000/api/verifyBarcode', {params:{barcode: this.product.barcode}})
                    .then(response=>(this.verify.verify = response.verify,
                                     this.verify.text = response.text))
            },
        },
        computed: {
            disableButton: function (){
                if (this.product.name == '' || 
                this.product.detail == '' || 
                this.product.categoryid == '' ||
                this.verify.verify == false ||
                this.product.barcode == ''
                ) {
                    return true;
                } else {
                    return false;
                }
            },
        },
        mounted(){
            this.fetchcategorys();
        }
    }
</script>
