<script setup>
 
    import AdminLayout from '@/Layouts/Admin/Layout.vue';
    import Pagination from '@/Shared/Components/Pagination/Simple.vue'
    import TableActions from '@/Shared/Components/Tables/Partials/TableActions.vue';
    import THeader from '@/Shared/Components/Tables/Partials/TableHeader.vue'


    defineProps({
        mutualFunds: Object
    });
 
    const breadcrums = [ {name: 'Mutual Funds' , route: 'admin.mutualFunds.index'} ];
    const actionsLinks = [
              {title: 'Add', route: 'admin.mutualFunds.create', icon: 'add', color:'red', bg:'green'}
            ];
    
    const table_actions = [
        { type:'edit', route: 'admin.mutualFunds.edit', key: 'id'}
    ];

 

</script>

<template>
    <admin-layout title="Mutual funds" :breadcrums="breadcrums" :actionsLinks="actionsLinks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mutual funds
            </h2>
        </template>

        <div class="py-2">
            <div class="bg-white overflow-hidden shadow-lg p-2 sm:rounded-lg">
                <table class="table-auto min-w-full divide-y divide-gray-200">
                    <!-- <t-header :tableHeads="['#', 'name', 'address', 'mobile', 'Id number', 'Profession', 'email', 'prof. address', 'financial stats', 'Origin Fund Operation', 'Banks Dealing With', 'Annual Income', 'Note', 'Status', 'created date', 'last updated date' ,'Action' ]" /> -->

                    <t-header :tableHeads="['#', 'name',  'expense ratio', 'type', 'market cap',  'Note', 'Status' ,'Action' ]" />
                    <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-500">
                        <tr v-for="(mf, index ) in  mutualFunds.data" :key="mf.id">
                            <td class="py-2">{{ mutualFunds.from + index }}</td>
                            <td class="py-2">
                                <div class="capitalize mb-1 text-gray-800">{{ mf.name }}</div>
                            </td>
                            <td class="py-2">{{ mf.expense_ratio }}</td>
                            <td class="py-2">{{ mf.type }}</td>
                            <td class="py-2">{{ mf.market_cap }}</td>
                            <td class="py-2">{{ mf.note }}</td>
                            <td class="py-2">
                                <span v-if="mf.active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    in-Active
                                </span>
                            </td>
                           
                            <td  class="whitespace-nowrap py-2 flex justify-end text-right  font-medium">
                                <table-actions :actions="table_actions" :data="mf" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :pageData="mutualFunds" pageof=" Mutual funds" />
            </div>
        </div>
    </admin-layout>
</template>
