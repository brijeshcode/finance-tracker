<template>
	<div v-if="showFilter" class="bg-white rounded-lg shadow-md p-2 grid  gap-4 grid-cols-2 md:grid-cols-4 lg:grid-cols-6"><slot></slot></div>
</template>

<script>
    export default{
        props: {
            showFilter: Boolean, Default: false
        },
    };
</script>