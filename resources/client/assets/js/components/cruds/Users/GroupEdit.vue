<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Users</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="avatar">Avatar</label>
                                    <input
                                            type="file"
                                            class="form-control"
                                            @change="updateAvatar"
                                    >
                                    <ul v-if="item.avatar" class="list-unstyled">
                                        <li>
                                            {{ item.avatar.name || item.avatar.file_name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removeAvatar"
                                            >
                                                Remove file
                                            </button>
                                        </li>
                                    </ul>
                                </div>
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
                                    <textarea
                                            rows="3"
                                            class="form-control"
                                            name="description"
                                            placeholder="Enter Description"
                                            :value="item.description"
                                            @input="updateDescription"
                                            >
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="company"
                                            placeholder="Enter Company"
                                            :value="item.company"
                                            @input="updateCompany"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="job">Job</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="job"
                                            placeholder="Enter Job"
                                            :value="item.job"
                                            @input="updateJob"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="phone"
                                            placeholder="Enter Phone"
                                            :value="item.phone"
                                            @input="updatePhone"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input
                                            type="email"
                                            class="form-control"
                                            name="email"
                                            placeholder="Enter Email *"
                                            :value="item.email"
                                            @input="updateEmail"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="password">Password *</label>
                                    <input
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="Enter Password *"
                                            @input="updatePassword"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="role">Role *</label>
                                    <v-select
                                            name="role"
                                            label="title"
                                            @input="updateRole"
                                            :value="item.role"
                                            :options="rolesAll"
                                            multiple
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="my_events">My events</label>
                                    <v-select
                                            name="my_events"
                                            label="name"
                                            @input="updateMy_events"
                                            :value="item.my_events"
                                            :options="eventsAll"
                                            multiple
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
    data() {
        return {
            // Code...
        }
    },
    computed: {
        ...mapGetters('UsersSingle', ['item', 'loading', 'rolesAll', 'eventsAll']),
    },
    created() {
        this.fetchData(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('UsersSingle', ['fetchData', 'updateData', 'resetState', 'setAvatar', 'setName', 'setDescription', 'setCompany', 'setJob', 'setPhone', 'setEmail', 'setPassword', 'setRole', 'setMy_events']),
        removeAvatar(e, id) {
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
                    this.setAvatar('');
                }
            })
        },
        updateAvatar(e) {
            this.setAvatar(e.target.files[0]);
            this.$forceUpdate();
        },
        updateName(e) {
            this.setName(e.target.value)
        },
        updateDescription(e) {
            this.setDescription(e.target.value)
        },
        updateCompany(e) {
            this.setCompany(e.target.value)
        },
        updateJob(e) {
            this.setJob(e.target.value)
        },
        updatePhone(e) {
            this.setPhone(e.target.value)
        },
        updateEmail(e) {
            this.setEmail(e.target.value)
        },
        updatePassword(e) {
            this.setPassword(e.target.value)
        },
        updateRole(value) {
            this.setRole(value)
        },
        updateMy_events(value) {
            this.setMy_events(value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
					  this.$router.go(-1)
                    //this.$router.push({ name: 'users.index' })
                    this.$eventHub.$emit('update-success')
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
