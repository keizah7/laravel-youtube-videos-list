<template>
    <div class="card-body">
        <div class="media" v-for="(video, index) in videos" :key="video.id">
            <video-file :model="video"></video-file>
        </div>

        <nav class="pages-border" v-if="showPagination">
            <ul class="pagination">
                <li class="page-item" :class="[{disabled: !pagination.prev}]">
                    <a class="page-link" href="#" title="Previous page" @click="fetchVideos(pagination.prev)">&lsaquo;</a>
                </li>

                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#">Page {{ pagination.current }} of {{ pagination.last }}</a>
                </li>

                <li class="page-item" v-bind:class="[{disabled: !pagination.next}]">
                    <a class="page-link" href="#" title="Next page" @click="fetchVideos(pagination.next)">&rsaquo;</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
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
            this.fetchVideos()
        },

        methods: {
            fetchVideos (page_url) {
                let vm = this;
                page_url = page_url || '/videos'
                fetch(page_url, {
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                    .then(res=>res.json())
                    .then(res => {
                        vm.makePagination(res.meta, res.links);
                        this.videos = res.data;
                    }).catch(err => console.error(err));
            },
            makePagination(meta, links) {
                this.pagination = {
                    current: meta.current_page,
                    last: meta.last_page,
                    next: links.next,
                    prev: links.prev,
                    total: meta.total,
                    inPage: meta.per_page,
                }
            }
        },

        computed: {
            signedIn() {
                return window.auth.signedIn;
            },
            showPagination() {
                return this.pagination.total > this.pagination.inPage;
            }
        }
    }
</script>

<style>
    .media, .pages-border {
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        padding-top: 1em;
    }
</style>
