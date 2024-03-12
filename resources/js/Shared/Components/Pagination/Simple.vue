<template>
	<!-- This example requires Tailwind CSS v2.0+ -->
	<div class="bg-white px-1 py-2 text-sm flex items-center justify-between border-t border-gray-200 sm:px-2">
		<div class="flex-1 flex justify-between sm:hidden">
			<Component
	          :is="pageData.prev_page_url ? 'Link' : 'span'"
	          :href="pageData.prev_page_url"
	          class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
	          v-text="'Previous'" />
	         <Component
	          :is="pageData.next_page_url ? 'Link' : 'span'"
	          :href="pageData.next_page_url "
	          class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
	          v-text="'Next'" />
		</div>
		<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
		  <div>
		    <p class="text-sm text-gray-700" v-if="pageData.from && pageData.total && pageData.to">
		      Showing
		      <span class="font-medium">{{ pageData.from }}</span>
		      to
		      <span class="font-medium">{{ pageData.to }}</span>
		      of
		      <span class="font-medium">{{ pageData.total }}</span>
		       <span v-if="pageof" > {{ pageof }}</span>
		      <span v-else> results</span>
		    </p>
		  </div>
		  <div>
		    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
		        <Component
		          v-for="link in pageData.links"
		          :is="link.url ? 'Link' : 'span'"
		          :href="link.url"
		          class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-2 py-1 border text-sm font-medium"
		          :class="link.active ? 'text-indigo-800 bg-indigo-200 hover:bg-indigo-200 ' : ''"
		          v-html="link.label" />
		    </nav>
		  </div>
		</div>
	</div>
</template>
<script>
    import { Link } from '@inertiajs/vue3';
	export default{
        components: {
        	Link
        },
		props: { pageData:Object, pageof:String }
	};
</script>