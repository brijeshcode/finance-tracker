<template>
    <Link :href="route(edit.route, edit.to)" class="text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400">
        <span v-if="icon"><icon class="w-4 h-4" /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/Edit.vue'
    import { Link } from '@inertiajs/vue3';
    export default{
        components:{Link,icon},
        props: {
            edit: Object,
            icon: {type: Boolean , default: false}
        },
    }
</script>