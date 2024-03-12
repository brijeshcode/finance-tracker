<template>

    <div class="flex items-center py-2 overflow-y-auto whitespace-nowrap" v-if="items">
        <Link :href="route('dashboard')" class="text-gray-600 dark:text-gray-500">
            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg> -->
            <svg class="h-4 w-4"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="13" r="2" />  <line x1="13.45" y1="11.55" x2="15.5" y2="9.5" />  <path d="M6.4 20a9 9 0 1 1 11.2 0Z" /></svg>
        </Link>

        <div v-for="link in items" class="flex items-center">

            <span class="mx-5 text-gray-500 dark:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </span>

            <Link v-if="link.url" :href="link.url" class="text-sm" :class="link.active ? active : inactive ">
                {{ link.name }}
            </Link>

            <Link v-else-if="link.route" class="text-sm" :href="route(link.route)"  :class="route().current(link.route) ? active : inactive ">
                <span v-if="link.name">{{ link.name.replace(/-/g, ' ') }}</span>
                <span v-else class="capitalize">{{ link.route.split(".")[0].replace(/-/g, ' ') }}</span>
            </Link>

            <Link v-else href="#"  class="text-sm" :class="active">
                <span v-if="link.name" class="capitalize">{{ link.name }}</span>
            </Link>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/vue3';
    export default{
        components: {
            Link
        },
        props: {
            items: Array,
            routes: Array
        },
        data: () => ({
            inactive : 'text-gray-600 dark:text-gray-600 hover:underline capitalize ',
            active: 'text-blue-600 dark:text-blue-400 hover:underline capitalize'
        }),

    };
</script>