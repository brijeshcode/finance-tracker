<script setup>
import AppLayout from '@/Layouts/Investor/Layout.vue';
import { reactive, ref } from 'vue';

const props = defineProps({
    portfolio: {type: Array, default: [] } ,
    totalInvesteValue: {type:Number, default: 0},
    companies: {default: 0},
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
                            Invested: <span class="font-bold text-xl">{{ totalInvesteValue }}</span>| Realized Profit: 0 | Invested Companies: {{ companies }}
                            <div   class="p-2 bg-gray-50 rounded border shadow-sm">
                                <table   class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" >
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <th>Stock</th>
                                        <th>Qty.</th>
                                        <th>Avg. Rate</th>
                                        <th>Invested</th> 
                                        <th>Act.</th> 
                                    </thead>
                                    <tbody >
                                        <tr v-for="stock in portfolio" :key="stock" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <td >{{ stock.name }}</td>
                                            <td>{{ stock.quantity }}</td>
                                            <td>{{ stock.rate }}</td>
                                            <td>{{ stock.price }}</td>
                                            <td>  Details </td>
                                            <!--  
                                            when we click on this detials it will show following 
                                                > it will show all the information related to this purchase
                                                > we can add notes in the transactions also for future reminder or study.
                                                > list of transaction including platform name
                                                > it will show age of purchase
                                                > it will show total realized profits
                                                > it will show divident detials if any ( we can show total divident earned)
                                            
                                            -->

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
