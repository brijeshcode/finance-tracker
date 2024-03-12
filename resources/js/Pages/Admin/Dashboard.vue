<script setup>
import AppLayout from '@/Layouts/Admin/Layout.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3' 
import THeader from '@/Shared/Components/Tables/Partials/TableHeader.vue'; 
import SimpleButton from '@/Shared/Components/Form/Simple/Button.vue'


const props = defineProps({
    time: String
});

const date = props.filterDate ? ref(props.filterDate) : ref(new Date().toISOString().substr(0, 10));

function filter(event) {
    router.get(route('dashboard'), {date: date.value }, {
        preserveState: true,
        replace: true
    });
}
 
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard {{  time }}  
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl overflow-x-auto mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2" >
                    Sharma
                </div>
            </div>
        </div>
    </AppLayout>
</template>
