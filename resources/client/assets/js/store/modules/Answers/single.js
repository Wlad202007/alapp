function initialState() {
    return {
        item: {
            id: null,
            session: null,
            question: null,
            author: null,
            text: null,
        },
        sessionsAll: [],
        answersAll: [],
        usersAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    sessionsAll: state => state.sessionsAll,
    answersAll: state => state.answersAll,
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

            if (_.isEmpty(state.item.session)) {
                params.set('session_id', '')
            } else {
                params.set('session_id', state.item.session.id)
            }
            if (_.isEmpty(state.item.question)) {
                params.set('question_id', '')
            } else {
                params.set('question_id', state.item.question.id)
            }
            if (_.isEmpty(state.item.author)) {
                params.set('author_id', '')
            } else {
                params.set('author_id', state.item.author.id)
            }

            axios.post('/api/v1/answers', params)
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

            if (_.isEmpty(state.item.session)) {
                params.set('session_id', '')
            } else {
                params.set('session_id', state.item.session.id)
            }
            if (_.isEmpty(state.item.question)) {
                params.set('question_id', '')
            } else {
                params.set('question_id', state.item.question.id)
            }
            if (_.isEmpty(state.item.author)) {
                params.set('author_id', '')
            } else {
                params.set('author_id', state.item.author.id)
            }

            axios.post('/api/v1/answers/' + state.item.id, params)
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
        axios.get('/api/v1/answers/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchSessionsAll')
    dispatch('fetchAnswersAll')
    dispatch('fetchUsersAll')
    },
    fetchSessionsAll({ commit }) {
        axios.get('/api/v1/sessions')
            .then(response => {
                commit('setSessionsAll', response.data.data)
            })
    },
    fetchAnswersAll({ commit }) {
        axios.get('/api/v1/answers')
            .then(response => {
                commit('setAnswersAll', response.data.data)
            })
    },
    fetchUsersAll({ commit }) {
        axios.get('/api/v1/users')
            .then(response => {
                commit('setUsersAll', response.data.data)
            })
    },
    setSession({ commit }, value) {
        commit('setSession', value)
    },
    setQuestion({ commit }, value) {
        commit('setQuestion', value)
    },
    setAuthor({ commit }, value) {
        commit('setAuthor', value)
    },
    setText({ commit }, value) {
        commit('setText', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setSession(state, value) {
        state.item.session = value
    },
    setQuestion(state, value) {
        state.item.question = value
    },
    setAuthor(state, value) {
        state.item.author = value
    },
    setText(state, value) {
        state.item.text = value
    },
    setSessionsAll(state, value) {
        state.sessionsAll = value
    },
    setAnswersAll(state, value) {
        state.answersAll = value
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
