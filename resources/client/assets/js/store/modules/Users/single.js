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
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    rolesAll: state => state.rolesAll,
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
