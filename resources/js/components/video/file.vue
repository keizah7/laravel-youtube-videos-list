<template>
    <div class="media-body">
        <div class="d-flex align-items-start">
            <img :src=video.photo class="mr-3" alt="...">
            <div class="media-body">
                <h5 class="mt-0">
                    <a :href=video.url target="__blank">{{ video.title }}</a>
                </h5>
                <p>{{ video.short_description }}</p>
            </div>
            <div>
                <button class="btn btn-danger" v-if="canDelete" @click="deleteVideo(video.id)">Delete</button>
            </div>
        </div>

        <video-info :model="video"></video-info>
    </div>
</template>

<script>
    export default {
        props: ['model'],
        data () {
            return {
                video: this.model,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },

        methods: {
            deleteVideo(id) {
                if(confirm('Are you sure?')) {
                    fetch(`/videos/${id}`, {
                        body: JSON.stringify({
                            '_token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }),
                        method: 'delete',
                        headers: {
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        this.$parent.fetchVideos();
                    })
                    .catch(err => console.error(err));
                }
            },
        },

        computed: {
            canDelete() {
                return window.auth.isLeader;
            }
        }
    }
</script>
