<script setup>
    import {onBeforeMount,watch, onUpdated, ref, computed } from 'vue';
    import { useForm } from '@inertiajs/vue3'
    import cSelect from '@/Shared/Components/Form/Controls/Select.vue'
    import Modal from '@/Components/Modal.vue';
    import cInput from '@/Shared/Components/Form/Controls/Input.vue'
    import SimpleButton from '@/Shared/Components/Form/Simple/Button.vue'


    const props = defineProps({
        show: {type: Boolean, default: false},
        maxSellQuantity: {type: Number, default:0},
        selectedPlatform: {type: Object},
        selectedStockId: {type: Number , default: null}
    });

    const userStockQuantity = ref(0);
    const stocks = ref([]);
    // const maxSellQuantity = ref(0);

    const form = useForm({
        date : new Date().toISOString().substr(0, 10), 
        platform_id: null,
        stock_id: null, 
        exchange: 'nse', 
        quantity: 0,
        rate: 0, 
        price: 0, 
        is_buy: false, 
        transaciton_charge: 0, 
        note: null
    })

    function submit() { 
        form.price = form.rate * form.quantity;

        form.post(route('investors.stocks.sell'), {
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
        
        if(props.selectedStockId){
            form.stock_id = props.selectedStockId;
        }

        // getQuantity();
    });

    function getStocks(){
        fetch(route('api.investors.stocks'))
        .then(response => response.json())
        .then(stockData => { stocks.value = stockData;});
    }

    /* function getQuantity(){
        fetch(route('api.investors.get_user_quantity', { platformId: props.selectedPlatform.id, stockId: props.selectedStockId }))
        .then(response => response.json())
        .then(stockData => { userStockQuantity.value = stockData;}); 
    } */

    /* watch(userStockQuantity, (val) => {
        maxSellQuantity.value = val.reduce((total, quantity) => parseInt(total) + parseInt(quantity.quantity), 0);
    });  */

    const stock = computed(() => {
        let stock = stocks.value.filter(stock => stock.id == props.selectedStockId);
        if(stock.length > 0) {
            return stock[0];
        }
        return null;
    });


</script>

<template>
    <Modal :show="show" max-width="2xl">
        <form @submit.prevent="submit"> 
            <div class="px-6 py-4">
                <div class="text-lg flex justify-between">
                    <span>Selling at <span class="capitalize  ">{{ selectedPlatform.name }}</span> on <span class="bg-gray-300 text-sm px-2 py-1 rounded shadow font-bold uppercase">{{ form.exchange }}</span></span>
                    <span><b>{{ stock.name }}</b> | Qty: {{ maxSellQuantity }} </span>
                </div>
                
                <div class="mt-4 grid grid-cols-3 gap-4">
                    <cInput type="date" v-model="form.date" required label="Date"></cInput>
 
                    <cInput type="number" min="0" v-model="form.quantity" required label="Quantity"></cInput>
                    <cInput type="number" step="0.01" v-model="form.rate" required label="Rate"></cInput>
                     
                </div>
            </div>
            
            <div class="flex flex-row justify-between px-6 py-4 gap-4 bg-gray-100 text-right">
                <div>
                    Price: {{ form.rate * form.quantity }}
                </div>
                <div class="rightside  gap-4 flex">

                    <simple-button type="submit" :disabled="form.processing" >Add</simple-button> 
                    <simple-button class="bg-red-600" @click.prevent="close"  >Cancel</simple-button>
                </div>
            </div>
        </form>
    </Modal>
</template> 