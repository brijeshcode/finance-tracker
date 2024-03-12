<template>
    <!--
        Todo: we have to handle different behaviour which we needed, like:
        1. button with custom action
        2. link with route or link with url
        3. a with route or a with url

        parameters required
            type: link, a , button;
            src: route, url, onClick;
            text or title;
            icon: export, edit, setting, add,

     -->
	<div class="inline-flex rounded-md shadow-sm" role="group">
        <span v-for="(action, index) in validActions" :key="index" class=" cursor-pointer inline-flex items-center text-xs font-medium text-gray-900 bg-white first:rounded-l-lg last:rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
            <span v-if="allowed(action)">
                <a v-if="action.type == 'a'" class="inline-flex items-center py-2 px-4 " :target="action.target ? action.target : '' " :href="getUrl(action)">
                    <span v-if="action.icon" v-html="icons[action.icon]" class="mr-2"></span>
                    {{ action.title }}
                </a>
                <!-- <button v-else-if="action.type == 'button'" @click="action.btnaction" class="inline-flex items-center" type="button"> -->
                <button v-else-if="action.type == 'button'" @click="buttonClicked(action.src)" @action.src="bbb" class="inline-flex items-center px-4 " type="button">
                    <span v-if="action.icon" v-html="icons[action.icon]" class="mr-2"></span>
                    {{ action.title }}
                </button>
                <Link v-else class="inline-flex items-center py-2 px-4 " :href="getUrl(action)" >
                    <span v-if="action.icon" v-html="icons[action.icon]" class="mr-2"></span>
                    <!-- <span v-if="action.icon && action.icon == 'setting'" v-html="icons.setting" class=""></span> -->
                    <span>{{ action.title }}</span>
                </Link>
            </span>
        </span>
	</div>
</template>


<script>
    import { usePage} from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3';
    export default{
        components: {
            Link
        },
        props: {
            actions: Array
        },
        data: () => ({
            validActions: [],
            icons: {

                add: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 fill-current" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>',
                export: '<svg aria-hidden="true" class="w-4 h-4 fill-current" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd"></path></svg>',
                edit: '<svg class="w-4 h-4"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg>',
                setting: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 fill-current" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 10.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1H3V1.5a.5.5 0 0 0-1 0V10H.5a.5.5 0 0 0-.5.5ZM2.5 12a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-2a.5.5 0 0 0-.5-.5Zm3-6.5A.5.5 0 0 0 6 6h1.5v8.5a.5.5 0 0 0 1 0V6H10a.5.5 0 0 0 0-1H6a.5.5 0 0 0-.5.5ZM8 1a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-2A.5.5 0 0 0 8 1Zm3 9.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1H14V1.5a.5.5 0 0 0-1 0V10h-1.5a.5.5 0 0 0-.5.5Zm2.5 1.5a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-2a.5.5 0 0 0-.5-.5Z"/></svg>',
                trash: '<svg class="h-4 w-4 "  fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>',
                refresh: '<svg class="h-4 w-4 "  fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>'
            },

        }),
        created(){
            if (this.actions) {
                this.validActions = this.actions.filter(action => this.allowed(action));
            }
            /*this.actionLinks = [
              {type:'link', title:'New Sales', route: 'sales.create', icon: 'add'},
              {type:'link', title: 'Edit', url: route('sales.edit', this.sale.id), icon: 'edit'},
            ]*/
        },
        methods: {
            getUrl(action){
                return action.url ? action.url : action.with_parameters ?  route(action.route, route().params) : route(action.route);
            },
            buttonClicked(actions){
                this.$emit(actions);
            },
            allowed(action){
                if (action.permission) {
                    return this.$user.can(action.permission)
                }
                return true;
            }

        }
    };
</script>