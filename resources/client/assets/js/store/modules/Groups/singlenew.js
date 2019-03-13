function initialState() {
    return {
        item: {
            id: null,
            name: null,
            status: true,
        },
       usersall: [],
         usersquery: {offset:0,limit:10},
          usersrelationships: {
            'group': 'name',
			 'role': 'title',
            'my_events': 'name',
			
        },
	          postsall: [],
         postsquery: {offset:0,limit:10},
          postsrelationships: {
            'group': 'name',
            'author': 'name',
            'parent': 'body',
        },
	   

        loading: false,
    }
}

const getters = {
            item: state => state.item,
    loading: state => state.loading,
  //  postsAll: state => state.postsAll,
//	    usersAll: state => state.usersAll,
  postsdata: state => {
        let rows = state.postsall
console.log('row',state.postsquery.offset, state.postsquery.offset + state.postsquery.limit)
        if (state.postsquery.sort) {
            rows = _.orderBy(state.postsall, state.postsquery.sort, state.postsquery.order)
        }

        return rows.slice(state.postsquery.offset, state.postsquery.offset + state.postsquery.limit)
    },
    poststotal:         state => state.postsall.length,
 //   loading:       state => state.loading,
    postsrelationships: state => state.postsrelationships,
	  usersdata: state => {
        let rows = state.usersall
console.log('row',state.usersquery.offset, state.usersquery.offset + state.usersquery.limit)
        if (state.usersquery.sort) {
            rows = _.orderBy(state.usersall, state.usersquery.sort, state.usersquery.order)
        }

        return rows.slice(state.usersquery.offset, state.usersquery.offset + state.usersquery.limit)
    },
    userstotal:         state => state.usersall.length,
 //   loading:       state => state.loading,
    usersrelationships: state => state.usersrelationships
    
    
}

const actions = {
	fetchDataUsers({ commit, state }, group) {
       // commit('setLoading', true)
       if (group){
	   	
	   
		console.log('fetchusers')
        axios.get('/api/v1/users_group/' + group)
            .then(response => {
                commit('setAllUsers', response.data.data)
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
	fetchDataPosts({ commit, state }, group) {
       // commit('setLoading', true)
       if (group){
	   	
	   
		console.log('fetchsposts')
        axios.get('/api/v1/posts_group/' + group)
            .then(response => {
                commit('setAllPosts', response.data.data)
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
	addDataUsers({ commit, state },group) {
	 	console.log('++',group.group,group.id);
	 	if(group.group && group.id){
			
		
        axios.get('/api/v1/group_relation/' + group.group + '/users/add/' + group.id)
            .then(response => {
               dispatch('fetchDataUsers',group.group)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
	destroyDataUsers({ commit, state },group) {
	 	console.log('++',group.group,group.id);
	 	if(group.group && group.id){
			
		
        axios.get('/api/v1/group_relation/' + group.group + '/users/del/' + group.id)
            .then(response => {
            	console.log(group.id)
                commit('setAllUsers', state.usersall.filter((item) => {
                    return item.id != group.id
                }))
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
     addDataPosts({ commit, state },group) {
	 	console.log('++',group.group,group.id);
	 	if(group.group && group.id){
			
		
        axios.get('/api/v1/group_relation/' + group.group + '/posts/add/' + group.id)
            .then(response => {
               dispatch('fetchDataPosts',group.group)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
	destroyDataPosts({ commit, state },group) {
	 	console.log('++',group.group,group.id);
	 	if(group.group && group.id){
			
		
        axios.get('/api/v1/group_relation/' + group.group + '/posts/del/' + group.id)
            .then(response => {
            	console.log(group.id)
                commit('setAllPosts', state.usersall.filter((item) => {
                    return item.id != group.id
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

        params.set('status', state.item.status ? 1 : 0)

        axios.post('/api/v1/groups', params)
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

        params.set('status', state.item.status ? 1 : 0)

        axios.post('/api/v1/groups/' + state.item.id, params)
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
        axios.get('/api/v1/groups/' + id)
            .then(response => {
            commit('setItem', response.data.data)
    })


    },

    setName({ commit }, value) {
        commit('setName', value)
    },
    setStatus({ commit }, value) {
        commit('setStatus', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setName(state, value) {
        state.item.name = value
    },
    setStatus(state, value) {
        state.item.status = value
    },


    setLoading(state, loading) {
        state.loading = loading
    },
	      setAllUsers(state, items) {
      	console.log('set',items)
        state.usersall = items
    },
	     setAllPosts(state, items) {
      	console.log('set',items)
        state.postsall = items
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