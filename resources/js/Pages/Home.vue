<template>
    <public-layout>
        <template #header>
            <h2 class="font-semibold text-xl light:text-gray-800 leading-tight">
                Home
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <welcome />
                </div>
            </div>
        </div>
    </public-layout>
</template>

<script>
    import PublicLayout from '@/Layouts/PublicLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            PublicLayout,
            Welcome,
        },
    }
</script>
