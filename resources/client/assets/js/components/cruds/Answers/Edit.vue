<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Answers</h1>
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
                                    <label for="question">Question</label>
                                    <v-select
                                            name="question"
                                            label="text"
                                            @input="updateQuestion"
                                            :value="item.question"
                                            :options="answersAll"
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
                                    <label for="text">Text *</label>
                                    <textarea
                                            rows="3"
                                            class="form-control"
                                            name="text"
                                            placeholder="Enter Text *"
                                            :value="item.text"
                                            @input="updateText"
                                            >
                                    </textarea>
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
        ...mapGetters('AnswersSingle', ['item', 'loading', 'sessionsAll', 'answersAll', 'usersAll']),
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
        ...mapActions('AnswersSingle', ['fetchData', 'updateData', 'resetState', 'setSession', 'setQuestion', 'setAuthor', 'setText']),
        updateSession(value) {
            this.setSession(value)
        },
        updateQuestion(value) {
            this.setQuestion(value)
        },
        updateAuthor(value) {
            this.setAuthor(value)
        },
        updateText(e) {
            this.setText(e.target.value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'answers.index' })
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
