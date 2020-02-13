<template>
    <div>
        <div class="media mt-3" v-for="(video, index) in videos" :key="video.id">
            <youtube-video :model="video" v-if="isNotEmpty"></youtube-video>
        </div>
        <div class="mt-3" v-if="!isNotEmpty">
            <hr>
            Playlist is empty
        </div>
    </div>
</template>

<script>
    import eventBus from '../event-bus';

    export default {
        data () {
            return {
                videos: [],
                video: {},
                video_id: '',
                pagination: {}
            }
        },

        created () {
            this.fetchVideos();
            eventBus.$on('selected', selected => {
                this.fetchVideos(selected);
            })
        },

        methods: {
            fetchVideos (target) {
                let url = new URL('http://ytapi.com/youtube');
                let params = {
                    channel: (target || '')
                };
                Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

                console.log(url);

                fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.videos = res.videos.items;
                    }).catch(err => console.error(err));
            }
        },

        computed: {
            isNotEmpty() {
                return this.videos.length > 0;
            }
        }
    }
</script>
