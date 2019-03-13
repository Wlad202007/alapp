<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Events</h1>
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
                                            <th>Name</th>
                                            <td>{{ item.name }}</td>
                                            </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td v-html="item.description"></td>
                                            </tr>
                                        <tr>
                                            <th>Date from</th>
                                            <td>{{ item.date_from }}</td>
                                            </tr>
                                        <tr>
                                            <th>Date to</th>
                                            <td>{{ item.date_to }}</td>
                                            </tr>
                                        <tr>
                                            <th>Full agenda</th>
                                            <td v-html="item.full_agenda_link"></td>
                                            </tr>
                                        <tr>
                                            <th>Web url</th>
                                            <td>{{ item.web_url }}</td>
                                            </tr>
                                        <tr>
                                            <th>Attendees</th>
                                            <td>
                                                <span class="label label-info" v-for="attendees in item.attendees">
                                                    {{ attendees.name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Agenda Requests</th>
                                            <td>
                                                <span v-for="agenda_request in item.agenda_requests">
                                                  <router-link
                                                          :to="{ name: 'users.show', params: { id: agenda_request.id } }"
                                                          class="btn btn-primary"
                                                  >
													{{ agenda_request.name }} - {{ agenda_request.email }}
													</router-link>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Sponsors</th>
                                            <td>
                                                <span class="label label-info" v-for="sponsors in item.sponsors">
                                                    {{ sponsors.name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Agenda</th>
                                            <td>
												<router-link :to="{ name: 'agendas.event', params: { event: item.id } }" class="btn btn-warning btn-block" >
													View
												</router-link>
                                                <span class="label label-info" v-for="agenda in item.agenda">
                                                    {{ agenda.text }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Industry</th>
                                            <td>
                                                <span class="label label-info" v-if="item.industry !== null">
                                                    {{ item.industry.name }}
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
        ...mapGetters('EventsSingle', ['item'])
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('EventsSingle', ['fetchData', 'resetState'])
    }
}
</script>


<style scoped>

</style>
