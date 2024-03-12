<script setup>
 
    import AdminLayout from '@/Layouts/Admin/Layout.vue';
    import Pagination from '@/Shared/Components/Pagination/Simple.vue'
    import TableActions from '@/Shared/Components/Tables/Partials/TableActions.vue';
    import THeader from '@/Shared/Components/Tables/Partials/TableHeader.vue'
    import { onMounted, ref } from 'vue';


    defineProps({
        stocks: Object
    });

    const edit = ref(false);
    const breadcrums = [ {name: 'Stocks' , route: 'admin.stocks.index'} ];
    const actionsLinks = [
              {title: 'Add', route: 'admin.stocks.create', icon: 'add', color:'red', bg:'green'}
            ];
    
    const table_actions = [
        { type:'edit', route: 'admin.stocks.edit', key: 'id'}
    ];

    onMounted(() => {
        if (route().params.filter == 1) {
            Object.keys(this.filter).forEach((key) => {this.filter[key] = route().params[key]})
            this.filter.filter = route().params.filter;
        }
    });
</script>

<template>
    <admin-layout title="Stocks" :breadcrums="breadcrums" :actionsLinks="actionsLinks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Stocks
            </h2>
        </template>

        <div class="py-2">
            <div class="bg-white overflow-hidden shadow-lg p-2 sm:rounded-lg">
                <table class="table-auto min-w-full divide-y divide-gray-200">
                    <!-- <t-header :tableHeads="['#', 'name', 'address', 'mobile', 'Id number', 'Profession', 'email', 'prof. address', 'financial stats', 'Origin Fund Operation', 'Banks Dealing With', 'Annual Income', 'Note', 'Status', 'created date', 'last updated date' ,'Action' ]" /> -->

                    <t-header :tableHeads="['#', 'name',  'Symbol', 'Nse', 'Bse',  'Note', 'Status' ,'Action' ]" />
                    <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-500">
                        <tr v-for="(stock, index ) in  stocks.data" :key="stock.id">
                            <td class="py-2">{{ stocks.from + index }}</td>
                            <td class="py-2">
                                <div class="capitalize mb-1 text-gray-800">{{ stock.name }}</div>
                            </td>
                            <td class="py-2">{{ stock.symbol }}</td>
                            <td class="py-2">{{ stock.nse_code }}</td>
                            <td class="py-2">{{ stock.bse_code }}</td>
                            <td class="py-2">{{ stock.note }}</td>
                            <td class="py-2">
                                <span v-if="stock.active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    in-Active
                                </span>
                            </td>
                           
                            <td  class="whitespace-nowrap py-2 flex justify-end text-right  font-medium">
                                <table-actions :actions="table_actions" :data="stock" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :pageData="stocks" pageof=" Stocks" />
            </div>
        </div>
    </admin-layout>
</template>
