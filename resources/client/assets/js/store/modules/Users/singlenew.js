function initialState() {
    return {
        item: {
            id: null,
            avatar: null,
            name: null,
            description: null,
            company: null,
            job: null,
            phone: null,
            email: null,
            password: null,
            role: [],
            my_events: [],
        },
        rolesAll: [],
        eventsAll: [],
         notesall: [],
         notesquery: {offset:0,limit:10},
          notesrelationships: {
             'author': 'name',
			
			
        },
	          groupsall: [],
         groupsquery: {offset:0,limit:10},
          groupsrelationships: {
          
        },
         eventsall: [],
         eventsquery: {offset:0,limit:10},
        eventsrelationships: {
        	 'attendees': 'name',
            'sponsors': 'name',
            'agenda': 'text',
            'industry': 'name',
          
        },
        sessionsall: [],
        sessionsquery: {offset:0,limit:10},
       	sessionsrelationships: {
       		    'user': 'name',
            'event': 'name',
          
        },
        plannersall: [],
        plannersquery: {offset:0,limit:10},
       	plannersrelationships: {
       		  'users': 'name',
            'author': 'name',
          
        },
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    rolesAll: state => state.rolesAll,
    eventsAll: state => state.eventsAll,
	
     groupsdata: state => {
        let rows = state.groupsall
        if (state.groupsquery.sort) {
            rows = _.orderBy(state.groupsall, state.groupsquery.sort, state.groupsquery.order)
        }

        return rows.slice(state.groupsquery.offset, state.groupsquery.offset + state.groupsquery.limit)
    },
    groupstotal:         state => state.groupsall.length,
 //   loading:       state => state.loading,
    groupsrelationships: state => state.groupsrelationships,
    
	 sessionsdata: state => {
        let rows = state.sessionsall
        if (state.sessionsquery.sort) {
            rows = _.orderBy(state.sessionsall, state.sessionsquery.sort, state.sessionsquery.order)
        }

        return rows.slice(state.sessionsquery.offset, state.sessionsquery.offset + state.sessionsquery.limit)
    },
    sessionstotal:         state => state.sessionsall.length,
 //   loading:       state => state.loading,
    sessionsrelationships: state => state.sessionsrelationships,
	 eventsdata: state => {
        let rows = state.eventsall
        if (state.eventsquery.sort) {
            rows = _.orderBy(state.eventsall, state.eventsquery.sort, state.eventsquery.order)
        }

        return rows.slice(state.eventsquery.offset, state.eventsquery.offset + state.eventsquery.limit)
    },
    eventstotal:         state => state.eventsall.length,
 //   loading:       state => state.loading,
    eventsrelationships: state => state.eventsrelationships,
	 plannersdata: state => {
        let rows = state.plannersall
        if (state.plannersquery.sort) {
            rows = _.orderBy(state.plannersall, state.plannersquery.sort, state.plannersquery.order)
        }

        return rows.slice(state.plannersquery.offset, state.plannersquery.offset + state.plannersquery.limit)
    },
    plannerstotal:         state => state.plannersall.length,
 //   loading:       state => state.loading,
    plannersrelationships: state => state.plannersrelationships,
	
	  notesdata: state => {
        let rows = state.notesall
console.log('row',state.notesquery.offset, state.notesquery.offset + state.notesquery.limit)
        if (state.notesquery.sort) {
            rows = _.orderBy(state.notesall, state.notesquery.sort, state.notesquery.order)
        }

        return rows.slice(state.notesquery.offset, state.notesquery.offset + state.notesquery.limit)
    },
    notestotal:         state => state.notesall.length,
 //   loading:       state => state.loading,
    notesrelationships: state => state.notesrelationships
   
}

const actions = {
	fetchDataNotes({ commit, state }, user) {
       // commit('setLoading', true)
       if (user){
	   	
	   
		console.log('fetchnotes')
        axios.get('/api/v1/notes_user/' + user)
            .then(response => {
                commit('setAllNotes', response.data.data)
            })
           /*
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
            .finally(() => {
                commit('setLoading', false)
            })*/
		} 
    },
	fetchDataPlanners({ commit, state }, user) {
       // commit('setLoading', true)
       if (user){
	   	
	   
		console.log('fetchsplanners')
        axios.get('/api/v1/planners_user/' + user)
            .then(response => {
                commit('setAllPlanners', response.data.data)
            })
           /*
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
            .finally(() => {
                commit('setLoading', false)
            })*/
		} 
    },
    fetchDataEvents({ commit, state }, user) {
       // commit('setLoading', true)
       if (user){
	   	
	   
		console.log('fetchsevents')
        axios.get('/api/v1/events_user/' + user)
            .then(response => {
                commit('setAllEvents', response.data.data)
            })
           /*
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
            .finally(() => {
                commit('setLoading', false)
            })*/
		} 
    },fetchDataSessions({ commit, state }, user) {
       // commit('setLoading', true)
       if (user){
	   	
	   
		console.log('fetchsSession')
        axios.get('/api/v1/sessions_user/' + user)
            .then(response => {
                commit('setAllSessions', response.data.data)
            })
           /*
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
            .finally(() => {
                commit('setLoading', false)
            })*/
		} 
    },fetchDataGroups({ commit, state }, user) {
       // commit('setLoading', true)
       if (user){
	   	
	   
		console.log('fetchsgroups')
        axios.get('/api/v1/groups_user/' + user)
            .then(response => {
                commit('setAllGroups', response.data.data)
            })
           /*
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
            .finally(() => {
                commit('setLoading', false)
            })*/
		} 
    },
	setQuery({ commit }, value) {
        commit('setQuery', purify(value))
    },
	
	addDataNotes({ commit, state },user) {
	 	console.log('++',user.user,user.id);
	 	if(user.user && user.id){
			
		
        axios.get('/api/v1/user_relation/' + user.user + '/notes/add/' + user.id)
            .then(response => {
               dispatch('fetchDataNotes',user.user)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
	
	destroyDataNotes({ commit, state },user) {
	 	console.log('++',user.user,user.id);
	 //	if(user.user && user.id){
			
		 axios.delete('/api/v1/notes/' + user.id)
		  .then(response => {
                 commit('setAllNotes', state.notesall.filter((item) => {
                    return item.id != user.id
                }))
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		 
		 
		 
      
	//	}
    },
     addDataGroups({ commit, state },user) {
	 	console.log('++',user.user,user.id);
	 	if(user.user && user.id){
			
		
        axios.get('/api/v1/user_relation/' + user.user + '/groups/add/' + user.id)
            .then(response => {
               dispatch('fetchDataGroups',user.user)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
	destroyDataGroups({ commit, state },user) {
	 	console.log('++',user.user,user.id);
	 	if(user.user && user.id){
			
		
        axios.get('/api/v1/user_relation/' + user.user + '/groups/del/' + user.id)
            .then(response => {
            	console.log(user.id)
                commit('setAllGroups', state.groupsall.filter((item) => {
                    return item.id != user.id
                }))
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
     
	 addDataSessions({ commit, state },user) {
	 	console.log('++',user.user,user.id);
	 	if(user.user && user.id){
			
		
        axios.get('/api/v1/user_relation/' + user.user + '/sessions/add/' + user.id)
            .then(response => {
               dispatch('fetchDataSessions',user.user)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
	destroyDataSessions({ commit, state },user) {
	 	console.log('++',user.user,user.id);
	 	if(user.user && user.id){
			
		
        axios.get('/api/v1/user_relation/' + user.user + '/sessions/del/' + user.id)
            .then(response => {
            	console.log(user.id)
                commit('setAllSessions', state.sessionsall.filter((item) => {
                    return item.id != user.id
                }))
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
     addDataEvents({ commit, state },user) {
	 	console.log('++',user.user,user.id);
	 	if(user.user && user.id){
			
		
        axios.get('/api/v1/user_relation/' + user.user + '/events/add/' + user.id)
            .then(response => {
               dispatch('fetchDataEvents',user.user)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
	destroyDataEvents({ commit, state },user) {
	 	console.log('++',user.user,user.id);
	 	if(user.user && user.id){
			
		
        axios.get('/api/v1/user_relation/' + user.user + '/events/del/' + user.id)
            .then(response => {
            	console.log(user.id)
                commit('setAllEvents', state.eventsall.filter((item) => {
                    return item.id != user.id
                }))
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
     addDataPlanners({ commit, state },user) {
	 	console.log('++',user.user,user.id);
	 	if(user.user && user.id){
			
		
        axios.get('/api/v1/user_relation/' + user.user + '/planners/add/' + user.id)
            .then(response => {
               dispatch('fetchDataPlanners',user.user)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
	destroyDataPlanners({ commit, state },user) {
	 	console.log('++',user.user,user.id);
	 	if(user.user && user.id){
			
		
        axios.get('/api/v1/user_relation/' + user.user + '/planners/del/' + user.id)
            .then(response => {
            	console.log(user.id)
                commit('setAllPlanners', state.plannersall.filter((item) => {
                    return item.id != user.id
                }))
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
	
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }

            if (state.item.avatar === null) {
                params.delete('avatar');
            }
            if (_.isEmpty(state.item.role)) {
                params.delete('role')
            } else {
                for (let index in state.item.role) {
                    params.set('role['+index+']', state.item.role[index].id)
                }
            }
            if (_.isEmpty(state.item.my_events)) {
                params.delete('my_events')
            } else {
                for (let index in state.item.my_events) {
                    params.set('my_events['+index+']', state.item.my_events[index].id)
                }
            }

            axios.post('/api/v1/users', params)
                .then(response => {
                    commit('resetState')
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors  = error.response.data.errors

                    dispatch(
                        'Alert/setAlert',
                        { message: message, errors: errors, color: 'danger' },
                        { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        })
    },
    updateData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set('_method', 'PUT')

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }

            if (state.item.avatar === null) {
                params.delete('avatar');
            }
            if (_.isEmpty(state.item.role)) {
                params.delete('role')
            } else {
                for (let index in state.item.role) {
                    params.set('role['+index+']', state.item.role[index].id)
                }
            }
            if (_.isEmpty(state.item.my_events)) {
                params.delete('my_events')
            } else {
                for (let index in state.item.my_events) {
                    params.set('my_events['+index+']', state.item.my_events[index].id)
                }
            }

            axios.post('/api/v1/users/' + state.item.id, params)
                .then(response => {
                    commit('setItem', response.data.data)
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors  = error.response.data.errors

                    dispatch(
                        'Alert/setAlert',
                        { message: message, errors: errors, color: 'danger' },
                        { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        })
    },
    fetchData({ commit, dispatch }, id) {
        axios.get('/api/v1/users/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchRolesAll')
    dispatch('fetchEventsAll')
    },
    fetchRolesAll({ commit }) {
        axios.get('/api/v1/roles')
            .then(response => {
                commit('setRolesAll', response.data.data)
            })
    },
    fetchEventsAll({ commit }) {
        axios.get('/api/v1/events')
            .then(response => {
                commit('setEventsAll', response.data.data)
            })
    },
    setAvatar({ commit }, value) {
        commit('setAvatar', value)
    },
    
    setName({ commit }, value) {
        commit('setName', value)
    },
    setDescription({ commit }, value) {
        commit('setDescription', value)
    },
    setCompany({ commit }, value) {
        commit('setCompany', value)
    },
    setJob({ commit }, value) {
        commit('setJob', value)
    },
    setPhone({ commit }, value) {
        commit('setPhone', value)
    },
    setEmail({ commit }, value) {
        commit('setEmail', value)
    },
    setPassword({ commit }, value) {
        commit('setPassword', value)
    },
    setRole({ commit }, value) {
        commit('setRole', value)
    },
    setMy_events({ commit }, value) {
        commit('setMy_events', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setAvatar(state, value) {
        state.item.avatar = value
    },
    setName(state, value) {
        state.item.name = value
    },
    setDescription(state, value) {
        state.item.description = value
    },
    setCompany(state, value) {
        state.item.company = value
    },
    setJob(state, value) {
        state.item.job = value
    },
    setPhone(state, value) {
        state.item.phone = value
    },
    setEmail(state, value) {
        state.item.email = value
    },
    setPassword(state, value) {
        state.item.password = value
    },
    setRole(state, value) {
        state.item.role = value
    },
    setMy_events(state, value) {
        state.item.my_events = value
    },
    setRolesAll(state, value) {
        state.rolesAll = value
    },
    setEventsAll(state, value) {
        state.eventsAll = value
    },
    
    setLoading(state, loading) {
        state.loading = loading
    },
	
	      setAllNotes(state, items) {
      	console.log('set',items)
        state.notesall = items
    },
	     setAllGroups(state, items) {
      	console.log('set',items)
        state.groupsall = items
    },
        setAllPlanners(state, items) {
      	console.log('set',items)
        state.plannersall = items
    },
        setAllEvents(state, items) {
      	console.log('set',items)
        state.eventsall = items
    },
        setAllSessions(state, items) {
      	console.log('set',items)
        state.sessionsall = items
    },
      setQuery(state, query) {
        state.query = query
    },
	
	
	
	
    resetState(state) {
        state = Object.assign(state, initialState())
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
