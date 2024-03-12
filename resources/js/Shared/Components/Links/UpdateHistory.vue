<template>
    <a :href="route(link.route, link.id)" title="Update History" target="_blank" class="text-green-600 hover:text-green-900 dark:hover:text-green-400">
        <span v-if="icon"><icon class="w-4 h-4" /></span>
        <span v-else><slot></slot></span>
    </a>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/History.vue'

    export default{
        components:{icon},
        props: {
            link: Object,
            icon: {type: Boolean , default: false}
        },
    }
</script>