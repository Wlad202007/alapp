<template>
    <div>
      <!-- <span class="label label-info" v-for="item in value"> -->
        <span class="label label-info">
            <!-- {{ item[$root.eventsrelationships[field]] }} -->
            {{ request.length }}
        </span>
    </div>
</template>


<script>
export default {
    props: ['value', 'field'],
    data() {
        return {

        }
    },
	computed:{
	roots(){ return this.$root},

  request(){
    let list=[];
    let thisDay = new Date().toISOString().slice(0,10);
      $.each(this.value, function(key, item) {
        if (item.created_at.slice(0,10) == thisDay){
        list.push(item.created_at);
        }
      });
      return list;
  },
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
