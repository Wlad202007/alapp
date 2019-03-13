function initialState() {
    return {
        item: {
            id: null,
            body: null,
            attachments: [],
            uploaded_attachments: [],
            users: [],
            author: null,
            group: null,
            read: false,
        },
        usersAll: [],
        usersAll: [],
        eventsAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    usersAll: state => state.usersAll,
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

            params.set('uploaded_attachments', state.item.uploaded_attachments.map(o => o['id']))
            if (_.isEmpty(state.item.users)) {
                params.delete('users')
            } else {
                for (let index in state.item.users) {
                    params.set('users['+index+']', state.item.users[index].id)
                }
            }
            if (_.isEmpty(state.item.author)) {
                params.set('author_id', '')
            } else {
                params.set('author_id', state.item.author.id)
            }
            if (_.isEmpty(state.item.group)) {
                params.set('group_id', '')
            } else {
                params.set('group_id', state.item.group.id)
            }
            params.set('read', state.item.read ? 1 : 0)

            axios.post('/api/v1/messages', params)
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

            params.set('uploaded_attachments', state.item.uploaded_attachments.map(o => o['id']))
            if (_.isEmpty(state.item.users)) {
                params.delete('users')
            } else {
                for (let index in state.item.users) {
                    params.set('users['+index+']', state.item.users[index].id)
                }
            }
            if (_.isEmpty(state.item.author)) {
                params.set('author_id', '')
            } else {
                params.set('author_id', state.item.author.id)
            }
            if (_.isEmpty(state.item.group)) {
                params.set('group_id', '')
            } else {
                params.set('group_id', state.item.group.id)
            }
            params.set('read', state.item.read ? 1 : 0)

            axios.post('/api/v1/messages/' + state.item.id, params)
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
        axios.get('/api/v1/messages/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchUsersAll')
    dispatch('fetchUsersAll')
    dispatch('fetchEventsAll')
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
    fetchEventsAll({ commit }) {
        axios.get('/api/v1/events')
            .then(response => {
                commit('setEventsAll', response.data.data)
            })
    },
    setBody({ commit }, value) {
        commit('setBody', value)
    },
    setAttachments({ commit }, value) {
        commit('setAttachments', value)
    },
    destroyAttachments({ commit }, value) {
        commit('destroyAttachments', value)
    },
    destroyUploadedAttachments({ commit }, value) {
        commit('destroyUploadedAttachments', value)
    },
    setUsers({ commit }, value) {
        commit('setUsers', value)
    },
    setAuthor({ commit }, value) {
        commit('setAuthor', value)
    },
    setGroup({ commit }, value) {
        commit('setGroup', value)
    },
    setRead({ commit }, value) {
        commit('setRead', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setBody(state, value) {
        state.item.body = value
    },
    setAttachments(state, value) {
        for (let i in value) {
            let attachments = value[i];
            if (typeof attachments === "object") {
                state.item.attachments.push(attachments);
            }
        }
    },
    destroyAttachments(state, value) {
        for (let i in state.item.attachments) {
            if (i == value) {
                state.item.attachments.splice(i, 1);
            }
        }
    },
    destroyUploadedAttachments(state, value) {
        for (let i in state.item.uploaded_attachments) {
            let data = state.item.uploaded_attachments[i];
            if (data.id === value) {
                state.item.uploaded_attachments.splice(i, 1);
            }
        }
    },
    setUsers(state, value) {
        state.item.users = value
    },
    setAuthor(state, value) {
        state.item.author = value
    },
    setGroup(state, value) {
        state.item.group = value
    },
    setRead(state, value) {
        state.item.read = value
    },
    setUsersAll(state, value) {
        state.usersAll = value
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
