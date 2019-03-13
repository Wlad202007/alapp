<template>
    <div v-html="row.full_agenda_link"></div>
</template>


<script>
    export default {
        props: ['row'],
    }
</script>
