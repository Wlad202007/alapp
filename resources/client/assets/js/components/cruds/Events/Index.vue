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
                            <h3 class="box-title">List</h3>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <router-link
                                        v-if="$can(xprops.permission_prefix + 'create')"
                                        :to="{ name: xprops.route + '.create' }"
                                        class="btn btn-success btn-sm"
                                        >
                                    <i class="fa fa-plus"></i> Add new
                                </router-link>

                                <button type="button" class="btn btn-default btn-sm" @click="fetchData">
                                    <i class="fa fa-refresh" :class="{'fa-spin': loading}"></i> Refresh
                                </button>
                            </div>
                        </div>

                        <div class="box-body">
                            <input class="col-md-6 btnbtn-default btn-sm" type="text" v-model="search" placeholder=" Search Name" >
                        </div>

                        <div class="box-body">
                            <div class="row" v-if="loading">
                                <div class="col-xs-4 col-xs-offset-4">
                                    <div class="alert text-center">
                                        <i class="fa fa-spin fa-refresh"></i> Loading
                                    </div>
                                </div>
                            </div>

                            <datatable
                                    v-if="!loading"
                                    :columns="columns"
                                    :data="filterByUser"
                                    :total="total"
                                    :query="query"
                                    :xprops="xprops"
                                    />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'
import DatatableActions from '../Events/dtmodules/DatatableActions'
import DatatableSingle from '../../dtmodules/DatatableSingle'
import DatatableList from '../../dtmodules/DatatableList'
import DatatableCounter from './dtmodules/DatatableCounter'
import DatatableTodayCounter from './dtmodules/DatatableTodayCounter'
import DatatableCheckbox from '../../dtmodules/DatatableCheckbox'
import DatatableFullAgendaField from './dtmodules/DatatableFullAgendaField'

export default {
    data() {
        return {
            columns: [
                { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
                { title: 'Name', field: 'name', sortable: true },

                { title: 'Date from', field: 'date_from', sortable: true },
                { title: 'Date to', field: 'date_to', sortable: true },
                { title: 'Full agenda', tdComp: DatatableFullAgendaField, sortable: false },
                { title: 'Web url', field: 'web_url', sortable: true },
                { title: 'Attendees', field: 'attendees', tdComp: DatatableList },
                { title: 'Sponsors', field: 'sponsors', tdComp: DatatableList },
                { title: 'Agenda', field: 'agenda', tdComp: DatatableList },
                { title: 'All Agenda Requests', field: 'agenda_model_request', tdComp: DatatableCounter },
                { title: 'Today Agenda Requests', field: 'agenda_model_request', tdComp: DatatableTodayCounter },
                { title: 'Industry', field: 'industry', tdComp: DatatableSingle },
                { title: 'Actions', tdComp: DatatableActions, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
            ],
            query: { sort: 'id', order: 'desc' },
            xprops: {
                module: 'EventsIndex',
                route: 'events',
                permission_prefix: 'event_'
            },
            search: '',
        }
    },
    created() {
        this.$root.relationships = this.relationships
        this.fetchData()
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('EventsIndex', ['data', 'total', 'loading', 'relationships','all_data']),

        filterByUser(){
          if (this.search == '') {
            return this.data;
          }
          else {
            return this.all_data.filter(d =>{
              return d.name.toLowerCase().includes(this.search.toLowerCase());
            });
          }
        },

    },
    watch: {
        query: {
            handler(query) {
                this.setQuery(query)
            },
            deep: true
        }
    },
    methods: {
        ...mapActions('EventsIndex', ['fetchData', 'setQuery', 'resetState']),
    }
}
</script>


<style scoped>

</style>
