<script setup>
import AppLayout from '@/Layouts/Investor/Layout.vue';
import { useForm } from '@inertiajs/vue3';
import SimpleButton from '@/Shared/Components/Form/Simple/Button.vue'
import cInput from '@/Shared/Components/Form/Controls/Input.vue'
import cSelect from '@/Shared/Components/Form/Controls/Select.vue'
import cCheck from '@/Shared/Components/Form/Controls/Checkbox.vue'
import cArea from '@/Shared/Components/Form/Controls/Textarea.vue'
import { computed, onMounted, ref, toRefs } from 'vue';

let breadcrums = [ {name: 'Transactions' , route: 'investors.stockTransactions.index'} ];
const props = defineProps({
    stockTransaction: { type: Object, default: null},
    platforms:  Array,
    reinvestmentLables: Array,
    stocks:  Array
}); 

const form = useForm({
    date: new Date().toISOString().substr(0, 10),
    stock_id: null,
    platform_id: null,
    exchange: null,
    is_buy: true,
    quantity: 0,
    rate: 0,
    price: 0,
    is_reinvested: false,
    reinvestment_lable: null, 
    note: null,
}); 


const price = computed(() =>  form.rate * form.quantity )
function submitData(){
    if(form.processing){ 
        return '';
    }
    
    if (props.stockTransaction) {
        form.put(route('investors.stockTransactions.update', props.stockTransaction.id));
    }else{ 
        form.post(route('investors.stockTransactions.store'));
    }
}

onMounted(() => {
    if (props.stockTransaction) {
        Object.keys(props.stockTransaction).forEach(key => {
            form[key] = props.stockTransaction[key];
        });

        breadcrums = [ { route: 'investors.stockTransactions.index', name: 'Stocks'}, { name:'edit'} ];

    } 
});
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
                            label="Platform"
                            required
                            :options="platforms" 
                            queryData v-model="form.platform_id"
                            ></c-select>

                            <c-select
                                label="Stock"
                                required 
                                :options="stocks" 
                                queryData v-model="form.stock_id"
                            ></c-select>

                            <c-select                                 
                                label="Exchange"
                                required 
                                :options="['nse', 'bse']" 
                                v-model="form.exchange"
                            ></c-select> 

                            <c-input type="number" min="0" label="quantity" required v-model="form.quantity" :errmsg="form.errors.quantity" ></c-input>
                            <c-input  type="number" label="Rate" v-model="form.rate" :errmsg="form.errors.rate" ></c-input>
                            <c-input  type="number" disabled label="Total" v-model="price" ></c-input>

                        </div>  
                        <div class="grid grid-cols-4 gap-4 mb-4">
                            <c-check label="is Re-investment" v-model:checked="form.is_reinvested" ></c-check>
                            <c-select                                
                                v-if="form.is_reinvested" 
                                label="Re-investment Label" 
                                required 
                                :options="reinvestmentLables" 
                                v-model="form.reinvestment_lable"
                            ></c-select>

                        </div>
                        
                        <div class="grid grid-cols-4 gap-4 mb-4">
                            <c-area label="Note" class="col-span-4" v-model="form.note" rows="3"></c-area>
                        </div>
                        
                        <c-check label="Buy Transaction" v-model:checked="form.is_buy" ></c-check>
                    </div>

                    <div class="mb-4">
                        <simple-button >Save</simple-button>
                    </div>
                </form>
            </div>
        </div>

    </app-layout>
</template> 