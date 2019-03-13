function initialState() {
    return {
        item: {
            id: null,
            name: null,
            description: null,
            address: null,
            date_from: null,
            date_to: null,
            full_agenda: null,
            web_url: null,
            attendees: [],
            sponsors: [],
            agenda: [],
            industry: null,
        },
        usersAll: [],
        sponsorsAll: [],
        agendasAll: [],
        industriesAll: [],
       
        all: [],
         query: {},
          relationships: {
            'event': 'name',
        },
       sponsorsall: [],
         sponsorsquery: {offset:0,limit:10},
          sponsorsrelationships: {
            'event': 'name',
        },
	   
             
       
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    usersAll: state => state.usersAll,
    sponsorsAll: state => state.sponsorsAll,
    agendasAll: state => state.agendasAll,
    industriesAll: state => state.industriesAll,
    
    data: state => {
        let rows = state.all

        if (state.query.sort) {
            rows = _.orderBy(state.all, state.query.sort, state.query.order)
        }

        return rows.slice(state.query.offset, state.query.offset + state.query.limit)
    },
    total:         state => state.all.length,
 //   loading:       state => state.loading,
    relationships: state => state.relationships,
    
    
    sponsorsdata: state => {
        let rows = state.sponsorsall
console.log('row',state.sponsorsquery.offset, state.sponsorsquery.offset + state.sponsorsquery.limit)
        if (state.sponsorsquery.sort) {
            rows = _.orderBy(state.sponsorsall, state.sponsorsquery.sort, state.sponsorsquery.order)
        }

        return rows.slice(state.sponsorsquery.offset, state.sponsorsquery.offset + state.sponsorsquery.limit)
    },
    sponsorstotal:         state => state.sponsorsall.length,
 //   loading:       state => state.loading,
    sponsorsrelationships: state => state.sponsorsrelationships
    
    
    
    
    
    
}

const actions = {
	fetchDataSponsors({ commit, state }, event) {
       // commit('setLoading', true)
       if (event){
	   	
	   
		console.log('fetchsponsors')
        axios.get('/api/v1/sponsors_event/' + event)
            .then(response => {
                commit('setAllSponsors', response.data.data)
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
	 fetchDataAgenda({ commit, state }, event) {
       // commit('setLoading', true)




        axios.get('/api/v1/agendas_event/' + event)
            .then(response => {
                commit('setAll', response.data.data)
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
    },
	 destroyData({ commit, state }, id) {
        axios.delete('/api/v1/agendas/' + id)
            .then(response => {
                commit('setAll', state.all.filter((item) => {
                    return item.id != id
                }))
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
    },
    setQuery({ commit }, value) {
        commit('setQuery', purify(value))
    },
	 destroyDataSponsors({ commit, state },event) {
	 	console.log('++',event.event,event.id);
	 	if(event.event && event.id){
			
		
        axios.get('/api/v1/event_relation/' + event.event + '/sponsors/del/' + event.id)
            .then(response => {
            	console.log(event.id)
                commit('setAllSponsors', state.sponsorsall.filter((item) => {
                    return item.id != event.id
                }))
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
		}
    },
     addDataSponsors({ commit, state },event) {
	 	console.log('++',event.event,event.id);
	 	if(event.event && event.id){
			
		
        axios.get('/api/v1/event_relation/' + event.event + '/sponsors/add/' + event.id)
            .then(response => {
               dispatch('fetchDataSponsors',event.event)
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

            if (state.item.full_agenda === null) {
                params.delete('full_agenda');
            }
            if (_.isEmpty(state.item.attendees)) {
                params.delete('attendees')
            } else {
                for (let index in state.item.attendees) {
                    params.set('attendees['+index+']', state.item.attendees[index].id)
                }
            }
            if (_.isEmpty(state.item.sponsors)) {
                params.delete('sponsors')
            } else {
                for (let index in state.item.sponsors) {
                    params.set('sponsors['+index+']', state.item.sponsors[index].id)
                }
            }
            if (_.isEmpty(state.item.agenda)) {
                params.delete('agenda')
            } else {
                for (let index in state.item.agenda) {
                    params.set('agenda['+index+']', state.item.agenda[index].id)
                }
            }
            if (_.isEmpty(state.item.industry)) {
                params.set('industry_id', '')
            } else {
                params.set('industry_id', state.item.industry.id)
            }

            axios.post('/api/v1/events', params)
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

            if (state.item.full_agenda === null) {
                params.delete('full_agenda');
            }
            if (_.isEmpty(state.item.attendees)) {
                params.delete('attendees')
            } else {
                for (let index in state.item.attendees) {
                    params.set('attendees['+index+']', state.item.attendees[index].id)
                }
            }
            if (_.isEmpty(state.item.sponsors)) {
                params.delete('sponsors')
            } else {
                for (let index in state.item.sponsors) {
                    params.set('sponsors['+index+']', state.item.sponsors[index].id)
                }
            }
            if (_.isEmpty(state.item.agenda)) {
                params.delete('agenda')
            } else {
                for (let index in state.item.agenda) {
                    params.set('agenda['+index+']', state.item.agenda[index].id)
                }
            }
            if (_.isEmpty(state.item.industry)) {
                params.set('industry_id', '')
            } else {
                params.set('industry_id', state.item.industry.id)
            }

            axios.post('/api/v1/events/' + state.item.id, params)
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
        axios.get('/api/v1/events/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchUsersAll')
    dispatch('fetchSponsorsAll')
    dispatch('fetchAgendasAll')
    dispatch('fetchIndustriesAll')
    },
    fetchUsersAll({ commit }) {
        axios.get('/api/v1/users')
            .then(response => {
                commit('setUsersAll', response.data.data)
            })
    },
    fetchSponsorsAll({ commit }) {
        axios.get('/api/v1/sponsors')
            .then(response => {
                commit('setSponsorsAll', response.data.data)
            })
    },
    fetchAgendasAll({ commit }) {
      axios.get('/api/v1/agendas')
            .then(response => {
                commit('setAgendasAll', response.data.data)
            })
    },
    fetchIndustriesAll({ commit }) {
        axios.get('/api/v1/industries')
            .then(response => {
                commit('setIndustriesAll', response.data.data)
            })
    },
    setName({ commit }, value) {
        commit('setName', value)
    },
    setDescription({ commit }, value) {
        commit('setDescription', value)
    },
    setAddress({ commit }, value) {
        commit('setAddress', value)
    },
    setDate_from({ commit }, value) {
        commit('setDate_from', value)
    },
    setDate_to({ commit }, value) {
        commit('setDate_to', value)
    },
    setFull_agenda({ commit }, value) {
        commit('setFull_agenda', value)
    },
    
    setWeb_url({ commit }, value) {
        commit('setWeb_url', value)
    },
    setAttendees({ commit }, value) {
        commit('setAttendees', value)
    },
    setSponsors({ commit }, value) {
        commit('setSponsors', value)
    },
    setAgenda({ commit }, value) {
        commit('setAgenda', value)
    },
    setIndustry({ commit }, value) {
        commit('setIndustry', value)
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
    setDescription(state, value) {
        state.item.description = value
    },
    setAddress(state, value) {
        state.item.address = value
    },
    setDate_from(state, value) {
        state.item.date_from = value
    },
    setDate_to(state, value) {
        state.item.date_to = value
    },
    setFull_agenda(state, value) {
        state.item.full_agenda = value
    },
    setWeb_url(state, value) {
        state.item.web_url = value
    },
    setAttendees(state, value) {
        state.item.attendees = value
    },
    setSponsors(state, value) {
        state.item.sponsors = value
    },
    setAgenda(state, value) {
        state.item.agenda = value
    },
    setIndustry(state, value) {
        state.item.industry = value
    },
    setUsersAll(state, value) {
        state.usersAll = value
    },
    setSponsorsAll(state, value) {
        state.sponsorsAll = value
    },
    setAgendasAll(state, value) {
        state.agendasAll = value
    },
    setIndustriesAll(state, value) {
        state.industriesAll = value
    },
    
    setLoading(state, loading) {
        state.loading = loading
    },
    
     setAll(state, items) {
     	console.log('seta',items)
        state.all = items
    },
      setAllSponsors(state, items) {
      	console.log('set',items)
        state.sponsorsall = items
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
