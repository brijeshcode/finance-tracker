<template>
    <admin-layout title="Users" :breadcrums="breadcrums" :actionsLinks="actionsLinks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>



        <div class="py-2">

                <div class="bg-white overflow-hidden shadow-lg p-2 sm:rounded-lg">
                    <table class="table-auto min-w-full divide-y divide-gray-200">
                        <t-header :tableHeads="['#', 'Users', 'Mobile', 'Email', 'Role', 'Note', 'Status', 'Action' ]" />
                        <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-500">
                            <tr v-for="(user, index ) in  users.data" :key="user.id">
                                <td class="py-2">{{ users.from + index }}</td>
                                <td class="py-2">
                                    <span class="capitalize">{{ user.name }}</span>
                                </td>
                                <td class="py-2">{{ user.mobile }}</td>
                                <td class="py-2">{{ user.email }}</td>
                                <td class="py-2 capitalize"><span v-if="user.role_name">{{  user.role_name }}</span></td>
                                <td class="py-2">
                                    <span class="capitalize">{{ user.note }}</span>
                                </td>
                                <td class="py-2">
                                    <span v-if="user.active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        in-Active
                                    </span>
                                </td>
                                <td  class="whitespace-nowrap py-2 flex justify-end text-right  font-medium">
                                    <table-actions :actions="table_actions" :data="user" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :pageData="users" pageof=" Users" />
                </div>
        </div>
    </admin-layout>
</template>


<script>
    import { defineComponent } from 'vue'
    import { useForm , router, Link} from '@inertiajs/vue3'
    import AdminLayout from '@/Layouts/Admin/Layout.vue';
    import Pagination from '@/Shared/Components/Pagination/Simple.vue'
    import TableActions from '@/Shared/Components/Tables/Partials/TableActions.vue';
    import THeader from '@/Shared/Components/Tables/Partials/TableHeader.vue'

    import FilterIcon from '@/Shared/Components/Icons/svg/Filter.vue'
    import FilterPanel from '@/Shared/Components/Filters/FilterPanel.vue'
    import SimpleButton from '@/Shared/Components/Form/Simple/Button.vue'

    import cCheck from '@/Shared/Components/Form/Controls/Checkbox.vue'
    import cInput from '@/Shared/Components/Form/Controls/Input.vue'

    export default defineComponent({
        components: {
            AdminLayout,Pagination,Link, THeader, TableActions, FilterPanel,FilterIcon,SimpleButton,cInput, cCheck
        },

        props:['users'],
         data: () => ({
            edit: false,
            table_actions: [
                // { type:'show', route: 'admin.users.show', key: 'id' },
                { type:'edit', route: 'admin.users.edit', key: 'id' },
            ],
            breadcrums: [ {name: 'Users'} ],
            actionsLinks: [
              {title: 'Add', route: 'admin.users.create', icon: 'add', color:'red', bg:'green'}
            ],
            filter:{
                name: null,
                active: true
            },
         }),

         created(){
            if (route().params.filter == 1) {
              Object.keys(this.filter).forEach((key) => {this.filter[key] = route().params[key]})
              this.filter.filter = route().params.filter;
            }
         },
         methods:{
          filterData(){
            router.get(route('admin.users.index'), this.filter ,{
                  preserveState: true,
                  replace: true
              });
          }
        }
    })
</script>