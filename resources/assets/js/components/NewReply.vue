<template>
    <div>
        <div v-if="signIn">
        <div class="form-group">
                <textarea name="body"
                          id="body"
                          class="form-control"
                          placeholder="说点什么吧..."
                          rows="5"
                          required
                          v-model="body"></textarea>
        </div>

        <button type="submit" class="btn btn-default" @click="addReply">
            提交
        </button>
        </div>
        <div v-else>
            <p class="text-center">请先<a href="/login">登录</a>，然后再发表回复 </p>
        </div>


    </div>
</template>

<script>
    export default {
        props: ['endpoint'],
        data() {
            return {
                body:'',
            };
        },

        computed : {
            signIn(){
                return window.App.signIn;
            }

        },

        methods: {
            addReply() {
                axios.post(this.endpoint, { body:this.body })
                    .then(({data}) => {
                        this.body = '';

                        flash('创建回复成功！');

                        this.$emit('created',data);
                    });

            }
        }
    }
</script>