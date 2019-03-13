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
                                <h3 class="box-title">Create</h3>
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
        ...mapGetters('AnswersSingle', ['item', 'loading', 'sessionsAll', 'answersAll', 'usersAll'])
    },
    created() {
        this.fetchSessionsAll(),
        this.fetchAnswersAll(),
        this.fetchUsersAll()
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('AnswersSingle', ['storeData', 'resetState', 'setSession', 'setQuestion', 'setAuthor', 'setText', 'fetchSessionsAll', 'fetchAnswersAll', 'fetchUsersAll']),
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
            this.storeData()
                .then(() => {
                    this.$router.push({ name: 'answers.index' })
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
