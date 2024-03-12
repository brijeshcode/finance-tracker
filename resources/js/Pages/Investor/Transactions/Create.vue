<script setup>
import AppLayout from '@/Layouts/Investor/Layout.vue';
import { useForm } from '@inertiajs/vue3';
import SimpleButton from '@/Shared/Components/Form/Simple/Button.vue'
import cInput from '@/Shared/Components/Form/Controls/Input.vue'
import cSelect from '@/Shared/Components/Form/Controls/Select.vue'
import cCheck from '@/Shared/Components/Form/Controls/Checkbox.vue'
import cArea from '@/Shared/Components/Form/Controls/Textarea.vue'
import { ref, toRefs } from 'vue';

const breadcrums = ref([ {name: 'Transactions' , route: 'investors.transactions.index'} ]);
const props = defineProps({
    transaction: { type: Object, default: null},
    platforms:  Array,
    investmentTypes:  Array
});
const { transaction } = toRefs(props);
const edit = ref(false);
const form = useForm({
    date: null,
    investment_id: null,
    platform_id: null,
    exchange: null,
    type: 'buy',
    quantity: 0,
    rate: 0,
    price: 0,
    reinvested: false,
    note: null,
}); 

console.log(transaction.value);
function submitData(){
    if(form.processing){ 
        return '';
    }
    if (transaction.value) {
        form.put(route('investors.transactions.update', transaction.id));
    }else{
        form.balance = form.starting_balance;
        form.post(route('investors.transactions.store'));
    }
}
</script>


<template>
    <app-layout :breadcrums="breadcrums" title="Transactions">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transactions
            </h2>
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent="submitData">
                    <div  class="border-b-4 mb-4">
                        <h1 class="mb-4 font-semibold">Add Transaction Details</h1> 
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-4  pb-4 border-b ">
                            <c-input  type="date"  label="Date" required v-model="form.date" :errmsg="form.errors.date" ></c-input>
                            
                            <c-select
                                label="InvestmentType"
                                required 
                                :options="investmentTypes" 
                                queryData v-model="form.investment_id"
                            ></c-select>

                            <c-select 
                                label="Platform"
                                required
                                :options="platforms" 
                                queryData v-model="form.platform_id"
                            ></c-select>

                            <c-select
                                v-if="form.investment_id == 1"
                                label="Exchange"
                                required 
                                :options="['nse', 'bse']" 
                                v-model="form.exchange"
                            ></c-select>
                            <c-select
                                label="Transaction Type"
                                required 
                                :options="['buy', 'sell']" 
                                v-model="form.type"
                            ></c-select>
                            <c-input type="number" min="0" label="quantity" required v-model="form.quantity" :errmsg="form.errors.quantity" ></c-input>
                            <c-input  type="number" label="Rate" v-model="form.rate" :errmsg="form.errors.rate" ></c-input>

                        </div>  
                        <div class="grid grid-cols-4 gap-4 mb-4">
                            <c-area label="Note" class="col-span-4" v-model="form.note" rows="3"></c-area>
                        </div>
                    </div>

                    <div class="mb-4">
                        <simple-button >Save</simple-button>
                    </div>
                </form>
            </div>
        </div>

    </app-layout>
</template> 