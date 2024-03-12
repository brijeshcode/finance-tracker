<template>
    <admin-layout title="Roles" :breadcrums="breadcrums" :actionsLinks="actionsLinks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        </template>



        <div class="py-2">

                <div class="bg-white overflow-hidden shadow-lg p-2 sm:rounded-lg">
                    <table class="table-auto min-w-full divide-y divide-gray-200">
                        <t-header :tableHeads="['#', 'Roles', 'Description', 'Action' ]" />
                        <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-500">
                            <tr v-for="(role, index ) in  roles.data" :key="role.id">
                                <td class="py-2">{{ roles.from + index }}</td>
                                <td class="py-2">
                                    <span class="capitalize">{{ role.name }}</span>
                                </td>
                                <td class="py-2">
                                    <span class="capitalize">{{ role.description }}</span>
                                </td>

                                <td  class="whitespace-nowrap py-2 flex justify-end text-right  font-medium">
                                    <table-actions :actions="table_actions" :data="role" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :pageData="roles" pageof=" Roles" />
                </div>
        </div>
    </admin-layout>
</template>


<script>
    import { defineComponent } from 'vue'
    import { Link, useForm , router } from '@inertiajs/vue3';
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

        props:['roles'],
         data: () => ({
            edit: false,
            table_actions: [
                // { type:'show', route: 'admin.roles.show', key: 'id' },
                { type:'edit', route: 'admin.roles.edit', key: 'id' },
            ],
            breadcrums: [ {name: 'Roles'} ],
            actionsLinks: [
              {title: 'Add', route: 'admin.roles.create', icon: 'add', color:'red', bg:'green'},
              {title: 'Check new Permissions', route: 'admin.updatePermissions', icon: 'refresh', color:'red', bg:'green'}
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
            Inertia.get(route('admin.roles.index'), this.filter ,{
                  preserveState: true,
                  replace: true
              });
          }
        }
    })
</script>