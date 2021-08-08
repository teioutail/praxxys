<!--
* Product List Component
*
* Author: Sean Cheseter Lagdameo <slagdameo@gmail.com> 
* since: 2021/08/06 
*
-->
<template>

    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product List</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <router-link to="/store-product" class="btn btn-sm btn-primary"> 
                        <i class="fas fa-plus-circle"></i> Create
                    </router-link>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="container-fluid" id="container-wrapper">
                        
                        <div class="float-right" style="width:500px;">
                            <b>Filter:</b> 
                            <div class="input-group float-right mb-5">
                                <input id="keyword" name="keyword" type="search" v-model="form.keyword" class="form-control" placeholder="Type your keywords here" value="Lorem ipsum" />
                                <select id="category" name="category" v-model="form.category" class="form-control">
                                    <option value="">All Category</option>
                                    <option :value="cat.category_name" v-for="cat in categorize" :key="cat.id">{{ cat.category_name }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" @click="searchProducts">Search</button>
                                </div>
                            </div>
                        </div>

                        <table class="table table-hover text-wrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- retrieve all employee record -->
                                <tr v-for="product in products" :key="product.id"> 
                                    <td>{{ product.name }}</td>
                                    <td>{{ product.category }}</td>
                                    <td v-html="product.description"></td>
                                    <!-- <td v-html="product.description">{{ strip_tags(product.description) }}</td> -->
                                    <!-- <td>{{ product.description.replace(/<\/?[^>]+>/gi, '') }}</td> -->
                                    <td>
                                        <div class="btn-group" role="group">
                                            <router-link :to="{name:'edit-product', params:{id:product.id}}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </router-link>
                                            <a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <nav>
                            <ul class="pagination">
                                <!-- <tr v-for="product in products" :key="product.id">  -->
                                <li :class="[{ active: item.active? true : false} , { disabled: item.url == null ? true : false}]"
                                    v-for="(item, index) in pagination" :key="index" class="page-item">
                                    <a class="page-link" style="cursor:pointer" @click="paginateItem(item)" v-html="item.label" ></a>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
            <!-- /.card-body -->

            <div class="card-footer">
                &nbsp;
            </div>
            <!-- /.card-footer-->

        </div>
        <!-- /.card -->

    </section>

    <!-- /.content -->
</div>
    
</template>
<script>
    export default {
        created() {
            // view all in record product table
            this.allProducts();
            this.viewCategory();
        },
        data() {
            return {
                products:[],
                searchTerm:'',
                categorize:[], // handle all data in categories table
                form:{category:'',keyword:''}, // search/select fields
                pagination: [], // hold pagination links
                urlpage:'', // 
            }
        },
        computed: {
            filtersearch() {
                return this.products.filter((product) => {
                    return (product.name.match(this.searchTerm) || product.description.match(this.searchTerm))
                })
            },
        },
        methods: {

            // view all products
            allProducts() {
                axios
                .get('/api/product/')
                .then((res) => {

                    this.products = res.data.data;
                    
                    // pass link to pagination variable
                    this.pagination = res.data.links;

                    // this.urlpage = res.data.url;

                })
                .catch((err) => {
                    // show error on development 
                    console.log(err)
                });
            },

            // pagination
            paginateItem(item){
                axios
                .get(item.url, { params: { keyword: this.form.keyword, category: this.form.category}})
                .then((res) => {
                    // products
                    this.products = res.data.data
                    // pass link to pagination variable
                    this.pagination = res.data.links;
                    // get the selected pagination url
                    this.urlpage = res.config.url;
                }
                ).catch((err) => {
                    // show error on development 
                    console.log(err)
                });
            },

            // - view category on table `categories`
            viewCategory() {
                axios
                .get('/api/category/')
                .then(({data}) => {
                    
                    this.categorize = data;

                }).catch((err) => {
                    // show error on development 
                    console.log(err)
                });
            },

            searchProducts($event){
                // this.keyword = $event.target.value;
                let keyword = this.form.keyword;
                let category = this.form.category;

                axios
                .get('/api/product/', { params: { keyword: keyword, category: category}})
                .then((res) => {

                    this.products = res.data.data;
                    // pass link to pagination variable

                    this.pagination = res.data.links;
                    // this.urlpage = res.data.url;

                })
                .catch((err) => {
                    // show error on development 
                    console.log(err)
                });
                
            },

            deleteProduct(id) {
                
                // trigger sweet alert
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {

                    if (result.isConfirmed) {
                        axios
                        .delete('/api/product/' + id)
                        .then(() => {
                            // refresh view product records
                            this.products = this.products.filter((product) => {
                                return product.id != id 
                            })
                        })
                        .catch((err) => {
                            // redirect to product main page
                            this.$router.push({name: 'product'})
                        })

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }

                })
            },
            
            strip_tags(str) {
                str = str.toString();

                if(str != null) {
                    return str.replace(/<\/?[^>]+>/gi, '');
                }
                return str;
            }
            
        }
    }
</script>

<style scoped>

</style>