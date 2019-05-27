<template>
    <div>
      <!-- <span class="label label-info" v-for="item in value"> -->
        <span class="label label-info">
            <!-- {{ item[$root.eventsrelationships[field]] }} -->
            {{ value.length }}
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
