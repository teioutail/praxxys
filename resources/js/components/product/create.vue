<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Product</h1>
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
                <form method="POST" @submit.prevent="productInsert">
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
                            <section v-show="step == 1">
                                <h4>Step 1</h4> <hr />
                                <div class="form-group mb-2">
                                    <label for="name">Product Name</label>
                                    <input type="text" class="form-control" v-model="form.name" name="name" id="name" aria-describedby="name" placeholder="Enter Product Name">
                                    <small class="text-danger" v-if="errors.name">{{ errors.name }}</small>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="category">Category</label>
                                    <select v-model="form.category" class="form-control" id="category" name="category">
                                    <!-- <option></option> -->
                                    <option :value="cat.category_name" v-for="cat in categories" :key="cat.id">{{ cat.category_name }}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.category">{{ errors.category }}</small>
                                </div>
                                <div class="form-group mb-2">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <!-- <textarea v-model="form.description" class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea> -->
                                        <!-- <vue-editor id="editor" useCustomImageHandler @image-added="handleImageAdded" v-model="form.description"> </vue-editor> -->
                                        <vue-editor id="editor" useCustomImageHandler v-model="form.description"> </vue-editor>

                                    </div>
                                    <small class="text-danger" v-if="errors.description">{{ errors.description }}</small>
                                </div>
                            </section>

                            <section v-show="step == 2">
                                <h4>Step 2</h4> <hr />
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="files" ref="files" :change="handleFileUploads" multiple>
                                        <label class="custom-file-label" for="files">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                        </div>
                                    </div>
                                        <small class="text-danger" v-if="errors.image">{{ errors.image }}</small>
                                    </div>
                                    
                            </section>

                            <section v-show="step == 3">
                                <h4>Step 3</h4> <hr />
                                <label for="datetime">Date Picker</label>
                                <div class="form-group mb-2">
                                    <date-picker v-model="form.datetime" type="datetime" format="MMMM D YYYY, h:mm A"></date-picker>
                                    <small class="text-danger" v-if="errors.datetime">{{ errors.datetime }}</small>
                                </div> 
                            </section>
                        
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button class="btn btn-primary btn-sm float-left" v-if="step !== 1" @click.prevent="prevStep"><i class="fas fa-arrow-circle-left"></i>Prev Step</button>
                    <button class="btn btn-primary btn-sm float-right" v-if="step != totalsteps" @click.prevent="nextStep">Next Step <i class="fas fa-arrow-circle-right"></i></button>
                    <button type="submit" class="btn btn-primary btn-sm float-right" v-if="step == totalsteps">Submit <i class="fas fa-save"></i></button>
                </div>
                <!-- /.card-footer-->
            </form>
            </div>
            <!-- /.card -->
        </section>
    </div>
</template>

<script>
// include date time picker
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import moment from 'moment';
import { VueEditor } from "vue2-editor";

export default {
    components: {
         DatePicker, VueEditor 
    },
    created() {
        this.viewCategory();
    },
    data() {
        return {
            form: {
                name: null,
                category: null,
                description: null,
                images:[], // for multiple image upload'
                datetime: null,
                files:[],
            },
            errors: {}, // handle form validation error
            categories: {}, // item category in categories table
            images:[],
            step: 1, //
            totalsteps: 3, //
        }
    },
    methods: {
        nextStep() {
            if(this.step == 1){
                if(!this.form.name){
                    this.errors = {'name':'Please fill up product name'};
                    return false;
                }

                if(!this.form.category){
                    this.errors = {'category':'Please Choose in category'};
                    return false;
                }

                if(!this.form.description) {
                    this.errors = {'description':'Please fill up description'};
                    return false;
                }
                this.step++; // increment
                this.errors = {};
            } else if(this.step == 2){
                
                if(this.$refs.files.files.length < 1) {
                    this.errors = {'image':'Please upload file'};
                    return false;
                }
                this.step++;

            } else if(this.step == 3){
               
               this.step++;
            }
             
        },
        prevStep(){
            this.step--;
        },
        handleFileUploads(){
            this.form.files = this.$refs.files.files;
            
        },
        // - view category on table `categories`
        viewCategory() {

            axios
            .get('/api/category/')
            .then(({data})=> (this.categories=data)

            ).catch((err) => {
                // show error on development 
                // console.log(err)
            });
        },
        productInsert() {
            /*
            Make the request to the POST /multiple-files URL
            */
            const config = {
                headers:{'content-type' : 'multipart/form-data'}
            }
            /*
            Initialize the form data
            */
            let formData = new FormData();

            // validate date time
           if(!this.form.datetime) {
                this.errors = {'datetime':'Please choose date and time'};
                return false;
           }
            /*
            Iteate over any file sent over appending the files
            to the form data.
            */
            for(let i=0; i < this.$refs.files.files.length; i++) 
            {
                let file = this.$refs.files.files[i];
                // save to global variable files
                this.form.files.push(file);
                // - 
                formData.append('files['+ i +']', file);
            }
           
            formData.append('name', this.form.name ? this.form.name : '');
            formData.append('category', this.form.category ? this.form.category : '');
            formData.append('description', this.form.description ? this.form.description : '');
            formData.append('date_time', this.form.datetime ? moment(this.form.datetime).format('YYYY-M-D H:mm:ss') : '');

            axios
            .post('/api/product/',formData, config)
            .then((res)=>{
                console.log(res);
                this.$router.push({name: 'product'})
                this.$noty.success("New product has been saved!")
            })
            .catch((err)=> {
                // pass error to global errors variable
                // this.errors = err.response.data.errors;
                
                // error.response.data
                // include sweet alert animation
                // Toast.fire({
                //     icon: 'warning',
                //     title: 'Please complete the required fields'
                // })
 
                if(err.response.data){
                    const validator = err.response.data;
                    for (var key in validator) {
                        if (validator.hasOwnProperty(key)) {
                            Toast.fire({
                                icon: 'warning',
                                title: validator[key]
                            })
                        }
                    }
                }
            });
        },
  }

}
</script>
<style scoped>
#my-strictly-unique-vue-upload-multiple-image {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>