<script setup>
import AppLayout from '@/Layouts/Investor/Layout.vue';
import AddStockBrocker from '@/Components/Investors/AddStockBrockers.vue';
import AddStock from '@/Components/Investors/AddStockTransaction.vue';
import SellStock from '@/Components/Investors/SellStockModel.vue';
import { reactive, ref } from 'vue';

const props = defineProps({
    investorPlatforms: {type: Array, default: [] },
    holdings: {type: Object, default: {} }
});

const showBrockerModal = ref(false);
const showAddStock = ref(false);
const showSellStock = ref(false);
const selectedStockQuantity = ref(0);
const selectedPlatform = ref(null);
const selectedStockId = ref(null);
// const selectedPlatform = ref({ id: 3, name: 'zerodha'});


const popAddStockModel = (platform, stock_id = null) => {

    selectedPlatform.value = platform; 
    selectedStockId.value = stock_id; 
    showAddStock.value = true;
}

const popShowSellStock = (platform, stock_id = null, quantity = 0) => {
    selectedPlatform.value = platform; 
    selectedStockId.value = stock_id; 
    selectedStockQuantity.value = quantity;
    showSellStock.value = true;
}

</script>

<template>
    <AppLayout title="Holdings">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Holdings
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <section title="Add brokers w-100" class="p-4">
                        <label class="font-bold">Add your Brokers: </label> 
                        <button class="px-2 py-1 bg-black text-white rounded" @click="showBrockerModal = true">Manage Stock brokers</button>
                    </section>

                    <section title="holdings"
                        class=" text-black p-4 w-full"
                    > 
                        <div class="brockes mt-4 grid grid-cols-2 gap-4">
                            <div v-for="broker in investorPlatforms" :key="broker.id" class="p-2 bg-gray-50 rounded border shadow-sm">
                                <div class="font-bold capitalize py-2 border-b flex justify-between"> 
                                    {{ broker.platform.name }}
                                    <button type="button" class="px-2 py-1 bg-black rounded text-white" @click="popAddStockModel(broker.platform)" >Add +</button>
                                </div>
                                
                                <table v-if="holdings[broker.platform.id]" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" >
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <th>Stock</th>
                                        <th>Qty.</th>
                                        <th>Avg. Rate</th>
                                        <th>Value</th>
                                        <th>Act.</th>
                                    </thead>
                                    <tbody >
                                        <tr v-for="stock in holdings[broker.platform.id]" :key="stock" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <td >{{ stock.stock.symbol }}</td>
                                            <td>{{ stock.quantity }}</td>
                                            <td>{{ stock.average_price }}</td>
                                            <td>{{ stock.quantity * stock.average_price }}</td>
                                            <td>
                                                <span  @click="popAddStockModel(broker.platform, stock.stock_id)" class="cursor-pointer" >B</span> | 
                                                <span  @click="popShowSellStock(broker.platform, stock.stock_id, stock.quantity)" class="cursor-pointer" >S</span> |
                                                D | 
                                                T
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-center p-4" v-else>
                                    Add your first investment
                                </div> 
                            </div>
                        </div>
                    </section>
                    
                    <section title="transactions"></section>
                    <section title="profit adn loss"></section>
                </div>
            </div>
        </div> 

        <add-stock-brocker :show="showBrockerModal" @close="showBrockerModal = false"></add-stock-brocker>
        <Add-Stock :show="showAddStock" :selectedPlatform="selectedPlatform" :selectedStockId="selectedStockId" @close="showAddStock = false"></Add-Stock>
        <sell-stock :show="showSellStock" :selectedPlatform="selectedPlatform" :selectedStockId="selectedStockId" :maxSellQuantity="selectedStockQuantity" @close="showSellStock = false"></sell-stock>
    </AppLayout>
</template>
