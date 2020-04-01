<script type="module">
    import  Replies  from '../components/Replies.vue';

    export default {
        props: ['thread'],
        data() {
            return {
                repliesCount: this.thread.replies_count,
            }
        },
        components: { Replies }
    }
</script>