<template>
    <form-input class="h-11 my-1" v-model="search" type="text" placeholder="Search..." autocomplete="search" />
</template>

<script>
    import debounce from 'lodash/debounce'
    import { router } from '@inertiajs/vue3'
    import FormInput from '@/Shared/Components/Form/Simple/Input.vue'
    export default{
        components: {
            FormInput

        },
        props: {
                searchRoute: String
        },
        data: () => ({
            search: ''
        }),
        watch:{
          search: debounce( function(val){
            router.get(route(this.searchRoute), {search: val },{
                        preserveState: true,
                        replace: true
                    });
                }, 200)
         }

    };
</script>
