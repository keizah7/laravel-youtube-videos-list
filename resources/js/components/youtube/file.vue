<template>
        <div class="d-flex align-items-start">
            <img :src=video.snippet.thumbnails.default.url class="mr-3" alt="...">
            <div class="media-body">
                <h5 class="mt-0">
                    <a target="__blank">{{ video.snippet.title }}</a>
                </h5>
                <p>{{ short(video.snippet.description) }}</p>
            </div>
            <div>
                <button class="btn btn-outline-success" @click.prevent="saveVideo(video.snippet.resourceId.videoId)">Save</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['model'],
        data () {
            return {
                video: this.model,
            }
        },

        methods: {
            short(value) {
                return value.substring(0, 180)+"...";
            },

            saveVideo(id) {
                var formdata = new FormData();
                formdata.append('id', id);

                fetch('http://ytapi.com/videos', {
                    method: 'POST',
                    body: formdata,
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        alert(res.message);
                    })
                    .catch(err => console.error(err));
            },
        }
    }
</script>
