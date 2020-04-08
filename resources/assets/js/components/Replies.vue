<template>
    <div>
        <div v-for="(reply,index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <paginator :dataSet="dataSet" @changed="fetch"></paginator>
        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply'
    import NewReply from './NewReply'
    export default {
        props: ['data', 'thread_id'],
        components: {Reply, NewReply},
        data() {
            return {
                dataSet:false,
                items: [],
                endpoint: location.pathname+'/replies'
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch(page) {
                axios.get(this.url(page)).then(this.refresh);
            },

            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }

                return `${location.pathname}/replies?page=${page}`;
            },
            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;
            },
            remove(index)
            {

                this.items.splice(index,1);
                this.$emit('removed');


                flash('删除回复成功!');
            },
            add(reply){
                this.items.push(reply);
                this.$emit('added')
            },

        }
    }
</script>