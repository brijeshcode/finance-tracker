<template>
	<nav class="tabs pt-2 w-full">
	    <ul class="flex flex-wrap justify-start border-b space-x-5">
	        <li v-for="link in links" class="border-b-2 text-base border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-400 " :class="route().current(link.route) ? 'border-blue-500 text-blue-500' : '' ">
            	<Link class="cursor-pointer block px-4 pb-4 font-semibold" :href="route(link.route)">{{ link.title }}</Link>
	        </li>
	    </ul>
	</nav>
</template>


<script>
    import { Link } from '@inertiajs/vue3';
    export default{
        components: {
            Link
        },
        props: {
            links: Array
        },


    };
</script>