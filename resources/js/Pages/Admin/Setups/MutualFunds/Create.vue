<script setup>
    import { useForm } from '@inertiajs/vue3'
    import { onMounted } from 'vue';
    import AdminLayout from '@/Layouts/Admin/Layout.vue';
    import SimpleButton from '@/Shared/Components/Form/Simple/Button.vue'
    import cInput from '@/Shared/Components/Form/Controls/Input.vue' 
    import cCheck from '@/Shared/Components/Form/Controls/Checkbox.vue'
    import cArea from '@/Shared/Components/Form/Controls/Textarea.vue'

    const props = defineProps({
        mutualFund: Object
    });

    let breadcrums = [ { route: 'admin.mutualFunds.index', name: 'Mutual Fund'}, {route: 'admin.mutualFunds.create', name:'Add'} ];
    const form = useForm({
        name: null,
        expense_ratio: null,
        type: null,
        market_cap: null,
        is_index_fund: false,
        note: null,
        active: true
    })

    const submitData = () => {
        if(form.processing){ 
            return '';
        }
        if (props.mutualFund) {
            form.put(route('admin.mutualFunds.update', props.mutualFund.id));
        }else{
            form.post(route('admin.mutualFunds.store'));
        }
    }

    onMounted(() => {
        if (props.mutualFund) {
            Object.keys(props.mutualFund).forEach(key => {
                form[key] = props.mutualFund[key];
            });

            breadcrums = [ { route: 'admin.mutualFunds.index', name: 'Mutual Fund'}, { name:'edit'} ];

        } 
    });

   
</script>

<template>
    <admin-layout :breadcrums="breadcrums" title="Mutual Fund">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mutual Fund
            </h2>
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent="submitData">
                    <div  class="border-b-4 mb-4"> 
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4  pb-4 border-b ">
                            <c-input  type="text"  label="Name" required v-model="form.name" :errmsg="form.errors.name" ></c-input>
                            <c-input  type="text"  label="Type" required v-model="form.type" :errmsg="form.errors.type" ></c-input>
                            <c-input  type="text"  label="Market cap" v-model="form.market_cap" :errmsg="form.errors.market_cap" ></c-input>
                            <c-input  type="text"  label="Expense ratio" v-model="form.expense_ratio" :errmsg="form.errors.expense_ratio" ></c-input>
 
                        </div>
                         
                        <div class="grid grid-cols-4 gap-4 mb-4 ">
                            <c-area  label="Note" class="col-span-4" v-model="form.note" rows="3" ></c-area>
                        </div>
                        
                            <c-check label="Index fund?" v-model:checked="form.is_index_fund" ></c-check>
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