<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Groups</h1>
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
                                            <th>Status</th>
                                            <td>{{ item.status }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							<div class="row">
							<div id="tabs" >
  
								<div class="tabs">
									<a v-on:click="activetab=1" v-bind:class="[ activetab === 1 ? 'active' : '' ]">Users</a>
									<a v-on:click="activetab=2" v-bind:class="[ activetab === 2 ? 'active' : '' ]">Posts</a>
								</div>

								<div class="content">
									<div v-show="activetab === 1" class="tabcontent">
										<div class="box-body">
										<div class="btn-group">
											<router-link
												v-if="$can(users.xprops.permission_prefix + 'create')"
												:to="{ name: users.xprops.route + '.create',params:{group:users.xprops.params,module:users.xprops.module} }"
												class="btn btn-success btn-sm"
											>
												<i class="fa fa-plus"></i> Add new
											</router-link>

											<button type="button" class="btn btn-default btn-sm" @click="fetchDataUsers(users.xprops.params)">
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
												:columns = "users.columns"
												:data	= "usersdata"
												:total	= "userstotal"
												:query	= "usersquery"
												:xprops	= "users.xprops"
											/>
										</div>
									</div>
									<div v-show="activetab === 2" class="tabcontent">
										<div class="box-body">
										<div class="btn-group">
											<router-link
												v-if="$can(posts.xprops.permission_prefix + 'create')"
												:to="{ name: posts.xprops.route + '.create',params:{group:posts.xprops.params,module:posts.xprops.module} }"
												class="btn btn-success btn-sm"
											>
												<i class="fa fa-plus"></i> Add new
											</router-link>

											<button type="button" class="btn btn-default btn-sm" @click="fetchDataPosts(posts.xprops.params)">
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
												:columns = "posts.columns"
												:data	= "postsdata"
												:total	= "poststotal"
												:query	= "postsquery"
												:xprops	= "posts.xprops"
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
	import DatatableActionsPosts from '../Posts/dtmodules/DatatableActionsPosts'
	import DatatableActionsUsers from '../Users/dtmodules/DatatableActionsUsers'
    import DatatableSingle from '../../dtmodules/DatatableSingle'
    import DatatableList from '../../dtmodules/DatatableList'
    import DatatableCheckbox from '../../dtmodules/DatatableCheckbox'
	import DatatableSinglePosts from '../Posts/dtmodules/DatatableSingle'
	import DatatableListUsers from '../Users/dtmodules/DatatableList'
	
    export default {
        data() {
            return {
                // Code...
				posts:{
					 columns: [
                    { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
         //           { title: 'Group', field: 'group', tdComp: DatatableSinglePosts },
                    { title: 'Author', field: 'author', tdComp: DatatableSinglePosts },
                    { title: 'Body', field: 'body', sortable: true },
//{ title: 'Gallery', tdComp: DatatableGalleryField, sortable: false },
      //???????              { title: 'Parent', field: 'parent', tdComp: DatatableSinglePosts },
                    { title: 'Actions', tdComp: DatatableActionsPosts, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
                ],
                query: { sort: 'id', order: 'desc' },
                xprops: {
                    module: 'GroupSinglenew',
                    route: 'posts.group',
                    permission_prefix: 'post_',
					params:'',
					
                }
					
				},
				postsquery: { sort: 'id', order: 'asc' ,offset:0,limit:10},
				users:{
					columns: [
                { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
              //  { title: 'Avatar', tdComp: DatatableAvatarField, sortable: false },
                { title: 'Name', field: 'name', sortable: true },
             //   { title: 'Description', field: 'description', sortable: true },
                { title: 'Company', field: 'company', sortable: true },
                { title: 'Job', field: 'job', sortable: true },
                { title: 'Phone', field: 'phone', sortable: true },
                { title: 'Email', field: 'email', sortable: true },
                { title: 'Role', field: 'role', tdComp: DatatableListUsers },
           //     { title: 'My events', field: 'my_events', tdComp: DatatableList },
                { title: 'Actions', tdComp: DatatableActionsUsers, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
            ],
            query: { sort: 'id', order: 'desc' },
            xprops: {
                module: 'GroupSinglenew',
                route: 'users.group',
                permission_prefix: 'user_',
				params:''
            }
				},
				usersquery: { sort: 'id', order: 'asc' ,offset:0,limit:10},
				activetab: 1 ,
						
            }
			
        },
        created() {
            this.fetchData(this.$route.params.id)
			this.fetchDataPosts(this.$route.params.id)
			this.fetchDataUsers(this.$route.params.id)
			this.users.xprops.params = this.$route.params.id
			this.posts.xprops.params = this.$route.params.id
			 this.$root.usersrelationships = this.usersrelationships
			  this.$root.postsrelationships = this.postsrelationships
        },
        destroyed() {
            this.resetState()
        },
        computed: {
            ...mapGetters('GroupsSinglenew', ['item','postsdata', 'usersdata','poststotal','userstotal', 'loading', 'usersrelationships','postsrelationships'])
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
			this.users.xprops.params = this.$route.params.id
			this.posts.xprops.params = this.$route.params.id
            this.fetchData(this.$route.params.id)
			this.fetchDataPosts(this.$route.params.id)
			this.fetchDataUsers(this.$route.params.id)
        
    },
	query: {
            handler(query) {
                this.setQuery(query)
            },
			
            deep: true
        },
		postsquery:{
            handler(postsquery) {
                this.setQuery(postsquery)
            },
			
            deep: true
        },
		usersquery:{
            handler(usersquery) {
                this.setQuery(usersquery)
            },
			
            deep: true
        },
		
	},
    methods: {
    ...mapActions('GroupsSinglenew', ['fetchData', 'resetState','fetchDataUsers','fetchDataPosts', 'destroyDataPosts','addDataPosts', 'destroyDataUsers','addDataUsers'])
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