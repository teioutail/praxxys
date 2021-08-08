<template>
    
    <div>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Videos Link</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Videos Link</li>
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
                    <!-- video player here-->
                    <video-player src='videos/samplevideo.mp4'></video-player>
                    <!-- "{{ asset('videos/samplevideo.mp4') }}" -->
                </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
// require styles
import 'video.js/dist/video-js.css'
// instance of video player
import VideoPlayer from './VideoPlayer.vue'

export default {
    components: {
        VideoPlayer
    },
}
</script>
<style scoped>

</style>
