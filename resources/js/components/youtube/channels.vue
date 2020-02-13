<template>
    <form>
        <div class="row">
            <div class="col input-group">
                <select name="channel" class="form-control mr-2" id="channeldIdField" v-model="selectedChannel">
                    <option disabled value="">Please select one</option>
                    <option :value=channel v-for="(channel, index) in channels">{{ index }}</option>
                </select>
                <div class="">
                    <button class="btn btn-outline-primary" @click.prevent="changeChannel(selectedChannel)">Show</button>
                    <a class="btn btn-outline-danger" @click.prevent="changeChannel()">Clear</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import eventBus from '../event-bus';

    export default {
        data () {
            return {
                channels: [],
                channel: {},
                channel_id: '',
                selectedChannel: ''
            }
        },

        created () {
            this.fetchChannels()
        },
        methods: {
            fetchChannels () {
                fetch(window.app.url+'/youtube', {
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.channels = res.channels;
                    }).catch(err => console.error(err));
            },

            changeChannel(selectedChannel) {
                eventBus.$emit('selected', selectedChannel);
            }
        }
    }
</script>
