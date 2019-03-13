<template>
    <div>
        <span class="label label-info" v-if="value !== null">
		
            {{ value[$root.sessionsrelationships[field]] }}
        </span>
    </div>
</template>


<script>
export default {
    props: ['value', 'field'],
    data() {
        return {
            // Code...
        }
    },
	computed:{
	roots(){ return this.$root}
	},
    created() {
        // Code...
    },
    methods: {
        // Code...
    }
}
</script>


<style scoped>

</style>

