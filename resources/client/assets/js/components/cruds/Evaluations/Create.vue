<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Evaluations</h1>
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
                                    <label for="user">User</label>
                                    <v-select
                                            name="user"
                                            label="name"
                                            @input="updateUser"
                                            :value="item.user"
                                            :options="usersAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="event">Event</label>
                                    <v-select
                                            name="event"
                                            label="name"
                                            @input="updateEvent"
                                            :value="item.event"
                                            :options="eventsAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="text">Text</label>
                                    <textarea
                                            rows="3"
                                            class="form-control"
                                            name="text"
                                            placeholder="Enter Text"
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
        ...mapGetters('EvaluationsSingle', ['item', 'loading', 'usersAll', 'eventsAll'])
    },
    created() {
        this.fetchUsersAll(),
        this.fetchEventsAll()
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('EvaluationsSingle', ['storeData', 'resetState', 'setUser', 'setEvent', 'setText', 'fetchUsersAll', 'fetchEventsAll']),
        updateUser(value) {
            this.setUser(value)
        },
        updateEvent(value) {
            this.setEvent(value)
        },
        updateText(e) {
            this.setText(e.target.value)
        },
        submitForm() {
            this.storeData()
                .then(() => {
                    this.$router.push({ name: 'evaluations.index' })
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
