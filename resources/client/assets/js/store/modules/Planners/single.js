function initialState() {
    return {
        item: {
            id: null,
            time: null,
            users: [],
            body: null,
            done: false,
            author: null,
        },
        usersAll: [],
        usersAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    usersAll: state => state.usersAll,
    usersAll: state => state.usersAll,
    
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

            if (_.isEmpty(state.item.users)) {
                params.delete('users')
            } else {
                for (let index in state.item.users) {
                    params.set('users['+index+']', state.item.users[index].id)
                }
            }
            params.set('done', state.item.done ? 1 : 0)
            if (_.isEmpty(state.item.author)) {
                params.set('author_id', '')
            } else {
                params.set('author_id', state.item.author.id)
            }

            axios.post('/api/v1/planners', params)
                .then(response => {
                    commit('resetState')
                      console.log('response',response)
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

            if (_.isEmpty(state.item.users)) {
                params.delete('users')
            } else {
                for (let index in state.item.users) {
                    params.set('users['+index+']', state.item.users[index].id)
                }
            }
            params.set('done', state.item.done ? 1 : 0)
            if (_.isEmpty(state.item.author)) {
                params.set('author_id', '')
            } else {
                params.set('author_id', state.item.author.id)
            }

            axios.post('/api/v1/planners/' + state.item.id, params)
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
        axios.get('/api/v1/planners/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchUsersAll')
    dispatch('fetchUsersAll')
    },
    fetchUsersAll({ commit }) {
        axios.get('/api/v1/users')
            .then(response => {
                commit('setUsersAll', response.data.data)
            })
    },
    fetchUsersAll({ commit }) {
        axios.get('/api/v1/users')
            .then(response => {
                commit('setUsersAll', response.data.data)
            })
    },
    setTime({ commit }, value) {
        commit('setTime', value)
    },
    setUsers({ commit }, value) {
        commit('setUsers', value)
    },
    setBody({ commit }, value) {
        commit('setBody', value)
    },
    setDone({ commit }, value) {
        commit('setDone', value)
    },
    setAuthor({ commit }, value) {
        commit('setAuthor', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setTime(state, value) {
        state.item.time = value
    },
    setUsers(state, value) {
        state.item.users = value
    },
    setBody(state, value) {
        state.item.body = value
    },
    setDone(state, value) {
        state.item.done = value
    },
    setAuthor(state, value) {
        state.item.author = value
    },
    setUsersAll(state, value) {
        state.usersAll = value
    },
    setUsersAll(state, value) {
        state.usersAll = value
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
