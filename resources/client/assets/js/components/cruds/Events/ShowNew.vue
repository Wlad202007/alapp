<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Event :{{ item.id }}</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="text-center">{{ item.name }}</h3>
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
                                            <th>Description</th>
                                            <td v-html="item.description"></td>
                                            </tr>
                                        <tr>
                                            <th><span>Date from </span>-<span> Date to</span> </th>
											
                                            <td><span>{{ item.date_from }}</span>{{' - '}}<span>{{ item.date_to }}</span></td>
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
                                        
                                        </tbody>
                                    </table>
                                </div>
								<div class="col-xs-6">
								
								<div class="box">
								<div class="box-header with-border">
						
									<h3 class=" text-center">Agenda</h3>
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

                                <button type="button" class="btn btn-default btn-sm" @click="fetchDataAgenda(xprops.params)">
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
							<div class="row">
							<div id="tabs" >
  
								<div class="tabs">
									<a v-on:click="activetab=1" v-bind:class="[ activetab === 1 ? 'active' : '' ]">Attendees</a>
									<a v-on:click="activetab=2" v-bind:class="[ activetab === 2 ? 'active' : '' ]">Sponsors</a>
									<a v-on:click="activetab=3" v-bind:class="[ activetab === 3 ? 'active' : '' ]">Industry</a>
								</div>

								<div class="content">
									<div v-show="activetab === 1" class="tabcontent">
										<span class="label label-info" v-for="attendees in item.attendees">
                                                    {{ attendees.name }}
                                                </span>
									</div>
									<div v-show="activetab === 2" class="tabcontent">
										<div class="box-body">
										<div class="btn-group">
											<router-link
												v-if="$can(sponsors.xprops.permission_prefix + 'create')"
												:to="{ name: sponsors.xprops.route + '.create',params:{event:sponsors.xprops.params,module:sponsors.xprops.module} }"
												class="btn btn-success btn-sm"
											>
												<i class="fa fa-plus"></i> Add new
											</router-link>

											<button type="button" class="btn btn-default btn-sm" @click="fetchDataSponsors(sponsors.xprops.params)">
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
												:columns="sponsors.columns"
												:data="sponsorsdata"
												:total="sponsorstotal"
												:query="sponsorsquery"
												:xprops="sponsors.xprops"
											/>
										</div>
									</div>
									<div v-show="activetab === 3" class="tabcontent">
										<span class="label label-info" v-if="item.industry !== null">
                                            {{ item.industry.name }}
                                        </span>
									</div>
								</div>
  
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
import DatatableActions from '../Agendas/dtmodules/DatatableActions'
import DatatableSingle from '../../dtmodules/DatatableSingle'
import DatatableList from '../../dtmodules/DatatableList'
import DatatableCheckbox from '../../dtmodules/DatatableCheckbox'
import DatatableTextField from '../Agendas/dtmodules/DatatableTextField'
import DatatableLogoField from '../Sponsors/dtmodules/DatatableLogoField'
import DatatableActionsSponsors from '../Sponsors/dtmodules/DatatableActionsSponsors'

export default {
    data() {
        return {
			
			sponsors:{
                      columns: [
					    { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
                { title: 'Name', field: 'name', sortable: true },
                { title: 'Description', field: 'description', sortable: true },
                { title: 'Website', field: 'website', sortable: true },
                { title: 'Logo', tdComp: DatatableLogoField, sortable: false },
                { title: 'Actions', tdComp: DatatableActionsSponsors, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
       
                   ],
            query: { sort: 'id', order: 'asc' },
            xprops: {
                module: 'EventsSinglenew',
                route: 'sponsors.event',
                permission_prefix: 'sponsor_',
				params:''
            },
			},  sponsorsquery: { sort: 'id', order: 'asc' ,offset:0,limit:10},
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
            },
			 activetab: 1 ,
			
        }
    },
    created() {
		 this.$root.relationships = this.relationships
		this.xprops.params = this.$route.params.id
		this.sponsors.xprops.params = this.$route.params.id
        
		this.fetchData(this.$route.params.id)
		this.fetchDataAgenda(this.$route.params.id)
		this.fetchDataSponsors(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('EventsSinglenew', ['item','data', 'sponsorsdata','total','sponsorstotal', 'loading', 'relationships','sponsorsrelationships'])
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
			this.xprops.params = this.$route.params.id
		this.sponsors.xprops.params = this.$route.params.id
        
            this.fetchData(this.$route.params.id)
			this.fetchDataAgenda(this.$route.params.id)
			this.fetchDataSponsors(this.$route.params.id)
        }, 
		query: {
            handler(query) {
                this.setQuery(query)
            },
			
            deep: true
        },
		sponsorsquery:{
            handler(sponsorsquery) {
                this.setQuery(sponsorsquery)
            },
			
            deep: true
        },
		
    },
    methods: {
        ...mapActions('EventsSinglenew', ['fetchData','fetchDataAgenda','fetchDataSponsors', 'setQuery', 'resetState', 'destroyDataSponsors','addDataSponsors'])
    }
}
</script>


<style scoped>
.tabs {
    overflow: hidden;
  margin-left: 20px;
    margin-bottom: -2px; 
}

.tabs ul {
    list-style-type: none;
    margin-left: 20px;
}

.tabs a{
    float: left;
    cursor: pointer;
    padding: 12px 24px;
    transition: background-color 0.2s;
    border: 1px solid #ccc;
    border-right: none;
    background-color: #f1f1f1;
    border-radius: 10px 10px 0 0;
    font-weight: bold;
}
.tabs a:last-child { 
    border-right: 1px solid #ccc;
}

/* Change background color of tabs on hover */
.tabs a:hover {
    background-color: #aaa;
    color: #fff;
}

/* Styling for active tab */
.tabs a.active {
    background-color: #fff;
    color: #484848;
    border-bottom: 2px solid #fff;
    cursor: default;
}

/* Style the tab content */
.tabcontent {
    padding: 30px;
    border: 1px solid #ccc;
    border-radius: 10px;
  box-shadow: 3px 3px 6px #e1e1e1
}
</style>
