<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Likes</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Create</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="author">Author *</label>
                                    <v-select
                                            name="author"
                                            label="name"
                                            @input="updateAuthor"
                                            :value="item.author"
                                            :options="usersAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="post">Post *</label>
                                    <v-select
                                            name="post"
                                            label="body"
                                            @input="updatePost"
                                            :value="item.post"
                                            :options="postsAll"
                                            />
                                </div>
                            </div>

                            <div class="box-footer">
                                <vue-button-spinner
                                        class="btn btn-primary btn-sm"
                                        :isLoading="loading"
                                        :disabled="loading"
                                        >
                                    Save
                                </vue-button-spinner>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            // Code...
        }
    },
    computed: {
        ...mapGetters('LikesSingle', ['item', 'loading', 'usersAll', 'postsAll'])
    },
    created() {
        this.fetchUsersAll(),
        this.fetchPostsAll()
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('LikesSingle', ['storeData', 'resetState', 'setAuthor', 'setPost', 'fetchUsersAll', 'fetchPostsAll']),
        updateAuthor(value) {
            this.setAuthor(value)
        },
        updatePost(value) {
            this.setPost(value)
        },
        submitForm() {
            this.storeData()
                .then(() => {
                    this.$router.push({ name: 'likes.index' })
                    this.$eventHub.$emit('create-success')
                })
                .catch((error) => {
                    console.error(error)
                })
        }
    }
}
</script>


<style scoped>

</style>
