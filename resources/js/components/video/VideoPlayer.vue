<template>
    <video
    controls
    width="640"
    height="264"
    preload="auto"
    ref="video-player"
    class="video-js vjs-big-play-centered"
    >
    <source v-bind:src="src" type="video/mp4" />
    </video>
</template>
<script>
import videojs from 'video.js';

export default {
    props: ['src'],
    data(){
        return {
            player: null,
    }
    },
    mounted(){
        // get reference of video tag
       const element = this.$refs['video-player'];

       this.player = videojs(element, {
           fluid: false
       })
        // set volume
       this.player.volume(0.5);
    }
}
</script>
<style scoped>

</style>