function initialState() {
    return {
        item: {
            id: null,
            user: null,
            presentation: null,
            event: null,
            description: null,
            subject: null,
            question:null,
            time_from: null,
            time_to: null,
            day: null,
        },
        usersAll: [],
        eventsAll: [],

        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    usersAll: state => state.usersAll,
    eventsAll: state => state.eventsAll,

}

const actions = {
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

            if (_.isEmpty(state.item.user)) {
                params.set('user_id', '')
            } else {
                params.set('user_id', state.item.user.id)
            }
            if (state.item.presentation === null) {
                params.delete('presentation');
            }
            if (_.isEmpty(state.item.event)) {
                params.set('event_id', '')
            } else {
                params.set('event_id', state.item.event.id)
            }

            axios.post('/api/v1/sessions', params)
                .then(response => {
                	console.log(response)
                	let data=response.data
                    commit('resetState')
                    resolve(data)
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

            if (_.isEmpty(state.item.user)) {
                params.set('user_id', '')
            } else {
                params.set('user_id', state.item.user.id)
            }
            if (state.item.presentation === null) {
                params.delete('presentation');
            }
            if (_.isEmpty(state.item.event)) {
                params.set('event_id', '')
            } else {
                params.set('event_id', state.item.event.id)
            }

            axios.post('/api/v1/sessions/' + state.item.id, params)
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
        axios.get('/api/v1/sessions/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchUsersAll')
    dispatch('fetchEventsAll')
    },
    fetchUsersAll({ commit }) {
        axios.get('/api/v1/users')
            .then(response => {
                commit('setUsersAll', response.data.data)
            })
    },
    fetchEventsAll({ commit }) {
        axios.get('/api/v1/events')
            .then(response => {
                commit('setEventsAll', response.data.data)
            })
    },
    setUser({ commit }, value) {
        commit('setUser', value)
    },
    setPresentation({ commit }, value) {
        commit('setPresentation', value)
    },

    setEvent({ commit }, value) {
        commit('setEvent', value)
    },
    setDescription({ commit }, value) {
        commit('setDescription', value)
    },
    setSubject({ commit }, value) {
        commit('setSubject', value)
    },
    setQuestion({ commit }, value) {
        commit('setQuestion', value)
    },
    setTime_from({ commit }, value) {
        commit('setTime_from', value)
    },
    setTime_to({ commit }, value) {
        commit('setTime_to', value)
    },
    setDay({ commit }, value) {
        commit('setDay', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setUser(state, value) {
        state.item.user = value
    },
    setPresentation(state, value) {
        state.item.presentation = value
    },
    setEvent(state, value) {
        state.item.event = value
    },
    setDescription(state, value) {
        state.item.description = value
    },
    setSubject(state, value) {
        state.item.subject = value
    },
    setQuestion(state, value) {
        state.item.question = value
    },
    setTime_from(state, value) {
        state.item.time_from = value
    },
    setTime_to(state, value) {
        state.item.time_to = value
    },
    setDay(state, value) {
        state.item.day = value
    },
    setUsersAll(state, value) {
        state.usersAll = value
    },
    setEventsAll(state, value) {
        state.eventsAll = value
    },

    setLoading(state, loading) {
        state.loading = loading
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
