<template>
    <Modal :show="show" max-width="2xl">
        <form @submit.prevent="submit">
            <div class="px-6 py-4">
                <div class="text-lg">
                    Add Brocker
                </div>
                
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <c-select 
                            label="Chose Platform"
                            required
                            :options="platforms" 
                            queryData 
                            v-model="form.platform_id"
                    ></c-select>
                     
                </div>
            </div>
            
            <div class="flex flex-row justify-end px-6 py-4 gap-4 bg-gray-100 text-right">
                <simple-button type="submit" :disabled="form.processing" >Add</simple-button> 
                <simple-button class="bg-red-600" @click="close"  >Cancel</simple-button>
            </div>
        </form>
    </Modal>
</template>

<script setup>
    import SimpleButton from '@/Shared/Components/Form/Simple/Button.vue'
    import cInput from '@/Shared/Components/Form/Controls/Input.vue'
    import cSelect from '@/Shared/Components/Form/Controls/Select.vue'
    import Modal from '@/Components/Modal.vue';
    import { useForm } from '@inertiajs/vue3'
    import { onBeforeMount, ref } from 'vue';


    const props = defineProps({
        show: {type: Boolean, default: false},
    });

    const platforms = ref([]);

    const form = useForm({
        platform_id: null
    })

    function submit() {
       /*  form.post(route('admin.trades.addclient'), {
            onSuccess: () => { form.reset() ; close();} ,
        }); */
    }


    const emit = defineEmits(['close']);

    const close = () => {
        emit('close');
    }
    
    onBeforeMount(() => {
        getPlatfroms();
    });

    function getPlatfroms(){
        fetch(route('api.investors.platfroms'))
        .then(response => response.json())
        .then(platform => { platforms.value = platform;  }); 
    }
</script>