<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Cards</h1>
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
                                    <label for="author">Author</label>
                                    <v-select
                                            name="author"
                                            label="name"
                                            @input="updateAuthor"
                                            :value="item.author"
                                            :options="usersAll"
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
                                    <label for="img">Img</label>
                                    <input
                                            type="file"
                                            class="form-control"
                                            @change="updateImg"
                                    >
                                    <ul v-if="item.img" class="list-unstyled">
                                        <li>
                                            {{ item.img.name || item.img.file_name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removeImg"
                                            >
                                                Remove file
                                            </button>
                                        </li>
                                    </ul>
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
        ...mapGetters('CardsSingle', ['item', 'loading', 'usersAll']),
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
        ...mapActions('CardsSingle', ['fetchData', 'updateData', 'resetState', 'setAuthor', 'setBody', 'setImg']),
        updateAuthor(value) {
            this.setAuthor(value)
        },
        updateBody(e) {
            this.setBody(e.target.value)
        },
        removeImg(e, id) {
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
                    this.setImg('');
                }
            })
        },
        updateImg(e) {
            this.setImg(e.target.files[0]);
            this.$forceUpdate();
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'cards.index' })
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
