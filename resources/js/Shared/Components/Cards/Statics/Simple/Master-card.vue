<template>
    <div class="w-full">
        <div class="widget w-full p-2 rounded-lg shadow-md bg-white border-l-4" :class="border">
            <div class="flex items-center">
                <div class="icon w-14 p-3.5 text-white rounded-full mr-3" :class="bg">
                    <span v-html="icon"></span>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="text-lg">{{ number.toFixed(2) * 1 }}</div>
                    <div class="text-xs text-gray-400">{{ label }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import icon from '@/Shared/Components/Icons/svg/Truck.vue'
    import { Link } from '@inertiajs/vue3';
    export default{
        components:{Link },
        props: {
            order: Object,
            iconType: {type: String , default: ''},
            label: {type: [String, Number], default: ''},
            number: {type: [String, Number], default: ''},
            color: {type: String, default: 'blue'}
        },
        data: () => ({
            edit: false,
            border: '',
            bg: '',
            icon: '',
            colors: ['blue', 'red'],
            icons: {
            	users : '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>',
            	product: '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>',
            	dollar: '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                cart: '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',
                graphup: '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
                due: '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
            }
        }),
        created(){
        	this.border = 'border-'+this.color+'-400' ;
        	this.bg = 'bg-'+this.color+'-400' ;
        	this.icon = this.icons[this.iconType];
        }
    }
</script>