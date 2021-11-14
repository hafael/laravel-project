<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuário
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- Profile Form -->
                <update-user-profile :user="userData" />
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import UpdateUserProfile from '@/Pages/Admin/Users/UpdateProfile'

    export default {
        components: {
            AdminLayout,
            JetSectionBorder,
            UpdateUserProfile,
        },
        props: ['userData'],

        data() {
            return {
                
            }
        },

        mounted() {
            console.log('mounted', this.userData);
        },

        methods: {
            
        },
    }
</script>
