<template>
    <div>
        <inertia-head :title="pageTitle + 'Autum Blank'" />
        <jet-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-800 dark:text-white transition duration-300">
            <nav class="bg-white border-b border-gray-100 dark:bg-gray-900 dark:text-white dark:border-gray-600">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link :href="route('dashboard')">
                                    <jet-application-mark class="block h-9 w-auto" />
                                </inertia-link>
                            </div>
                            
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">

                            <toggle-dark-mode />

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <navbar-settings-dropdown  v-if="$page.props.user"/>
                                
                                <a :href="route('login')" class="inline-flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    Login
                                </a>
                            </div>
                            
                        </div>

                        <!-- Hamburger -->
                        <div class="flex items-center sm:hidden">
                            <toggle-dark-mode />

                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="ml-3 inline-flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" v-if="$page.props.user" />
                                <UserCircleIcon class="w-8 h-8" v-else />
                            </button>

                            
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600" v-if="!$page.props.user">
                        <div class="mt-3 space-y-1">
                            <jet-responsive-nav-link :href="route('login')">
                                <template #icon><SignInIcon class="w-4 h-4" /></template>
                                Login
                            </jet-responsive-nav-link>
                        </div>
                    </div>
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600" v-else>
                        <div class="flex items-center px-4 cursor-pointer" @click="goToDashboard">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3" >
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            </div>

                            <div>
                                <div class="font-medium text-base">{{ $page.props.user.name }} {{ $page.props.user.lastname }}</div>
                                <div class="font-semibold text-sm text-gray-500">@{{ $page.props.user.username }}</div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">

                            <jet-responsive-nav-link :href="route('manager.dashboard')" :active="route().current('manager.dashboard')" v-if="profileIs('manager')">
                                <template #icon><CogIcon class="w-4 h-4" /></template>
                                Área do Gerente
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link :href="route('admin.dashboard')" :active="route().current('admin.dashboard')" v-if="$page.props.user.is_admin || profileIs('admin')">
                                <template #icon><CogIcon class="w-4 h-4" /></template>
                                Área administrativa
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link :href="route('contacts.index')" :active="route().current('contacts.index')">
                                <template #icon><UserGroupIcon class="w-4 h-4" /></template>
                                Meus Contatos
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                                <template #icon><ExternalLinkIcon class="w-4 h-4" /></template>
                                Minha Conta
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    <template #icon><LogoutIcon class="w-4 h-4" /></template>
                                    Sair
                                </jet-responsive-nav-link>
                            </form>

                        </div>
                    </div>
                </div>

                
            </nav>

            <!-- Page Heading -->
            <header class="bg-white dark:bg-gray-900 dark:text-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>

            <footer class="border-t-1 border-indigo-400">
                <div class="max-w-7xl mx-auto pt-6 pb-3 px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-sm text-gray-400">Autum @ 2022 | <a href="https://autum.com.br" class="text-cyan-400 text-bold" title="Autum">autum.com.br</a></div>
                </div>
                <div class="flex justify-center">
                    <div class="autum-brand light inline-block dark:hidden"></div>
                    <div class="autum-brand dark hidden dark:inline-block"></div>
                </div>
                
            </footer>
        </div>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import { ExternalLinkIcon, BriefcaseIcon, DocumentSearchIcon, CogIcon, UserCircleIcon, PuzzleIcon, UserAddIcon, UserGroupIcon, LogoutIcon } from '@heroicons/vue/outline'
    import ToggleDarkMode from '@/Components/ToggleDarkMode'
    import NotificationIcon from '@/Components/NotificationIcon'
    import NotificationCentral from '@/Components/NotificationCentral'
    import NavbarSettingsDropdown from '@/Components/NavbarSettingsDropdown'

    export default {
        components: {
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            ToggleDarkMode,
            NotificationIcon,
            NotificationCentral,
            NavbarSettingsDropdown,
            BriefcaseIcon,
            CogIcon,
            UserCircleIcon,
            PuzzleIcon, 
            UserAddIcon, 
            UserGroupIcon,
            LogoutIcon,
            DocumentSearchIcon,
            ExternalLinkIcon
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        computed: {
            
            pageTitle() {
                return this.$page.props.title ? $page.props.title + ' – ' : '';
            }
        },

        

        methods: {


            logout() {
                axios.post(route('logout')).then((response) => {
                    window.location.replace('/');
                }).catch((error) => {
                    this.$inertia.post(route('logout'));
                });
            },

        
        }
    }
</script>
