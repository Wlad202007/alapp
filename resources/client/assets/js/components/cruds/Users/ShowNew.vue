<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Users</h1>
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
                                            <th>Avatar</th>
                                            <td v-html="item.avatar_link"></td>
                                            </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ item.name }}</td>
                                            </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td>{{ item.description }}</td>
                                            </tr>
                                        <tr>
                                            <th>Company</th>
                                            <td>{{ item.company }}</td>
                                            </tr>
                                        <tr>
                                            <th>Job</th>
                                            <td>{{ item.job }}</td>
                                            </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ item.phone }}</td>
                                            </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ item.email }}</td>
                                            </tr>
                                        <tr>
                                            <th>Role</th>
                                            <td>
                                                <span class="label label-info" v-for="role in item.role">
                                                    {{ role.title }}
                                                </span>
                                            </td>
                                        </tr>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							<div class="row">
							<div id="tabs" >
  
								<div class="tabs">
									<a v-on:click="activetab=1" v-bind:class="[ activetab === 1 ? 'active' : '' ]">Notes</a>
									<a v-on:click="activetab=2" v-bind:class="[ activetab === 2 ? 'active' : '' ]">Groups</a>
									<a v-on:click="activetab=3" v-bind:class="[ activetab === 3 ? 'active' : '' ]">My Events</a>
									<a v-on:click="activetab=4" v-bind:class="[ activetab === 4 ? 'active' : '' ]">Sessions</a>
									<a v-on:click="activetab=5" v-bind:class="[ activetab === 5 ? 'active' : '' ]">Planners</a>
									
								</div>

								<div class="content">
									<div v-show="activetab === 1" class="tabcontent">
										<div class="box-body">
										<div class="btn-group">
											<router-link
												v-if="$can(notes.xprops.permission_prefix + 'create')"
												:to="{ name: notes.xprops.route + '.create',params:{user:notes.xprops.params,module:notes.xprops.module} }"
												class="btn btn-success btn-sm"
											>
												<i class="fa fa-plus"></i> Add new
											</router-link>

											<button type="button" class="btn btn-default btn-sm" @click="fetchDataUsers(notes.xprops.params)">
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
												:columns = "notes.columns"
												:data	= "notesdata"
												:total	= "notestotal"
												:query	= "notesquery"
												:xprops	= "notes.xprops"
											/>
										</div>
									</div>
									<div v-show="activetab === 2" class="tabcontent">
										<div class="box-body">
										<div class="btn-group">
											<router-link
												v-if="$can(groups.xprops.permission_prefix + 'create')"
												:to="{ name: groups.xprops.route + '.create',params:{user:groups.xprops.params,module:groups.xprops.module} }"
												class="btn btn-success btn-sm"
											>
												<i class="fa fa-plus"></i> Add new
											</router-link>

											<button type="button" class="btn btn-default btn-sm" @click="fetchDataGroups(groups.xprops.params)">
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
												:columns = "groups.columns"
												:data	= "groupsdata"
												:total	= "groupstotal"
												:query	= "groupsquery"
												:xprops	= "groups.xprops"
											/>
										</div>
									</div>
									
										<div v-show="activetab === 3" class="tabcontent">
										<div class="box-body">
										<div class="btn-group">
											<router-link
												v-if="$can(events.xprops.permission_prefix + 'create')"
												:to="{ name: events.xprops.route + '.create',params:{user:events.xprops.params,module:events.xprops.module} }"
												class="btn btn-success btn-sm"
											>
												<i class="fa fa-plus"></i> Add new
											</router-link>

											<button type="button" class="btn btn-default btn-sm" @click="fetchDataEvents(events.xprops.params)">
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
												:columns = "events.columns"
												:data	= "eventsdata"
												:total	= "eventstotal"
												:query	= "eventsquery"
												:xprops	= "events.xprops"
											/>
										</div>
									</div>
									<div v-show="activetab === 4" class="tabcontent">
										<div class="box-body">
										<div class="btn-group">
											<router-link
												v-if="$can(sessions.xprops.permission_prefix + 'create')"
												:to="{ name: sessions.xprops.route + '.create',params:{user:sessions.xprops.params,module:sessions.xprops.module} }"
												class="btn btn-success btn-sm"
											>
												<i class="fa fa-plus"></i> Add new
											</router-link>

											<button type="button" class="btn btn-default btn-sm" @click="fetchDataSessions(sessions.xprops.params)">
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
												:columns = "sessions.columns"
												:data	= "sessionsdata"
												:total	= "sessionstotal"
												:query	= "sessionsquery"
												:xprops	= "sessions.xprops"
											/>
										</div>
									</div>
									<div v-show="activetab === 5" class="tabcontent">
										<div class="box-body">
										<div class="btn-group">
											<router-link
												v-if="$can(planners.xprops.permission_prefix + 'create')"
												:to="{ name: planners.xprops.route + '.create',params:{user:sessions.xprops.params,module:planners.xprops.module} }"
												class="btn btn-success btn-sm"
											>
												<i class="fa fa-plus"></i> Add new
											</router-link>

											<button type="button" class="btn btn-default btn-sm" @click="fetchDataPlanners(planners.xprops.params)">
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
												:columns = "planners.columns"
												:data	= "plannersdata"
												:total	= "plannerstotal"
												:query	= "plannersquery"
												:xprops	= "planners.xprops"
											/>
										</div>
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
	import DatatableActionsGroups from '../Groups/dtmodules/DatatableActionsGroups'
	import DatatableActionsNotes from '../Notes/dtmodules/DatatableActionsNotes'
	import DatatableActionsEvents from '../Events/dtmodules/DatatableActionsEvents'
	import DatatableActionsSessions from '../Sessions/dtmodules/DatatableActionsSessions'
	import DatatableActionsPlanners from '../Planners/dtmodules/DatatableActionsPlanners'
    import DatatableSingle from '../../dtmodules/DatatableSingle'
    import DatatableList from '../../dtmodules/DatatableList'
    import DatatableCheckbox from '../../dtmodules/DatatableCheckbox'
	import DatatableSingleNotes from '../Notes/dtmodules/DatatableSingle'
	import DatatableSinglePlanners from '../Planners/dtmodules/DatatableSingle'
    import DatatableListPlanners from '../Planners/dtmodules/DatatableList'
	import DatatableSingleSessions from '../Sessions/dtmodules/DatatableSingle'
	import DatatableSingleEvents from '../Events/dtmodules/DatatableSingle'
	    import DatatableListEvents from '../Events/dtmodules/DatatableList'
