<template>
    <div>
        <div class="media mt-3" v-for="(video, index) in videos" :key="video.id">
            <youtube-video :model="video" v-if="isNotEmpty"></youtube-video>
        </div>
        <div class="mt-3" v-if="!isNotEmpty">
            <hr>
            Playlist is empty
        </div>
        <nav class="pages-border" v-if="showPagination">
            <ul class="pagination">
                <li class="page-item" :class="[{disabled: !pagination.prev}]">
                    <a class="page-link" href="" title="Previous page" @click.prevent="fetchVideos(currentChannel, pagination.prev)">&lsaquo;</a>
                </li>

                <li class="page-item" v-bind:class="[{disabled: !pagination.next}]">
                    <a class="page-link" href="" title="Next page" @click.prevent="fetchVideos(currentChannel, pagination.next)">&rsaquo;</a>
                </li>
            </ul>
        </nav>
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
                pagination: {},
                currentChannel: '',
            }
        },

        created () {
            this.fetchVideos();
            eventBus.$on('selected', selected => {
                this.fetchVideos(selected);
            })
        },

        methods: {
            fetchVideos (target, page) {
                let url = new URL(window.app.url+'/youtube');
                let params = {
                    channel: (target || ''),
                    page: (page || ''),
                };
                Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

                fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.videos = (res.videos) ? res.videos.items : [];

                        this.makePagination(res.pages);
                        this.currentChannel = res.currentChannel;
                    }).catch(err => console.error(err));
            },
            makePagination(page) {
                this.pagination = page ? {
                    next: page.next,
                    prev: page.prev,
                    total: page.total,
                    inPage: page.inPage,
                } : {};
            }
        },

        computed: {
            isNotEmpty() {
                return this.videos.length > 0;
            },
            showPagination() {
                return this.pagination.total > this.pagination.inPage;
            }
        }
    }
</script>
