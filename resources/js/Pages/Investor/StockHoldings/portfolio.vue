<script setup>
import AppLayout from '@/Layouts/Investor/Layout.vue';
import { reactive, ref } from 'vue';

const props = defineProps({
    portfolio: {type: Array, default: [] } ,
    totalInvesteValue: {type:Number, default: 0},
    stockCount: {default: 0},
});
  </script>
<template>
    <AppLayout title="Holdings">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Portfolio
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    

                    <section title="holdings"  class=" text-black p-4 w-full"  > 
                        <div class="brockes mt-4  gap-4">
                            Total Invested Value: {{ totalInvesteValue }} | Total Stocks Purchased: {{ stockCount }}
                            <div   class="p-2 bg-gray-50 rounded border shadow-sm">
                                <table   class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" >
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <th>Stock</th>
                                        <th>Qty.</th>
                                        <th>Avg. Rate</th>
                                        <th>Value</th> 
                                        <th>Act.</th> 
                                    </thead>
                                    <tbody >
                                        <tr v-for="stock in portfolio" :key="stock" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <td >{{ stock.stock.name }}</td>
                                            <td>{{ stock.quantity }}</td>
                                            <td>{{ stock.running_avg_rate }}</td>
                                            <td>{{ stock.invested_value }}</td>
                                            <td>
                                                <span   >B</span> | S | D | T</td>
                                        </tr>
                                    </tbody>
                                </table>
                                 
                            </div>
                        </div>
                    </section>
                     
                </div>
            </div>
        </div>  
    </AppLayout>
</template>
