<template>
    
    <div>
        <h3 class="text-center">Create Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addProduct">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <input type="text" class="form-control" v-model="product.detail">
                    </div>
                    <div class="form-group">
                        <label>Barcode</label>
                        <input type="text" class="form-control" v-model="product.barcode" @blur="verifyBarcode()"> 
                        <p>{{verify.text}}</p>
                    </div>
                    <!-- tag -->
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
                    
                    <button type="submit" class="btn btn-primary" :disabled="disableButton">Create</button>
                    <button class="btn" @click="limparCampos()">Limpar campos</button>
                </form>
            </div>
            <div class="container col-md-6">
                <div class="mb-5">
                    <label for="Image" class="form-label">Set a Image</label>
                    <input class="form-control" type="file" id="formFile" @change="preview()" v-bind="product.picture">
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
                product: {name: '', detail: '', categoryid: '', barcode: '', tags: [], picture: ''},
                categories: {},
                verify: {verify: false, text: ''},
                tag: '',
            }
        },
        methods: {
            addProduct() {
                console.log(this.product);
                let formData = this.createFormData(this.product);
                this.axios
                    .post('http://localhost:8000/api/products', formData)
                    .then(response => (
                        this.$router.push({ name: 'home' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },
            fetchcategorys(){
                this.axios
                    .get('http://localhost:8000/api/categories/')
                    .then(response => {
                        this.categories = response.data;
                });
            },
            limparCampos(){
                this.product.name = '';
                this.product.detail = '';
                this.product.categoryid = '';
            },
            verifyBarcode(){
                this.axios
                    .get('http://localhost:8000/api/verifyBarcode', {params:{barcode: this.product.barcode}})
                    .then(response=>(this.verify.verify = response.verify,
                                     this.verify.text = response.text))
            },
             preview() {
                this.product.picture = event.target.files[0];
                frame.src = URL.createObjectURL(event.target.files[0]);
            },
            clearImage() {
                document.getElementById('formFile').value = null;
                frame.src = "";
            },
            createFormData: function (obj, form, namespace) {
                var fd = form || new FormData();
        
                let formKey = null;
        
                for (const property in obj) {
                if (obj.hasOwnProperty(property)) {
                    formKey = namespace ? `${namespace}[${property}]` : property;
                    /**
                     * if the property is an object, but not a File.
                     * use recursivity.
                     * if it's a file add it
                     * else
                     * add the normal key
                     */
                    if (
                    typeof obj[property] === "object" &&
                    !(obj[property] instanceof File)
                    ) {
                    this.createFormData(obj[property], fd, formKey);
                    } else if (obj[property] instanceof File) {
                    fd.append(formKey, obj[property]);
                    } else {
                    // if it's a string
                    let value = obj[property];
        
                    // if boolean send 1, 0
                    if (
                        value === "true" ||
                        value === "false" ||
                        value === true ||
                        value === false
                    ) {
                        value = value === "true" || value === true ? 1 : 0;
                    }
        
                    fd.append(formKey, value);
                    }
                }
                }
        
                return fd;
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



