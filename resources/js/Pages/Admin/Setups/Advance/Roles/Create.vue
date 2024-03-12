<template>
    <admin-layout :breadcrums="breadcrums" title="Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent="submitData">
                    <div  class="border-b-4 mb-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4 ">
                            <c-input  type="text" class="" label="Name" required v-model="form.name" :errmsg="form.errors.name" ></c-input>
                            <c-input type="text" class="col-span-2" label="Description" required v-model="form.description" :errmsg="form.errors.description" ></c-input>

                        </div>
                    </div>

                    <div class="text-xl uppercase  mb-4 mt-4">
                         <label class="flex items-center">Permissions &nbsp;
                                <!-- <input @change="allPermissions(event)" type="checkbox"  value="1">
                                <span class="ml-2 font-bold capitalize">All</span> -->
                            </label>
                        <div class="h-0.5 w-20 bg-gray-500 rounded"></div>
                    </div>

                    <div class="group w-full border" v-for="(permissionGroups, index) in permissions" :key="index">
                        <h2 class="capitalize mb-4 border-b-2 text-2xl font-extrabold">{{index}}</h2>
                        
                        <div class="ml-4 mb-4 flex gap-4"  >
                            
                            <div class="card border-2 border-slate-500 mb-4 rounded-lg shadow hover:shadow-lg" v-for="(modules, moudleKey) in permissionGroups" :key="moudleKey" >
                                
                                <div class="head capitalize bg-slate-500 text-white rounded-t-lg p-2 mb-2 font-semibold">{{ moudleKey }}</div>

                                <div class="Body p-2 " >
                                    <div class="flex gap-4 flex-wrap" >
                                        <!-- text-white bg-indigo-500  -->
                                        <label class="flex border-2 rounded-full border-indigo-500 bg-white text-indigo-500 items-center px-2 py-1  mb-2 cursor-pointer hover:bg-indigo-500 hover:text-white" v-for="(permission, permissionkey) in modules" :key="permissionkey">
                                            <input type="checkbox" :id="'permission' + permission.id" :value="permission.id" v-model="form.permissions">
                                                <span class="ml-2 font-bold capitalize">{{ permission.name.replace(moudleKey, '') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                        
                        <!-- <div class="border-b-4" v-for="(permissionGroups, index) in permissions" :key="index" >
                            <h2 class="capitalize font-semibold border-b-1 ">{{ index }}</h2>
                            <div class=" grid grid-cols-6  text-xs gap-4 mb-4  " >
                                <div class="card border rounded shadow-lg" v-for="(modules, moudleKey) in permissionGroups" :key="moudleKey">
                                    <div class="header">{{ moduleKey }}</div>
                                    <div class="Body">
                                        <label class="flex text-white bg-indigo-500 items-center p-2" v-for="(permission, permissionkey) in modules" :key="permissionkey">
                                            <input type="checkbox" :id="'permission' + permission.id" :value="permission.id" v-model="form.permissions">
                                            <span class="ml-2 font-bold capitalize">{{ permission.name }}</span>
                                        </label>
                                    </div>
                                </div>
                               
                            </div>
                        </div> -->

                    <div class="mb-4">
                        <simple-button >Save</simple-button>
                    </div>
                </form>
            </div>
        </div>

    </admin-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { useForm } from '@inertiajs/vue3'
    import AdminLayout from '@/Layouts/Admin/Layout.vue';
    import SimpleButton from '@/Shared/Components/Form/Simple/Button.vue'
    import cInput from '@/Shared/Components/Form/Controls/Input.vue'
    import cCheck from '@/Shared/Components/Form/Controls/Checkbox.vue'

    export default defineComponent({
        components: {
            AdminLayout,
            SimpleButton,
            cInput,
            cCheck
        },
        props: ['role', 'permissions'],
         data: () => ({
            edit: false,
            breadcrums: []
         }),
        setup () {
            const form = useForm({
                name: null,
                description:null,
                permissions: []
            })

            function submitData(){
                if(form.processing){ 
                    return '';
                }
                if (this.role) {
                    form.put(route('admin.roles.update', this.role.id));
                }else{
                    form.post(route('admin.roles.store'));
                }
            }

            return { form, submitData  }
        },

        created(){
            if (this.role) {
                this.form.name = this.role.name;
                this.form.description = this.role.description;
                this.role.permissions.forEach(permissions =>{
                    this.form.permissions.push(permissions.id);
                });
                this.edit = true;
                this.breadcrums = [ { route: 'admin.roles.index', name: 'Roles'}, { name:'edit'} ];

            }else{ ;
                this.breadcrums = [ { route: 'admin.roles.index', name: 'Roles'}, {route: 'admin.roles.create', name:'Add'} ];
            }
        },
        methods: {

        }

    })
</script>
