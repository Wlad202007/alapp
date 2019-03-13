<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Posts</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">View</h3>
                        </div>

                        <div class="box-body">
                            <back-buttton></back-buttton>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <th>#</th>
                                            <td>{{ item.id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Group</th>
                                            <td>
                                                <span class="label label-info" v-if="item.group !== null">
                                                    {{ item.group.name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Author</th>
                                            <td>
                                                <span class="label label-info" v-if="item.author !== null">
                                                    {{ item.author.name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Body</th>
                                            <td>{{ item.body }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gallery</th>
                                            <td v-html="item.gallery_link"></td>
                                        </tr>
                                        <tr>
                                            <th>Parent</th>
                                            <td>
                                                <span class="label label-info" v-if="item.parent !== null">
                                                    {{ item.parent.body }}
                                                </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
        created() {
            this.fetchData(this.$route.params.id)
        },
        destroyed() {
            this.resetState()
        },
        computed: {
            ...mapGetters('PostsSingle', ['item'])
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
    ...mapActions('PostsSingle', ['fetchData', 'resetState'])
    }
    }
</script>


<style scoped>

</style>