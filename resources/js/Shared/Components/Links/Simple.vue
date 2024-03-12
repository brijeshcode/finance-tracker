<template>
    <Link :href="route(link.route, link.id)" class="text-indigo-600 hover:text-indigo-900">
        <span><slot></slot></span>
    </Link>
</template>

<script>

    import { Link } from '@inertiajs/vue3';
    export default{
        components:{Link},
        props: {
            link: Object
        },
    }
</script>