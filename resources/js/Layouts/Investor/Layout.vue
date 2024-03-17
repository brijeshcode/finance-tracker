<script setup>
import { ref,computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
import GroupActionLink from '@/Shared/Components/Buttons/ButtonGroup/ActionLinks.vue'
import Alerts from '@/Shared/Components/Alerts/FullWidth.vue'
import PageTabs from '@/Shared/Layouts/PageTabs.vue'

defineProps({
    title: String,
    tabs: Array,
    actionsLinks: Array,
    breadcrums: Array
});

const showingNavigationDropdown = ref(false);

const menuItems = ref([
    {
        title: 'Dashboard' , permission: '' , role: '', route: 'dashboard', active_routes: ['dashboard'],
    },
    {
        title: 'Stocks' , permission: '', role: '',
        subMenu:[
            { title:'Portfolio', route: 'investors.stocks.portfolio', permission: '' },
            { title:'Holdings', route: 'investors.stocks.holdings', permission: '' },
            // { title:'Add Transactions', route: 'investors.stockTransactions.create', permission: '' },
            { title:'Transactions', route: 'investors.stockTransactions.index', permission: '' }
        ]
    } 
]);  
const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 dark:bg-slate-700">
            <nav class="bg-white border-b border-gray-100 dark:bg-slate-600 dark:text-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-4 sm:-my-px sm:ml-10 sm:flex">
                               <template  v-for="(menu,index) in menuItems" :key="index">
                                    <div 
                                    v-if="menu.subMenu && (menu.permission == '' || $user.can(menu.permission))"
                                        class="inline-flex items-center pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-50 dark:hover:text-gray-100 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition"
                                        >
                                        <Dropdown  align="left" width="48">
                                            <template #trigger>

                                                <span   class="inline-flex rounded-md">
                                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-300 dark:hover:text-gray-100 hover:text-gray-700 focus:outline-none transition">
                                                        <span>{{ menu.title }}</span>
                                                    </button>
                                                </span>
                                            </template>

                                            <template #content>
                                                <!-- Account Management -->
                                                <template v-for="(item, index) in menu.subMenu" :key="index" >

                                                    <div v-if="item.permission == '' || $user.can(item.permission)">
                                                        <div v-if="item.divide" class="block px-4 py-2 text-xs text-gray-400">
                                                            {{ item.title}}
                                                        </div>
                                                        <DropdownLink v-else  :href="item.url ? item.url : route(item.route)" class="capitalize"
                                                        >
                                                            {{ item.title }}
                                                        </DropdownLink>
                                                    </div>
                                                    
                                                </template>
                                            </template>
                                        </Dropdown>
                                    </div>

                                    <template v-else>
                                        <NavLink 
                                        class="dark:text-gray-300 dark:hover:text-gray-100"
                                        :href="menu.url ? menu.url : route(menu.route)" 
                                        :active="route().current(menu.route) "
                                        v-if="menu.permission == '' || ($user.can(menu.permission))"
                                        >
                                            {{ menu.title }}
                                        </NavLink>
                                    </template>
                                </template>

                                <div
                                    class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500  focus:outline-none focus:text-gray-700 focus:border-gray-300 transition dark:text-gray-200 dark:hover:text-gray-400"
                                    >

                                </div>
                            </div>

                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">


                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <div class="border-t border-gray-100" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <template v-for="(menu,index) in menuItems" :key="index" >
                        <!-- Responsive Settings Options -->
                        <div v-if="menu.subMenu" class="pt-4 pb-1 border-t border-gray-200">
                            <div class="flex items-center px-4">
                                <div class="font-medium text-base text-gray-800">
                                    {{ menu.title }}
                                </div>
                            </div>
                            
                            <div class="mt-3 space-y-1">
                                <template v-for="(item, sumenuIndex) in menu.subMenu" :key="sumenuIndex">
                                    <ResponsiveNavLink  
                                    v-if="!item.divide"
                                    :href="item.url ? item.url : route(item.route)"
                                    :active="item.route != '' && route().current(item.route)"
                                    >
                                        {{ item.title}}
                                </ResponsiveNavLink>
                                </template>
                            </div>
                        </div>
                        <template v-else >
                            <ResponsiveNavLink :href="menu.url ? menu.url : route(menu.route)"  
                            :active="route().current(menu.route)"
                            v-if=" menu.permission == '' || $user.can(menu.permission)" >
                                {{ menu.title }} 
                            </ResponsiveNavLink>
                        </template>
                    </template>
 
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800"
                                >
                                    {{ $page.props.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>


                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page tabs -->
            <div class="PageTabs" v-if="tabs">
                <div class="flex justify-between px-4 py-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <page-tabs :links="tabs" />
                </div>
            </div>

            <!-- Page Actions -->
            <div class="pageactions" v-if="breadcrums">
                <div class="flex justify-between px-4 py-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <bread-simple v-if="breadcrums" :items="breadcrums" />
                    <group-action-link :actions="actionsLinks"></group-action-link>
                </div>
            </div>

            <div class="pageactions" v-if="$slots.breadcrum || $slots.breadActions">
                <div class="flex justify-between px-4 py-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot name="breadcrum"></slot>
                    <slot name="breadActions"></slot>
                </div>
            </div>

            <!-- Page Notification and alerts -->
            <div class="notifications" v-if="$page.props.flash.message">
                <div class="px-4 py-2 mx-auto max-w-7xl sm:px-6 lg:px-8 ">
                    <Alerts :type="$page.props.flash.type" :message="$page.props.flash.message" />
                </div>
            </div>

            <!-- Errors -->
            <div class="notifications" v-if="$page.props.errors">
                <div v-for="(error , errorIndex) in $page.props.errors" :key="errorIndex" class="px-4 py-2 mx-auto max-w-7xl sm:px-6 lg:px-8 ">
                    <Alerts type="error" :message="error" />
                </div>
            </div>

            <div class="mx-auto mb-4 max-w-7xl sm:px-6 lg:px-8" v-if="$slots.filtersData">
                <slot   name="filtersData"></slot>
            </div>

            <!-- Page Content -->
            <main class="mx-auto mb-4 max-w-7xl sm:px-6 lg:px-8">
                <slot />
            </main>

        </div>

        <div class="bg-gray-300 py-4 relative">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 ">
                <div class="flex w-full text-center capitalize justify-center">
                    <span>Developed By Brijesh </span>
                    <span class="px-2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-500">
                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                        </svg>
                    </span>
                    <span>|</span>
                    <span class="px-2 text-center">
                        <svg class="h-6 w-6 text-indigo-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <path d="M14.5 9a3.5 4 0 1 0 0 6" /></svg>
                    </span>
                    <span class="">{{ new Date().getFullYear() }}</span>
                    
                </div>
            </div>
        </div>
    </div>
</template>
