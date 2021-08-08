<template>

<div>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Create Category</li>
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
              <form method="POST" @submit.prevent="categoryInsert">
                  <div class="form-group mb-2">
                    <label for="category_name">Category</label>
                    <input type="text" class="form-control" v-model="form.category_name" name="category_name" id="category_name" aria-describedby="category_name" placeholder="Enter Category Name">
                    <small class="text-danger" v-if="errors.category_name">{{ errors.category_name[0] }}</small>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm">Submit <i class="fas fa-save"></i></button>
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

<script type="text/javascript">
export default {

  created() {
    
  },
  data() {
    return {
      form: {
        category_name: null,
        
      },
      errors: {} // handle error message
    }
  },
  methods: {
    categoryInsert() {
      axios
      .post('/api/category', this.form)
      .then((res) => {
        // redirect
        this.$router.push({name: 'store-category'})
        this.$noty.success("New category has been saved!")
        this.form.category_name = '';
        // alert(res);
      })
      .catch((error) => {
        // pass error to global errors variable
        this.errors = error.response.data.errors;
        // console.log(error);
      })
    }
  }
}
</script>
<style scope>

</style>
