function initialState() {
    return {
        item: {
            id: null,
            text: null,
            post: null,
            author: null,
        },
        postsAll: [],
        usersAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    postsAll: state => state.postsAll,
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

            if (_.isEmpty(state.item.post)) {
                params.set('post_id', '')
            } else {
                params.set('post_id', state.item.post.id)
            }
            if (_.isEmpty(state.item.author)) {
                params.set('author_id', '')
            } else {
                params.set('author_id', state.item.author.id)
            }

            axios.post('/api/v1/comments', params)
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

            if (_.isEmpty(state.item.post)) {
                params.set('post_id', '')
            } else {
                params.set('post_id', state.item.post.id)
            }
            if (_.isEmpty(state.item.author)) {
                params.set('author_id', '')
            } else {
                params.set('author_id', state.item.author.id)
            }

            axios.post('/api/v1/comments/' + state.item.id, params)
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
        axios.get('/api/v1/comments/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchPostsAll')
    dispatch('fetchUsersAll')
    },
    fetchPostsAll({ commit }) {
        axios.get('/api/v1/posts')
            .then(response => {
                commit('setPostsAll', response.data.data)
            })
    },
    fetchUsersAll({ commit }) {
        axios.get('/api/v1/users')
            .then(response => {
                commit('setUsersAll', response.data.data)
            })
    },
    setText({ commit }, value) {
        commit('setText', value)
    },
    setPost({ commit }, value) {
        commit('setPost', value)
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
    setText(state, value) {
        state.item.text = value
    },
    setPost(state, value) {
        state.item.post = value
    },
    setAuthor(state, value) {
        state.item.author = value
    },
    setPostsAll(state, value) {
        state.postsAll = value
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
