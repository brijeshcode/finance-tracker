<template>
    <Link :href="route(link.route, link.id)" class="text-green-600 hover:text-green-900 dark:hover:text-green-400">
        <span v-if="icon"><icon class="w-4 h-4" /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/Eye.vue'
    import { Link } from '@inertiajs/vue3';
    export default{
        components:{Link,icon},
        props: {
            link: Object,
            icon: {type: Boolean , default: false}
        },
    }
</script>