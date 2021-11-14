<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Contatos
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <contacts :contacts="contacts" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Contacts from './Contacts/Index.vue'

    export default {
        components: {
            AppLayout,
            Contacts,
        },
        props: ['contacts']
    }
</script>
