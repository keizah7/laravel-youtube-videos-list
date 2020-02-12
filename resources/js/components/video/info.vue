<template>
    <p class="text-muted d-flex justify-content-between align-content-center mt-1">
        <span>Uploaded by: {{ video.user.name }}</span>
        <span>
            {{ video.created_at }}
        </span>
    </p>
</template>

<script>
    export default {
        props: ['model'],

        data() {
            return {
                video: this.model
            }
        }
    }
</script>
