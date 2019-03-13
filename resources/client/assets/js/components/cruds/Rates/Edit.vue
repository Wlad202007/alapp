<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Rate</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="session">Session *</label>
                                    <v-select
                                            name="session"
                                            label="subject"
                                            @input="updateSession"
                                            :value="item.session"
                                            :options="sessionsAll"
                                            />
                                </div>
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
                                    <label for="type">Type *</label>
                                    <div class="radio">
                                        <label>
                                            <input
                                                    type="radio"
                                                    name="type"
                                                    :value="item.type"
                                                    :checked="item.type === 'style'"
                                                    @change="updateType('style')"
                                                    >
                                            style
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input
                                                    type="radio"
                                                    name="type"
                                                    :value="item.type"
                                                    :checked="item.type === 'content'"
                                                    @change="updateType('content')"
                                                    >
                                            content
                                        </label>
                                    </div>
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
        ...mapGetters('RatesSingle', ['item', 'loading', 'sessionsAll', 'usersAll']),
    },
    created() {
        this.fetchData(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('RatesSingle', ['fetchData', 'updateData', 'resetState', 'setSession', 'setAuthor', 'setType']),
        updateSession(value) {
            this.setSession(value)
        },
        updateAuthor(value) {
            this.setAuthor(value)
        },
        updateType(value) {
            this.setType(value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'rates.index' })
                    this.$eventHub.$emit('update-success')
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
