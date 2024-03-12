<template>
    <!-- <Link v-if="isbutton" :href="route(createRoute)" class=" font-black text-white bg-gradient-to-r from-indigo-500 via-indigo-600 to-indigo-700 hover:bg-gradient-to-br  dark:shadow-lg dark:shadow-indigo-800/80 font-medium rounded-lg text-xs px-5 py-2.5 text-center mr-2 mb-2" title="Add"> -->
    <Link v-if="isbutton" :href="route(createRoute)" class=" font-black text-white font-medium rounded-lg text-xs px-5 py-2 bg-indigo-500 hover:bg-indigo-800 text-center mr-2 mb-2" title="Add">
        <span v-if="withIcon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>

    <Link v-else :href="route(createRoute)" class="p-2 text-gray-500 hover:text-gray-800 dark:text-gray-200 dark:hover:text-gray-400" title="Add">
        <span v-if="withIcon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/Plus.vue'
    import { Link } from '@inertiajs/vue3';
    export default{
        components:{Link,icon},
        props: {
            createRoute: String,
            url: String,
            withIcon: {type: Boolean , default: false},
            isbutton: {type: Boolean , default: false}
        },
    }
</script>