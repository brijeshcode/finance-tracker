<template>
    <admin-layout :breadcrums="breadcrums" title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent="submitData">
                    <div  class="border-b-4 mb-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4 ">
                            <c-input  type="text"  label="Name" required v-model="form.name" :errmsg="form.errors.name" ></c-input>
                            <c-input  type="email"  label="Email" required v-model="form.email" :errmsg="form.errors.email" ></c-input>
                            <c-input  type="text"  label="Mobile" required v-model="form.mobile" :errmsg="form.errors.mobile" ></c-input>
                            <c-input  type="password"  label="New Password" :required="!edit" v-model="form.password" :errmsg="form.errors.password" ></c-input>
                            <c-select required label="Role" v-model="form.role"  queryData  :options="roles"></c-select>

                            <c-area label="Note" class="col" v-model="form.note" rows="3" ></c-area>
                            <c-check label="Active" v-model:checked="form.active" ></c-check>


                        </div>
                    </div>


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
    import cSelect from '@/Shared/Components/Form/Controls/Select.vue'
    import cCheck from '@/Shared/Components/Form/Controls/Checkbox.vue'

    export default defineComponent({
        components: {
            AdminLayout,
            SimpleButton,
            cInput,
            cSelect,
            cCheck
        },
        props: ['editUser', 'roles', 'permissions'],
         data: () => ({
            edit: false,
            breadcrums: []
         }),
        setup () {
            const form = useForm({
                name: null,
                email: null,
                mobile: null,
                password: '',
                note: '',
                role: '1',
                active: false
            })

            function submitData(){
                if(form.processing){ 
                    return '';
                }
                if (this.editUser) {
                    form.put(route('admin.users.update', this.editUser.id));
                }else{
                    form.post(route('admin.users.store'));
                }
            }

            return { form, submitData  }
        },

        created(){
            if (this.editUser) {
                Object.keys(this.editUser).forEach(key => {
                    this.form[key] = this.editUser[key];
                });
                this.form.role = this.editUser.roles[0].id;
                this.edit = true;
                this.breadcrums = [ { route: 'admin.users.index', name: 'Users'}, { name:'edit'} ];

            }else{ 
                this.breadcrums = [ { route: 'admin.users.index', name: 'Users'}, {route: 'admin.users.create', name:'Add'} ];
            }
        },
        methods: {

        }

    })
</script>
