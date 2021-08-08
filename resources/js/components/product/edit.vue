<template>
    <div>

       <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Product</li>
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
                    <router-link to="/product" class="btn btn-sm btn-primary"> 
                        <i class="fas fa-arrow-left"></i> Back to Product List
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
                    <form enctype="multipart/form-data" method="POST" @submit.prevent="productUpdate">

                    <div class="form-group mb-2">
                        <label for="category_name">Product Name</label>
                        <input type="text" class="form-control" v-model="form.name" name="name" id="name" aria-describedby="name" placeholder="Enter Product Name">
                        <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                    </div>
                    <div class="form-group mb-2">
                        <!-- <label for="category_name">Category</label>
                        <input type="text" class="form-control" v-model="form.category" name="category" id="category" aria-describedby="category" placeholder="Enter Category Name">
                        -->
                        <select v-model="form.category" class="form-control" id="category" name="category">
                        <option :value="cat.category_name" v-for="cat in categories" :key="cat.id">{{ cat.category_name }}</option>
                        </select>
                        <small class="text-danger" v-if="errors.category">{{ errors.category[0] }}</small>
                    </div>
                    <div class="form-group mb-2">
                        <!-- <input type="text" class="form-control" v-model="form.category_name" name="category_name" id="category_name" aria-describedby="category_name" placeholder="Enter Category Name"> -->
                        <div class="form-group">
                            <label for="category_name">Description</label>
                            <!-- <textarea v-model="form.description" class="form-control" id="description" name="description" rows="3"></textarea> -->
                            <vue-editor id="editor" useCustomImageHandler v-model="form.description"> </vue-editor>
                        </div>
                        <small class="text-danger" v-if="errors.description">{{ errors.description[0] }}</small>
                    </div>

                    <div class="form-group mb-2">
                        <date-picker v-model="form.date_time" value="form.date_time" default-value="form.date_time"  type="datetime" format="MMMM D YYYY, h:mm A"></date-picker>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm float-right">Submit<i class="fas fa-save"></i></button>
                    
                    </form>
                </div>
                </div>
                <!-- /.card-body -->

                <!-- <div class="card-footer">
                </div> -->
                <!-- /.card-footer-->

            </div>
            <!-- /.card -->

        </section>
 
        </div>
</template>
<script>
// include date time picker
import moment from 'moment';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import { VueEditor } from "vue2-editor";

export default 
{
    // date picker component
    components: { DatePicker, VueEditor },
    
    created() {
        // get the current URL on the browser and pass all the data retrieve 
        // on table employee

        if(this.$route.params.id == undefined) {
            // redirect to main page
             this.$router.push({name: 'product'})
        }
        
       this.product_id =  this.$route.params.id;
       
       // view category
       this.viewCategory();
       this.productView(this.product_id);
    },
    data(){
        return {
            form:{
                name:'',
                category:'',
                description:'',
                date_time:'',
                images:[],
            },
            product_id:'',
            errors:{},
            categories:{},
        }
    },
    methods:{
        // - view category on table `categories`
        viewCategory() {
            // view category
             axios
            .get('/api/category/')
            .then(({data})=> (this.categories=data)
            ).catch((err) => {
                // show error on development 
                console.log(err)
            });
        },
        productView(id) 
        {
           axios
           .get('/api/product/' + id)
           .then(({data}) => {
            // pass data value in form field
            //console.log(data.date_time);
            //    console.log(moment(data.date_time).format("MMMM D YYYY, h:mm A"));
            // {asd : asdsa, asd : asd}
            this.form = {...data, date_time : new Date(data.date_time)}
               
            //    this.form = data 
            //    console.log(this.form);
           })
           .catch((err) => {
               console.log(err);
           });
        },
        productUpdate(){

            const param =   {...this.form, date_time: moment(this.form.date_time).format('YYYY-M-D H:mm:ss')};
            axios
            .patch('/api/product/' + this.product_id, param)

            .then((res)=> {
                // redirect to product list page
                this.$router.push({name: 'product'})
                // // show message success
                this.$noty.success("New category has been saved!")
                // console.log(res);
            })
            .catch((err) =>{
                // pass error to global errors variable
                this.errors = err.response.data.errors;

            });
        }
    }
}
</script>
<style scoped>

</style>