<template>
    <div v-html="row.gallery_link"></div>
</template>


<script>
    export default {
        props: ['row'],
    }
</script>
