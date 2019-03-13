<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Notes</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Create</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="author">Author *</label>
                                    <v-select
                                            name="author"
                                            label="name"
                                            @input="updateAuthor"
                                            :value="item.author"
                                            :options="usersAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="text">Text *</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="text"
                                            placeholder="Enter Text *"
                                            :value="item.text"
                                            @input="updateText"
                                            >
                                </div>
                            </div>

                            <div class="box-footer">
                                <vue-button-spinner
                                        class="btn btn-primary btn-sm"
                                        :isLoading="loading"
                                        :disabled="loading"
                                        >
                                    Save
                                </vue-button-spinner>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'

export default {
props:['user','module'],
    data() {
        return {
            // Code...
        }
    },
    computed: {
        ...mapGetters('NotesSingle', ['item', 'loading', 'usersAll'])
    },
    created() {
        this.fetchUsersAll()
		this.initUser(this.user)
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('NotesSingle', ['storeData', 'resetState', 'setAuthor', 'setText', 'fetchUsersAll']),
        updateAuthor(value) {
            this.setAuthor(value)
        },
        updateText(e) {
            this.setText(e.target.value)
        },
		initUser(user){
			 axios.get('/api/v1/users/' + user)
            .then(response => {
				
                this.updateAuthor( response.data.data)
            })
			},
        submitForm() {
            this.storeData()
                .then((data) => {
				console.log(this.user,data,this.module)
					user=this.user
					 this.$store.dispatch(
                        this.module + '/addDataNotes',
						{user:user ,id: data.id}
                    ).then(result => {
						
						  this.$router.go(-1)
                    this.$eventHub.$emit('create-success')
                       
                    })
					
				
				
                   // this.$router.push({ name: 'notes.index' })
                   // this.$eventHub.$emit('create-success')
                })
                .catch((error) => {
                    console.error(error)
                })
        }
    }
}
</script>


<style scoped>

</style>
