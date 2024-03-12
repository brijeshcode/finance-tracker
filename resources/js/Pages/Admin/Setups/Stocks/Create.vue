<script setup>
    import { useForm } from '@inertiajs/vue3'
    import { onMounted } from 'vue';
    import AdminLayout from '@/Layouts/Admin/Layout.vue';
    import SimpleButton from '@/Shared/Components/Form/Simple/Button.vue'
    import cInput from '@/Shared/Components/Form/Controls/Input.vue' 
    import cCheck from '@/Shared/Components/Form/Controls/Checkbox.vue'
    import cArea from '@/Shared/Components/Form/Controls/Textarea.vue'

    const props = defineProps({
        stock: Object
    });

    let breadcrums = [ { route: 'admin.stocks.index', name: 'Stocks'}, {route: 'admin.stocks.create', name:'Add'} ];
    const form = useForm({
        name: null,
        symbol: null,
        bse_code: null,
        nse_code: null,
        web_link: null,
        note: null,
        active: true
    })

    const submitData = () => {
        if(form.processing){ 
            return '';
        }
        if (props.stock) {
            form.put(route('admin.stocks.update', props.stock.id));
        }else{
            form.post(route('admin.stocks.store'));
        }
    }

    onMounted(() => {
        if (props.stock) {
            Object.keys(props.stock).forEach(key => {
                form[key] = props.stock[key];
            });

            breadcrums = [ { route: 'admin.stocks.index', name: 'Stocks'}, { name:'edit'} ];

        } 
    });

   
</script>

<template>
    <admin-layout :breadcrums="breadcrums" title="Stocks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Stocks
            </h2>
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent="submitData">
                    <div  class="border-b-4 mb-4">
                        <h1 class="mb-4 font-semibold">Personal Details</h1>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4  pb-4 border-b ">
                            <c-input  type="text"  label="Name" required v-model="form.name" :errmsg="form.errors.name" ></c-input>
                            <c-input  type="text"  label="symbol" required v-model="form.symbol" :errmsg="form.errors.symbol" ></c-input>
                            <c-input  type="text"  label="NSE Code" v-model="form.nse_code" :errmsg="form.errors.nse_code" ></c-input>
                            <c-input  type="text"  label="BSE Code" v-model="form.bse_code" :errmsg="form.errors.bse_code" ></c-input>

                            <c-input type="url"  min="0" label="Web link" v-model="form.web_link" :errmsg="form.errors.web_link" ></c-input>

                        </div>
                         
                        <div class="grid grid-cols-4 gap-4 mb-4 ">
                            <c-area  label="Note" class="col-span-4" v-model="form.note" rows="3" ></c-area>
                        </div>
                            <c-check label="Active" v-model:checked="form.active" ></c-check>
                    </div>


                    <div class="mb-4">
                        <simple-button >Save</simple-button>
                    </div>
                </form>
            </div>
        </div>

    </admin-layout>
</template>