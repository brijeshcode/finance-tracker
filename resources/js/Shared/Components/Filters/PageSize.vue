<template>
    <form-input class="h-11 w-16 my-1" v-model="size" type="number" placeholder="Page Size" autocomplete="size" />
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
                page: {type: String },
                size: {type: Number, default: 10}
        },
        created(){
            // this.size = 2;
        },
        watch:{
          size: debounce( function(val){
                Inertia.get(route(this.page), {size: val },{
                        preserveState: true,
                        replace: true,
                        only:['sales']
                    });
                }, 200)
         }

    };
</script>
