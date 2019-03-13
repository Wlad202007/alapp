<template>
    <div class="btn-group btn-group-xs">
      

        <router-link
                v-if="$can(xprops.permission_prefix + 'edit')"
                :to="{ name: xprops.route + '.edit', params: { id: row.id ,event:xprops.params} }"
                class="btn btn-warning">
            Edit
        </router-link>

        <button
                v-if="$can(xprops.permission_prefix + 'delete')"
                @click="destroyData(xprops.params,row.id)"
                type="button"
                class="btn btn-danger">
            Delete
        </button>
   </div>
</template>


<script>
export default {
    props: ['row', 'xprops'],
    data() {
        return {
            // Code...
        }
    },
    created() {
        // Code...
    },
    methods: {
        destroyData(event,id) {
			console.log(event,id);
            this.$swal({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#dd4b39',
                focusCancel: true,
                reverseButtons: true
            }).then(result => {
                if (result.value) {
					console.log('--',event,id);
                    this.$store.dispatch(
                        this.xprops.module + '/destroyDataSponsors',
						{event:event ,id: id}
                    ).then(result => {
                        this.$eventHub.$emit('delete-success')
                    })
                }
            })
        }
    }
}
</script>


<style scoped>

</style>
