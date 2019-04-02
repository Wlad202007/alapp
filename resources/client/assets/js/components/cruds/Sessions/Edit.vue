<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Sessions</h1>
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
                                    <label for="user">User *</label>
                                    <v-select
                                            name="user"
                                            label="name"
                                            @input="updateUser"
                                            :value="item.user"
                                            :options="usersAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="presentation">Presentation</label>
                                    <input
                                            type="file"
                                            class="form-control"
                                            @change="updatePresentation"
                                    >
                                    <ul v-if="item.presentation" class="list-unstyled">
                                        <li>
                                            {{ item.presentation.name || item.presentation.file_name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removePresentation"
                                            >
                                                Remove file
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="event">Event *</label>
                                    <v-select
                                            name="event"
                                            label="name"
                                            @input="updateEvent"
                                            :value="item.event"
                                            :options="eventsAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea
                                            rows="3"
                                            class="form-control"
                                            name="description"
                                            placeholder="Enter Description"
                                            :value="item.description"
                                            @input="updateDescription"
                                            >
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject *</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="subject"
                                            placeholder="Enter Subject *"
                                            :value="item.subject"
                                            @input="updateSubject"
                                            >
                                </div>
								<div class="form-group">
                                    <label for="question">Question </label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="question"
                                            placeholder="Enter Question"
                                            :value="item.question"
                                            @input="updateQuestion"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="time_from">Time from</label>
                                    <date-picker
                                            :value="item.time_from"
                                            :config="$root.dpconfigTime"
                                            name="time_from"
                                            placeholder="Enter Time from"
                                            @dp-change="updateTime_from"
                                            >
                                    </date-picker>
                                </div>
                                <div class="form-group">
                                    <label for="time_to">Time to</label>
                                    <date-picker
                                            :value="item.time_to"
                                            :config="$root.dpconfigTime"
                                            name="time_to"
                                            placeholder="Enter Time to"
                                            @dp-change="updateTime_to"
                                            >
                                    </date-picker>
                                </div>
                                <div class="form-group">
                                    <label for="day">Day</label>
                                    <date-picker
                                            :value="item.day"
                                            :config="$root.dpconfigDate"
                                            name="day"
                                            placeholder="Enter The Day"
                                            @dp-change="updateDay"
                                            >
                                    </date-picker>
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
        ...mapGetters('SessionsSingle', ['item', 'loading', 'usersAll', 'eventsAll']),
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
        ...mapActions('SessionsSingle', ['fetchData', 'updateData', 'resetState', 'setUser', 'setPresentation', 'setEvent', 'setDescription', 'setSubject','setQuestion', 'setTime_from', 'setTime_to', 'setDay']),
        updateUser(value) {
            this.setUser(value)
        },
        removePresentation(e, id) {
            this.$swal({
                title: 'Are you sure?',
                text: "To fully delete the file submit the form.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#dd4b39',
                focusCancel: true,
                reverseButtons: true
            }).then(result => {
                if (typeof result.dismiss === "undefined") {
                    this.setPresentation('');
                }
            })
        },
        updatePresentation(e) {
            this.setPresentation(e.target.files[0]);
            this.$forceUpdate();
        },
        updateEvent(value) {
            this.setEvent(value)
        },
        updateDescription(e) {
            this.setDescription(e.target.value)
        },
        updateSubject(e) {
            this.setSubject(e.target.value)
        },
        updateTime_from(e) {
            this.setTime_from(e.target.value)
        },
        updateTime_to(e) {
            this.setTime_to(e.target.value)
        },
        updateDay(e) {
            this.setDay(e.target.value)
        },
		 updateQuestion(e) {
            this.setQuestion(e.target.value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'sessions.index' })
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
