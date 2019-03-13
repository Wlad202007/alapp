<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Events</h1>
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
                                    <label for="name">Name *</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            placeholder="Enter Name *"
                                            :value="item.name"
                                            @input="updateName"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <vue-ckeditor
                                            name="description"
                                            :id="'description'"
                                            :value="item.description"
                                            @input="updateDescription"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="address"
                                            placeholder="Enter Address *"
                                            :value="item.address"
                                            @input="updateAddress"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="date_from">Date from</label>
                                    <date-picker
                                            :value="item.date_from"
                                            :config="$root.dpconfigDate"
                                            name="date_from"
                                            placeholder="Enter Date from"
                                            @dp-change="updateDate_from"
                                            >
                                    </date-picker>
                                </div>
                                <div class="form-group">
                                    <label for="date_to">Date to</label>
                                    <date-picker
                                            :value="item.date_to"
                                            :config="$root.dpconfigDate"
                                            name="date_to"
                                            placeholder="Enter Date to"
                                            @dp-change="updateDate_to"
                                            >
                                    </date-picker>
                                </div>
                                <div class="form-group">
                                    <label for="full_agenda">Full agenda</label>
                                    <input
                                            type="file"
                                            class="form-control"
                                            @change="updateFull_agenda"
                                    >
                                    <ul v-if="item.full_agenda" class="list-unstyled">
                                        <li>
                                            {{ item.full_agenda.name || item.full_agenda.file_name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removeFull_agenda"
                                            >
                                                Remove file
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="web_url">Web url</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="web_url"
                                            placeholder="Enter Web url"
                                            :value="item.web_url"
                                            @input="updateWeb_url"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="attendees">Attendees</label>
                                    <v-select
                                            name="attendees"
                                            label="name"
                                            @input="updateAttendees"
                                            :value="item.attendees"
                                            :options="usersAll"
                                            multiple
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="sponsors">Sponsors</label>
                                    <v-select
                                            name="sponsors"
                                            label="name"
                                            @input="updateSponsors"
                                            :value="item.sponsors"
                                            :options="sponsorsAll"
                                            multiple
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="agenda">Agenda</label>
                                    <v-select
                                            name="agenda"
                                            label="text"
                                            @input="updateAgenda"
                                            :value="item.agenda"
                                            :options="agendasAll"
                                            multiple
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="industry">Industry</label>
                                    <v-select
                                            name="industry"
                                            label="name"
                                            @input="updateIndustry"
                                            :value="item.industry"
                                            :options="industriesAll"
                                            />
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
        ...mapGetters('EventsSingle', ['item', 'loading', 'usersAll', 'sponsorsAll', 'agendasAll', 'industriesAll'])
    },
    created() {
        this.fetchUsersAll(),
        this.fetchSponsorsAll(),
        this.fetchAgendasAll(),
        this.fetchIndustriesAll()
		this.initUsers(this.user)
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('EventsSingle', ['storeData', 'resetState', 'setName','setAddress', 'setDescription', 'setDate_from', 'setDate_to', 'setFull_agenda', 'setWeb_url', 'setAttendees', 'setSponsors', 'setAgenda', 'setIndustry', 'fetchUsersAll', 'fetchSponsorsAll', 'fetchAgendasAll', 'fetchIndustriesAll']),
        updateName(e) {
            this.setName(e.target.value)
        },
        updateDescription(value) {
            this.setDescription(value)
        },
        updateAddress(value) {
            this.setAddress(value)
        },
        updateDate_from(e) {
            this.setDate_from(e.target.value)
        },
        updateDate_to(e) {
            this.setDate_to(e.target.value)
        },
        removeFull_agenda(e, id) {
            this.$swal({
                title: 'Are you sure?',
                text: "To fully delete the file submit the form.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#dd4b39',
                focusCancel: true,
                reverseButtons: true
            }).then(result => {
                if (typeof result.dismiss === "undefined") {
                    this.setFull_agenda('');
                }
            })
        },
        updateFull_agenda(e) {
            this.setFull_agenda(e.target.files[0]);
            this.$forceUpdate();
        },
        updateWeb_url(e) {
            this.setWeb_url(e.target.value)
        },
        updateAttendees(value) {
            this.setAttendees(value)
        },
        updateSponsors(value) {
            this.setSponsors(value)
        },
        updateAgenda(value) {
            this.setAgenda(value)
        },
        updateIndustry(value) {
            this.setIndustry(value)
        },
		initUsers(user){
			 axios.get('/api/v1/users/' + user)
            .then(response => {
				
                this.updateAttendees( [response.data.data])
            })
			},
        submitForm() {
            this.storeData()
                .then((data) => {
				
				console.log(this.user,data,this.module)
					user=this.user
					 this.$store.dispatch(
                        this.module + '/addDataEvents',
						{user:user ,id: data.id}
                    ).then(result => {
						
						  this.$router.go(-1)
                    this.$eventHub.$emit('create-success')
                       
                    })
                    //this.$router.push({ name: 'events.index' })
                    //this.$eventHub.$emit('create-success')
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
