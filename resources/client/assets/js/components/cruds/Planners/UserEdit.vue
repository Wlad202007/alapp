<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Planners</h1>
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
                                    <label for="time">Time *</label>
                                    <date-picker
                                            :value="item.time"
                                            :config="$root.dpconfigDatetime"
                                            name="time"
                                            placeholder="Enter Time *"
                                            @dp-change="updateTime"
                                            >
                                    </date-picker>
                                </div>
                                <div class="form-group">
                                    <label for="users">Users</label>
                                    <v-select
                                            name="users"
                                            label="name"
                                            @input="updateUsers"
                                            :value="item.users"
                                            :options="usersAll"
                                            multiple
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="body">Body</label>
                                    <textarea
                                            rows="3"
                                            class="form-control"
                                            name="body"
                                            placeholder="Enter Body"
                                            :value="item.body"
                                            @input="updateBody"
                                            >
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input
                                                    type="checkbox"
                                                    name="done"
                                                    :value="item.done"
                                                    :checked="item.done == true"
                                                    @change="updateDone"
                                                    >
                                            Done *
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="author">Author</label>
                                    <v-select
                                            name="author"
                                            label="name"
                                            @input="updateAuthor"
                                            :value="item.author"
                                            :options="usersAll"
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
        ...mapGetters('PlannersSingle', ['item', 'loading', 'usersAll', 'usersAll']),
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
        ...mapActions('PlannersSingle', ['fetchData', 'updateData', 'resetState', 'setTime', 'setUsers', 'setBody', 'setDone', 'setAuthor']),
        updateTime(e) {
            this.setTime(e.target.value)
        },
        updateUsers(value) {
            this.setUsers(value)
        },
        updateBody(e) {
            this.setBody(e.target.value)
        },
        updateDone(e) {
            this.setDone(e.target.checked)
        },
        updateAuthor(value) {
            this.setAuthor(value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
                   this.$router.go(-1)
				 //   this.$router.push({ name: 'planners.index' })
                 //   this.$eventHub.$emit('update-success')
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
