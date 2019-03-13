function initialState() {
    return {
        item: {
            id: null,
            group: null,
            author: null,
            body: null,
            gallery: [],
            uploaded_gallery: [],
            parent: null,
        },
        groupsAll: [],
        usersAll: [],
        postsAll: [],

        loading: false,
    }
}

const getters = {
            item: state => state.item,
    loading: state => state.loading,
    groupsAll: state => state.groupsAll,
    usersAll: state => state.usersAll,
    postsAll: state => state.postsAll,

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

        if (_.isEmpty(state.item.group)) {
            params.set('group_id', '')
        } else {
            params.set('group_id', state.item.group.id)
        }
        if (_.isEmpty(state.item.author)) {
            params.set('author_id', '')
        } else {
            params.set('author_id', state.item.author.id)
        }
        params.set('uploaded_gallery', state.item.uploaded_gallery.map(o => o['id']))
        if (_.isEmpty(state.item.parent)) {
            params.set('parent_id', '')
        } else {
            params.set('parent_id', state.item.parent.id)
        }

        axios.post('/api/v1/posts', params)
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

        if (_.isEmpty(state.item.group)) {
            params.set('group_id', '')
        } else {
            params.set('group_id', state.item.group.id)
        }
        if (_.isEmpty(state.item.author)) {
            params.set('author_id', '')
        } else {
            params.set('author_id', state.item.author.id)
        }
        params.set('uploaded_gallery', state.item.uploaded_gallery.map(o => o['id']))
        if (_.isEmpty(state.item.parent)) {
            params.set('parent_id', '')
        } else {
            params.set('parent_id', state.item.parent.id)
        }

        axios.post('/api/v1/posts/' + state.item.id, params)
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
        axios.get('/api/v1/posts/' + id)
            .then(response => {
            commit('setItem', response.data.data)
    })

        dispatch('fetchGroupsAll')
        dispatch('fetchUsersAll')
        dispatch('fetchPostsAll')
    },
    fetchGroupsAll({ commit }) {
        axios.get('/api/v1/groups')
            .then(response => {
            commit('setGroupsAll', response.data.data)
    })
    },
    fetchUsersAll({ commit }) {
        axios.get('/api/v1/users')
            .then(response => {
            commit('setUsersAll', response.data.data)
    })
    },
    fetchPostsAll({ commit }) {
        axios.get('/api/v1/posts')
            .then(response => {
            commit('setPostsAll', response.data.data)
    })
    },
    setGroup({ commit }, value) {
        commit('setGroup', value)
    },
    setAuthor({ commit }, value) {
        commit('setAuthor', value)
    },
    setBody({ commit }, value) {
        commit('setBody', value)
    },
    setGallery({ commit }, value) {
        commit('setGallery', value)
    },
    destroyGallery({ commit }, value) {
        commit('destroyGallery', value)
    },
    destroyUploadedGallery({ commit }, value) {
        commit('destroyUploadedGallery', value)
    },
    setParent({ commit }, value) {
        commit('setParent', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setGroup(state, value) {
        state.item.group = value
    },
    setAuthor(state, value) {
        state.item.author = value
    },
    setBody(state, value) {
        state.item.body = value
    },
    setGallery(state, value) {
        for (let i in value) {
            let gallery = value[i];
            if (typeof gallery === "object") {
                state.item.gallery.push(gallery);
            }
        }
    },
    destroyGallery(state, value) {
        for (let i in state.item.gallery) {
            if (i == value) {
                state.item.gallery.splice(i, 1);
            }
        }
    },
    destroyUploadedGallery(state, value) {
        for (let i in state.item.uploaded_gallery) {
            let data = state.item.uploaded_gallery[i];
            if (data.id === value) {
                state.item.uploaded_gallery.splice(i, 1);
            }
        }
    },
    setParent(state, value) {
        state.item.parent = value
    },
    setGroupsAll(state, value) {
        state.groupsAll = value
    },
    setUsersAll(state, value) {
        state.usersAll = value
    },
    setPostsAll(state, value) {
        state.postsAll = value
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