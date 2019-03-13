<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Agendas</h1>
			<div class="box-body">
                                <back-buttton></back-buttton>
                            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
						
                            <h3 class=" text-center">{{data[0]?data[0].event.name:''}}</h3>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <router-link
                                        v-if="$can(xprops.permission_prefix + 'create')"
                                        :to="{ name: xprops.route + '.create',params:{event: xprops.params}}"
                                        class="btn btn-success btn-sm"
                                        >
                                    <i class="fa fa-plus"></i> Add new
                                </router-link>

                                <button type="button" class="btn btn-default btn-sm" @click="fetchData(xprops.params)">
                                    <i class="fa fa-refresh" :class="{'fa-spin': loading}"></i> Refresh
                                </button>
                            </div>
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
                                    :data="data"
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
import DatatableActions from '../Agendas/dtmodules/DatatableActions'
import DatatableSingle from '../../dtmodules/DatatableSingle'
import DatatableList from '../../dtmodules/DatatableList'
import DatatableCheckbox from '../../dtmodules/DatatableCheckbox'
import DatatableTextField from '../Agendas/dtmodules/DatatableTextField'

export default {
    data() {
        return {
            columns: [
                { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
             //   { title: 'Event', field: 'event', tdComp: DatatableSingle },
				{ title: 'Date', field: 'date', sortable: true },
                { title: 'Time', field: 'time', sortable: true },
            //    { title: 'Text', field: 'text', sortable: true },
			   { title: 'Text', tdComp: DatatableTextField, sortable: false },
				
                { title: 'Actions', tdComp: DatatableActions, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
            ],
            query: { sort: 'date', order: 'asc' },
            xprops: {
                module: 'AgendasIndexevent',
                route: 'agendas.event',
                permission_prefix: 'agenda_',
				params:''
            }
        }
    },
    created() {
        this.$root.relationships = this.relationships
		this.xprops.params = this.$route.params.event
         this.fetchData(this.$route.params.event)
		 
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('AgendasIndexevent', ['data', 'total', 'loading', 'relationships']),
    },
    watch: {
		"$route.params.event": function() {
            this.resetState()
            this.fetchData(this.$route.params.event)
        },
        query: {
            handler(query) {
                this.setQuery(query)
            },
            deep: true
        }
    },
    methods: {
        ...mapActions('AgendasIndexevent', ['fetchData', 'setQuery', 'resetState']),
    }
}
</script>


<style scoped>

</style>
