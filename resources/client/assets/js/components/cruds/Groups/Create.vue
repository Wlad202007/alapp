<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Groups</h1>
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
                                    <div class="checkbox">
                                        <label>
                                            <input
                                                    type="checkbox"
                                                    name="status"
                                                    :value="item.status"
                                                    :checked="item.status == true"
                                                    @change="updateStatus"
                                            >
                                            Status *
                                        </label>
                                    </div>
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
            ...mapGetters('GroupsSingle', ['item', 'loading'])
    },
    created() {
        // Code ...
    },
    destroyed() {
        this.resetState()
    },
    methods: {
    ...mapActions('GroupsSingle', ['storeData', 'resetState', 'setName', 'setStatus']),
            updateName(e) {
            this.setName(e.target.value)
        },
        updateStatus(e) {
            this.setStatus(e.target.checked)
        },
        submitForm() {
            this.storeData()
                .then(() => {
                this.$router.push({ name: 'groups.index' })
            this.$eventHub.$emit('create-success')
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