export default {
    data() {
        return {
            groups:{
					 columns: [
                    { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
					{ title: 'Name', field: 'name', sortable: true },
                    { title: 'Status', field: 'status', tdComp: DatatableCheckbox, colStyle: 'width: 50px;' },
					{ title: 'Actions', tdComp: DatatableActionsGroups, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
                ],
                query: { sort: 'id', order: 'desc' },
                xprops: {
                    module: 'UsersSinglenew',
                    route: 'groups.user',
                    permission_prefix: 'group_',
					params:'',
					
                }
					
				},
				groupsquery: { sort: 'id', order: 'asc' ,offset:0,limit:10},
				eventsquery: { sort: 'id', order: 'asc' ,offset:0,limit:10},
				 events:{
					 columns: [
                    { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
					{ title: 'Name', field: 'name', sortable: true },
                
                { title: 'Date from', field: 'date_from', sortable: true },
                { title: 'Date to', field: 'date_to', sortable: true },
//{ title: 'Full agenda', tdComp: DatatableFullAgendaField, sortable: false },
                { title: 'Web url', field: 'web_url', sortable: true },
                { title: 'Attendees', field: 'attendees', tdComp: DatatableListEvents },
                { title: 'Sponsors', field: 'sponsors', tdComp: DatatableListEvents },
                { title: 'Agenda', field: 'agenda', tdComp: DatatableListEvents },
                { title: 'Industry', field: 'industry', tdComp: DatatableSingleEvents },
          				{ title: 'Actions', tdComp: DatatableActionsEvents, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
                ],
                query: { sort: 'id', order: 'desc' },
                xprops: {
                    module: 'UsersSinglenew',
                    route: 'events.user',
                    permission_prefix: 'event_',
					params:'',
					
                }
					
				},
				plannersquery: { sort: 'id', order: 'asc' ,offset:0,limit:10},
				 planners:{
					 columns: [
                    { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
				 { title: 'Time', field: 'time', sortable: true },
                { title: 'Users', field: 'users', tdComp: DatatableListPlanners },
                { title: 'Body', field: 'body', sortable: true },
                { title: 'Done', field: 'done', tdComp: DatatableCheckbox, colStyle: 'width: 50px;' },
                { title: 'Author', field: 'author', tdComp: DatatableSinglePlanners },
             
            { title: 'Actions', tdComp: DatatableActionsPlanners, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
                ],
                query: { sort: 'id', order: 'desc' },
                xprops: {
                    module: 'UsersSinglenew',
                    route: 'planners.user',
                    permission_prefix: 'planner_',
					params:'',
					
                }
					
				},
				sessionsquery: { sort: 'id', order: 'asc' ,offset:0,limit:10},
				 sessions:{
					 columns: [
                    { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
					 { title: 'User', field: 'user', tdComp: DatatableSingleSessions },
               // { title: 'Presentation', tdComp: DatatablePresentationField, sortable: false },
                { title: 'Event', field: 'event', tdComp: DatatableSingleSessions },
                { title: 'Description', field: 'description', sortable: true },
                { title: 'Subject', field: 'subject', sortable: true },
                { title: 'Time from', field: 'time_from', sortable: true },
                { title: 'Time to', field: 'time_to', sortable: true },
	 { title: 'Question', field: 'question', sortable: true },
				{ title: 'Actions', tdComp: DatatableActionsSessions, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
                ],
                query: { sort: 'id', order: 'desc' },
                xprops: {
                    module: 'UsersSinglenew',
                    route: 'sessions.user',
                    permission_prefix: 'session_',
					params:'',
					
                }
					
				},
				sessionsquery: { sort: 'id', order: 'asc' ,offset:0,limit:10},
				
				notes:{
					columns: [
                { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
                   { title: 'Author', field: 'author', tdComp: DatatableSingleNotes },
                { title: 'Text', field: 'text', sortable: true },
				{ title: 'Actions', tdComp: DatatableActionsNotes, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
            ],
            query: { sort: 'id', order: 'desc' },
            xprops: {
                module: 'UsersSinglenew',
                route: 'notes.user',
                permission_prefix: 'note_',
				params:''
            }
				},
				notesquery: { sort: 'id', order: 'asc' ,offset:0,limit:10},
				activetab: 1 ,
					
        }
    },
    created() {
        this.fetchData(this.$route.params.id)
		
		this.fetchDataGroups(this.$route.params.id)
		this.fetchDataNotes(this.$route.params.id)
		this.fetchDataEvents(this.$route.params.id)
		this.fetchDataSessions(this.$route.params.id)
		this.fetchDataPlanners(this.$route.params.id)
		this.notes.xprops.params = this.$route.params.id
		this.planners.xprops.params = this.$route.params.id
		this.sessions.xprops.params = this.$route.params.id
		this.events.xprops.params = this.$route.params.id
		this.groups.xprops.params = this.$route.params.id
		
		this.$root.notesrelationships = this.notesrelationships
		this.$root.groupsrelationships = this.groupsrelationships
		this.$root.sessionsrelationships = this.sessionsrelationships
		this.$root.plannersrelationships = this.plannersrelationships
		this.$root.eventsrelationships = this.eventsrelationships
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('UsersSinglenew', ['item','groupsdata', 'notesdata','groupstotal','notestotal', 'eventsdata', 'plannersdata', 'sessionsdata','eventstotal','sessionstotal','plannerstotal', 'loading', 'notesrelationships','groupsrelationships','eventsrelationships','plannersrelationships','sessionsrelationships'])
    },
    watch: {
        "$route.params.id": function() {
			this.resetState()
			this.notes.xprops.params = this.$route.params.id
			this.groups.xprops.params = this.$route.params.id
            this.planners.xprops.params = this.$route.params.id
			this.sessions.xprops.params = this.$route.params.id
			this.events.xprops.params = this.$route.params.id
		
			this.fetchData(this.$route.params.id)
			this.fetchDataGroups(this.$route.params.id)
			this.fetchDataNotes(this.$route.params.id)
			this.fetchDataEvents(this.$route.params.id)
			this.fetchDataSessions(this.$route.params.id)
			this.fetchDataPlanners(this.$route.params.id)
        
        },
	query: {
            handler(query) {
                this.setQuery(query)
            },
			
            deep: true
        },
		groupsquery:{
            handler(groupsquery) {
                this.setQuery(groupsquery)
            },
			
            deep: true
        },
		notesquery:{
            handler(notesquery) {
                this.setQuery(notesquery)
            },
			   deep: true
        },
		
			eventsquery:{
            handler(eventsquery) {
                this.setQuery(eventsquery)
            },
			   deep: true
        },
		
			sessionsquery:{
            handler(sessionsquery) {
                this.setQuery(sessionsquery)
            },
			   deep: true
        },
		
			plannersquery:{
            handler(plannersquery) {
                this.setQuery(plannersquery)
            },
			
            deep: true
        },
		
    },
    methods: {
        ...mapActions('UsersSinglenew', ['fetchData', 'resetState','fetchDataNotes','fetchDataGroups','destroyDataGroups','addDataGroups', 'destroyDataNotes','addDataNotes','fetchDataSessions','fetchDataEvents','fetchDataPlanners', 'destroyDataPlanners','addDataPlanners','destroyDataSessions','addDataSessions',  'destroyDataEvents','addDataEvents'])
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
