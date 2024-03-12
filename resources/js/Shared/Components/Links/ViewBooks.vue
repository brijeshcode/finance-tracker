<template>
    <Link :href="route(book.route, book.of)" class="text-orange-600 hover:text-orange-900">
        <span v-if="icon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/OpenBook.vue'
    import { Link } from '@inertiajs/vue3';
    export default{
        components:{Link,icon},
        props: {
            book: Object,
            icon: {type: Boolean , default: false}
        },
    }
</script>