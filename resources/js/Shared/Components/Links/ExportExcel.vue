<template>
    <a :href="route(excel, parameter)" title="Download To Excel file" class="text-gray-500 hover:text-gray-800 dark:text-gray-200 dark:hover:text-gray-400">
        <span v-if="icon"><icon /></span>
        <span v-else><slot></slot></span>
    </a>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/DownloadFile.vue'
    import { Link } from '@inertiajs/vue3';
    export default{
        components:{Link,icon},
        props: {
            excel: String,
            parameter: {type: Object, default: {} },
            icon: {type: Boolean , default: true}
        },
    }
</script>