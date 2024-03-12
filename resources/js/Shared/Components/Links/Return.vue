<template>
    <Link :href="route(order.route, order.id)" class="text-indigo-600 hover:text-indigo-900">
        <span v-if="icon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/Return.vue'
    import { Link } from '@inertiajs/vue3';
    export default{
        components:{Link,icon},
        props: {
            order: Object,
            icon: {type: Boolean , default: false}
        },
    }
</script>