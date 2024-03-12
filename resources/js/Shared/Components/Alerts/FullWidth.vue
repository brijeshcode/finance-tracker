<template>
	<div v-show="show" class="w-full text-white transition delay-100 " :class="class">
        <div class="container flex items-center justify-between px-6 py-4 mx-auto">
            <div class="flex">
                <tick v-if="type === 'success'" />
                <bolt v-else-if="type === 'error'" />
                <Notify v-else-if="type === 'info'" />
                <alert v-else-if="type === 'warning'" />
                <alert v-else />

                <p class="mx-3">{{ message }}</p>
            </div>

            <button class="p-1 transition-colors duration-200 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none" @click="hideme">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
</template>


<script>
    import Tick from '@/Shared/Components/Icons/svg/Tick.vue'
    import Bolt from '@/Shared/Components/Icons/svg/Bolt.vue'
    import Alert from '@/Shared/Components/Icons/svg/Alert.vue'
    import Notify from '@/Shared/Components/Icons/svg/Notify.vue'
    // import Tick from '@/Shared/Components/Icons/svg/Tick.vue'

    export default{
        components:{Tick,Alert,Bolt,Notify},
        props: { message:String , type: String},
        data: () => ({
            class: '',
            show: false,
         }),
        created(){
            this.show = true;
            let disapperaIn = 2500;

        	if (this.type.toLowerCase() === 'success') {
        		this.class = 'bg-emerald-500';
        	}else if (this.type.toLowerCase() === 'info' || this.type.toLowerCase() === 'primary') {
        		this.class = 'bg-blue-500';
                disapperaIn = 10000;
        	}else if (this.type.toLowerCase() === 'warning') {
        		this.class = 'bg-yellow-500 text-gray-800';
                disapperaIn = 8000;
        	}else if (this.type.toLowerCase() === 'error' || this.type.toLowerCase() === 'danger') {
                disapperaIn = 15000;
        		this.class = 'bg-red-500';
        	}else{
        		this.class = 'bg-gray-500';
        	}
            this.show = true;

            if (this.type.toLowerCase() !== 'error' && this.type.toLowerCase() !== 'danger') {
                setTimeout(() => this.show = false, disapperaIn);
            }
            // setTimeout(() => this.class = 'hidden', 1000)
        },
        methods:{
            hideme(){ this.show = false; }
        }
    };
</script>