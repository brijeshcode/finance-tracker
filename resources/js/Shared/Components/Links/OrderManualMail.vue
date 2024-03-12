<template>
    <Link :href="route(link.route, link.id)" class="text-indigo-600 hover:text-indigo-900">
        <span v-if="icon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/Email.vue'
    import { Link } from '@inertiajs/vue3';
    export default{
        components:{Link,icon},
        props: {
            link: Object,
            icon: {type: Boolean , default: false}
        },
    }
</script>