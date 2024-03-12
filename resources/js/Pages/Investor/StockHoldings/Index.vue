<script setup>
import AppLayout from '@/Layouts/Investor/Layout.vue';
import AddStockBrocker from '@/Components/Investors/AddStockBrockers.vue';
import { ref } from 'vue';

const showBrockerModal = ref(false);

</script>

<template>
    <AppLayout title="Holdings">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Stock Holdings 
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <section title="Add brokers w-100" class="p-4">
                        <label class="font-bold">Add your Brockers: </label> 
                        <button class="px-2 py-1 bg-black text-white rounded" @click="showBrockerModal = true">Manage Stock brockers</button>
                    </section>

                    <section title="holdings"
                        class=" text-black p-4"
                    >no stocks purchased yet</section>
                    
                    <section title="transactions"></section>
                    <section title="profit adn loss"></section>
                </div>
            </div>
        </div> 

        <add-stock-brocker :show="showBrockerModal" @close="showBrockerModal = false"></add-stock-brocker>
    </AppLayout>
</template>
