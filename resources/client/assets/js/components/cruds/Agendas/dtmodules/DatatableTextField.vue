<template>
    <div v-html="row.text"></div>
</template>


<script>
    export default {
        props: ['row'],
    }
</script>
