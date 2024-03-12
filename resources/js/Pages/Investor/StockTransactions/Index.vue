<script setup>
    import AppLayout from '@/Layouts/Investor/Layout.vue';
    import Pagination from '@/Shared/Components/Pagination/Simple.vue'
    import TableActions from '@/Shared/Components/Tables/Partials/TableActions.vue';
    import THeader from '@/Shared/Components/Tables/Partials/TableHeader.vue'
    import { onMounted, ref } from 'vue';

defineProps({
    stockTransactions: {type: Object}
});
const breadcrums = [ {name: 'Transactions' , route: 'investors.stockTransactions.index'} ];
const table_actions = [ 
    { type:'edit', route: 'investors.stockTransactions.edit', key: 'id' },
    { type:'delete', route: 'investors.stockTransactions.destory', key: 'id' },
];

const actionsLinks = [ 
    {title: 'Add', route: 'investors.stockTransactions.create', icon: 'add', color:'red', bg:'green'}
];

</script>

<template>
    <app-layout title="Stock Transactions" :breadcrums="breadcrums" :actionsLinks="actionsLinks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Stock Transactions History
            </h2>
        </template>

            <div class="py-2">
                <div class="bg-white overflow-hidden shadow-lg p-2 sm:rounded-lg">
                    <table class="table-auto min-w-full divide-y divide-gray-200">

                        <t-header :tableHeads="['#', 'Date', 'Stock',  'Quantity', 'Rate', 'Price',  'Note' ,'Action' ]" />
                        <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-500">
                            <tr v-for="(transaction, index ) in  stockTransactions.data" :key="transaction.id">
                                <td class="py-2">{{ stockTransactions.from + index }}</td>
                                <td class="py-2">{{ transaction.date }}</td>
                                <td class="py-2">
                                    <div class="capitalize mb-1 text-gray-800">{{ transaction.stock.name }}</div>
                                </td>
                                <td class="py-2">{{ transaction.quantity }}</td>
                                <td class="py-2">{{ transaction.rate }}</td>
                                <td class="py-2">{{ transaction.price }}</td>
                                <td class="py-2">{{ transaction.note }}</td> 
                                <td  class="whitespace-nowrap py-2 flex justify-end text-right  font-medium">
                                    <table-actions :actions="table_actions" :data="transaction" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :pageData="stockTransactions" pageof=" Transactions" />
                </div>
            </div>
    </app-layout>
</template>
