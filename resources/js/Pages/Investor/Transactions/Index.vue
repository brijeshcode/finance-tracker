<script setup>
import AppLayout from '@/Layouts/Investor/Layout.vue';
import { ref } from 'vue'
import { useForm , router, Link} from '@inertiajs/vue3'
import Pagination from '@/Shared/Components/Pagination/Simple.vue'
import TableActions from '@/Shared/Components/Tables/Partials/TableActions.vue';
import THeader from '@/Shared/Components/Tables/Partials/TableHeader.vue'

defineProps({
    transactions: {type: Object}
});
const breadcrums = ref([ {name: 'Transactions' , route: 'investors.transactions.index'} ]);
const table_actions = ref([ 
    { type:'edit', route: 'investors.transactions.edit', key: 'id' },
    { type:'delete', route: 'investors.transactions.destory', key: 'id' },
]);

const actionsLinks = ref([ 
    {title: 'Add', route: 'investors.transactions.create', icon: 'add', color:'red', bg:'green'}
]);

</script>

<template>``
    <app-layout title="Transactions" :breadcrums="breadcrums" :actionsLinks="actionsLinks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Investment Transactions
            </h2>
        </template>

          <div class="py-2">
                <div class="bg-white overflow-hidden shadow-lg p-2 sm:rounded-lg">
                    <table class="table-auto min-w-full divide-y divide-gray-200">
                        <!-- <t-header :tableHeads="['#', 'name', 'address', 'mobile', 'Id number', 'Profession', 'email', 'prof. address', 'financial stats', 'Origin Fund Operation', 'Banks Dealing With', 'Annual Income', 'Note', 'Status', 'created date', 'last updated date' ,'Action' ]" /> -->

                        <t-header :tableHeads="['#', 'name',  'Contact', 'Id number', 'Banks',  'Note', 'Status', 'created', 'updated' ,'Action' ]" />
                        <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-500">
                            <tr v-for="(client, index ) in  transactions.data" :key="client.id">
                                <td class="py-2">{{ transactions.from + index }}</td>
                                <td class="py-2">
                                    <div class="capitalize mb-1 text-gray-800">{{ client.name }}</div>
                                    <p class="text-gray-600 text-xs">{{ client.profession }}</p>
                                </td>
                                <td class="py-2">{{ client.mobile }} <p>{{ client.email }}</p></td>
                                <td class="py-2">{{ client.id_number }}</td>
                                <td class="py-2">{{ client.bank }}</td>
                                <td class="py-2">{{ client.note }}</td>
                                <td class="py-2">
                                    <span v-if="client.active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        in-Active
                                    </span>
                                </td>
                                <td class="py-2">
                                    <p class="text-gray-700 font-semibold">{{ client.created_by.name }}</p>
                                    {{ client.created_at }}
                                </td>
                                <td class="py-2">
                                    <p class="text-gray-700 font-semibold" v-if="client.updated_by">{{ client.updated_by.name }}</p>
                                    {{ client.updated_at }}
                                </td>
                                <td  class="whitespace-nowrap py-2 flex justify-end text-right  font-medium">
                                    <table-actions :actions="table_actions" :data="client" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :pageData="transactions" pageof=" Transactions" />
                </div>
        </div>
    </app-layout>
</template>
