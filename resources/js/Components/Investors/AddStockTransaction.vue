<script setup>
    import { onBeforeMount, onMounted, onUpdated, ref } from 'vue';
    import { useForm } from '@inertiajs/vue3'
    import cSelect from '@/Shared/Components/Form/Controls/Select.vue'
    import Modal from '@/Components/Modal.vue';
    import cInput from '@/Shared/Components/Form/Controls/Input.vue'
    import SimpleButton from '@/Shared/Components/Form/Simple/Button.vue'


    const props = defineProps({
        show: {type: Boolean, default: false},
        selectedPlatform: {type: Object},
        selectedStockId: {type: Number , default: null}
    });

    const stocks = ref([]);

    const form = useForm({
        date : new Date().toISOString().substr(0, 10), 
        platform_id: null,
        stock_id: null, 
        exchange: 'nse', 
        quantity: 0,
        rate: 0, 
        price: 0, 
        is_buy: true, 
        transaciton_charge: 0, 
        note: null
    })

    function submit() { 
        form.price = form.rate * form.quantity;

        form.post(route('investors.stockTransactions.store'), {
            onSuccess: () => { form.reset() ; close();} ,
        });
    }


    const emit = defineEmits(['close']);

    const close = () => {
        emit('close');
    }
    
    onBeforeMount(() => {
        getStocks();
    });
    
    onUpdated(() => {
        if(props.selectedPlatform){
            form.platform_id = props.selectedPlatform.id;
        }
        
        if(props.selectedPlatform){
            form.stock_id = props.selectedStockId;
        }
    });

    function getStocks(){
        fetch(route('api.investors.stocks'))
        .then(response => response.json())
        .then(stockData => { stocks.value = stockData;  }); 
    }
</script>

<template>
    <Modal :show="show" max-width="2xl">
        <form @submit.prevent="submit"> 
            <div class="px-6 py-4">
                <div class="text-lg">
                    Buyed Stock at <b>{{ selectedPlatform.name }} : {{ form.exchange }}</b>
                </div>
                
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <cInput type="date" v-model="form.date" required label="Date"></cInput>
         

                    <c-select 
                            label="Select stock"
                            required
                            :options="stocks" 
                            queryData 
                            v-model="form.stock_id"
                    ></c-select>
 
                     <cInput type="number" v-model="form.quantity" required label="Quantity"></cInput>
                     <cInput type="number" v-model="form.rate" required label="Rate"></cInput>
                     
                </div>
            </div>
            
            <div class="flex flex-row justify-between px-6 py-4 gap-4 bg-gray-100 text-right">
                <div>
                    price: {{ form.rate * form.quantity }}
                </div>
                <div class="rightside  gap-4 flex">

                    <simple-button type="submit" :disabled="form.processing" >Add</simple-button> 
                    <simple-button class="bg-red-600" @click.prevent="close"  >Cancel</simple-button>
                </div>
            </div>
        </form>
    </Modal>
</template> 