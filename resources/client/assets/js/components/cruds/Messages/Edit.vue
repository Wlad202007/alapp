<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Messages</h1>
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
                                    <label for="attachments">Attachments</label>
                                    <input
                                            type="file"
                                            class="form-control"
                                            @change="updateAttachments"
                                            multiple="multiple"
                                    >
                                    <ul v-if="item.attachments || item.uploaded_attachments" class="list-unstyled">
                                        <li v-for="attachments in item.uploaded_attachments">
                                            {{ attachments.file_name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removeUploadedAttachments($event, attachments.id);"
                                            >
                                                Remove file
                                            </button>
                                        </li>
                                        <li v-for="(attachments, index) in item.attachments">
                                            {{ attachments.name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removeAttachments($event, index);"
                                            >
                                                Remove file
                                            </button>
                                        </li>
                                    </ul>
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
                                    <label for="group">Group</label>
                                    <v-select
                                            name="group"
                                            label="name"
                                            @input="updateGroup"
                                            :value="item.group"
                                            :options="eventsAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input
                                                    type="checkbox"
                                                    name="read"
                                                    :value="item.read"
                                                    :checked="item.read == true"
                                                    @change="updateRead"
                                                    >
                                            Read *
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
        ...mapGetters('MessagesSingle', ['item', 'loading', 'usersAll', 'usersAll', 'eventsAll']),
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
        ...mapActions('MessagesSingle', ['fetchData', 'updateData', 'resetState', 'setBody', 'setAttachments', 'destroyAttachments', 'destroyUploadedAttachments', 'setUsers', 'setAuthor', 'setGroup', 'setRead']),
        updateBody(e) {
            this.setBody(e.target.value)
        },
        removeAttachments(e, id) {
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
                    this.destroyAttachments(id);
                }
            })
        },
        updateAttachments(e) {
            this.setAttachments(e.target.files);
            this.$forceUpdate();
        },
        removeUploadedAttachments (e, id) {
        this.$swal({
          title: 'Are you sure ? ',
          text: "To fully delete the file submit the form.",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Delete',
          confirmButtonColor: '#dd4b39',
          focusCancel: true,
          reverseButtons: true
        }).
        then(result => {
            if (typeof result.dismiss === "undefined") {
                this.destroyUploadedAttachments(id);
            }
        })
        },
        updateUsers(value) {
            this.setUsers(value)
        },
        updateAuthor(value) {
            this.setAuthor(value)
        },
        updateGroup(value) {
            this.setGroup(value)
        },
        updateRead(e) {
            this.setRead(e.target.checked)
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'messages.index' })
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
