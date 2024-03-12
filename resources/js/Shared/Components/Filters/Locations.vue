<template>
    <select id="location_id" v-model="search_location_id" class="w-60 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
        <option v-for="location in locations" v-bind:value="location.id">{{ location.name }}</option>
    </select>
</template>

<script>
    // import debounce from 'lodash/debounce'
    import { router } from '@inertiajs/vue3'
    // import JetInput from '@/Jetstream/Input.vue'
    export default{
        components: {
            // JetInput
        },
        props: {
                searchRoute: String,
        },
        data: () => ({
            locations: [],
            search_location_id : ''
        }),
        created(){
            axios.get(route('locations.list')).then(locations =>{
                this.locations = locations.data;
            });

        },
        watch:{
          search_location_id: function(val){
                console.log(this.route);
                Inertia.get(route(this.searchRoute), {search_location_id: val, search: 'warehouse' },{
                    preserveState: true,
                    replace: true
                });
            }
         }

    };
</script>
