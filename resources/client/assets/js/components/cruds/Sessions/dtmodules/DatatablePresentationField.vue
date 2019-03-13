<template>
    <div v-html="row.presentation_link"></div>
</template>


<script>
    export default {
        props: ['row'],
    }
</script>
