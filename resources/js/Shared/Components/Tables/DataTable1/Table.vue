<template>
	<table class="table-auto min-w-full divide-y divide-gray-200">
        <t-header :tableHeads="theaders" />

      	<tbody class="bg-white divide-y divide-gray-200 text-xs text-gray-500">
            <tr v-if="trdata.data && trdata.data.length > 0" v-for="(tr, index ) in  trdata.data" :key="index">
                <td class="px-1" v-for="td in tdkeys">
                    <span v-if="td == 'active'">
                        <span v-if="tr[td]" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                          Active
                        </span>
                        <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                          in-Active
                        </span>
                    </span>
                    <span v-else-if="td == '#'">{{ trdata.from + index }}
                    </span>
                    <span v-else >{{ tr[td] }}</span>
                </td>
                <td v-if="actions" class="whitespace-nowrap  flex justify-end text-right  font-medium">
                    <table-actions :actions="actions" :data="tr" />
                </td>
            </tr>
      		<slot v-else ></slot>
      	</tbody>
    </table>
    <Pagination v-if="pageof" :pageData="trdata" :pageof="pageof" />

</template>


<script>
    import icon from '@/Shared/Components/Icons/svg/Plus.vue'
    import { Link } from '@inertiajs/vue3';
    import TableActions from '@/Shared/Components/Tables/Partials/TableActions.vue';
    import Pagination from '@/Shared/Components/Pagination/Simple.vue'
    import Ttd from '@/Shared/Components/Tables/DataTable1/Tabletd.vue'
    import THeader from '@/Shared/Components/Tables/Partials/TableHeader.vue'
    export default{
        components:{Link,icon, Ttd, TableActions ,Pagination, THeader},
        props: {
        	theaders: {type : Array, default: null},
            trdata: {type: Object, default: null},
            tdkeys : {type: Array, default: null},
            actions: {type: Array, default: null},
            pageof: {type: String, default: null}
        },
        /*data: () => ({
        }),
        created(){
        },
        methods:{

        }*/
    }
</script>