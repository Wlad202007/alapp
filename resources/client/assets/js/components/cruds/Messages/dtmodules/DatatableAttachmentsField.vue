<template>
    <div v-html="row.attachments_link"></div>
</template>


<script>
    export default {
        props: ['row'],
    }
</script>
