<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Posts</h1>
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
                                    <label for="group">Group *</label>
                                    <v-select
                                            name="group"
                                            label="name"
                                            @input="updateGroup"
                                            :value="item.group"
                                            :options="groupsAll"
                                    />
                                </div>
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
                                    <label for="gallery">Gallery</label>
                                    <input
                                            type="file"
                                            class="form-control"
                                            @change="updateGallery"
                                            multiple="multiple"
                                    >
                                    <ul v-if="item.gallery || item.uploaded_gallery" class="list-unstyled">
                                        <li v-for="gallery in item.uploaded_gallery">
                                            {{ gallery.file_name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removeUploadedGallery($event, gallery.id);"
                                            >
                                                Remove file
                                            </button>
                                        </li>
                                        <li v-for="(gallery, index) in item.gallery">
                                            {{ gallery.name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removeGallery($event, index);"
                                            >
                                                Remove file
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="parent">Parent</label>
                                    <v-select
                                            name="parent"
                                            label="body"
                                            @input="updateParent"
                                            :value="item.parent"
                                            :options="postsAll"
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
		props:['group','module'],
  
        data() {
            return {
                // Code...
            }
        },
        computed: {
            ...mapGetters('PostsSingle', ['item', 'loading', 'groupsAll', 'usersAll', 'postsAll'])
    },
    created() {
        this.fetchGroupsAll(),
            this.fetchUsersAll(),
            this.fetchPostsAll()
    },
    destroyed() {
        this.resetState()
    },
    methods: {
    ...mapActions('PostsSingle', ['storeData', 'resetState', 'setGroup', 'setAuthor', 'setBody', 'setGallery', 'destroyGallery', 'destroyUploadedGallery', 'setParent', 'fetchGroupsAll', 'fetchUsersAll', 'fetchPostsAll']),
            updateGroup(value) {
            this.setGroup(value)
        },
        updateAuthor(value) {
            this.setAuthor(value)
        },
        updateBody(e) {
            this.setBody(e.target.value)
        },
        removeGallery(e, id) {
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
                this.destroyGallery(id);
            }
        })
        },
        updateGallery(e) {
            this.setGallery(e.target.files);
            this.$forceUpdate();
        },
        removeUploadedGallery (e, id) {
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
                this.destroyUploadedGallery(id);
            }
        })
        },
        updateParent(value) {
            this.setParent(value)
        },
        submitForm() {
            this.storeData()
                .then((data) => {
				console.log(this.group,data,this.module)
					group=this.group
					 this.$store.dispatch(
                        this.module + '/addDataPosts',
						{group:group ,id: data.id}
                    ).then(result => {
						
						  this.$router.go(-1)
                    this.$eventHub.$emit('create-success')
                       
                    })
//                this.$router.push({ name: 'posts.index' })
 //           this.$eventHub.$emit('create-success')
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