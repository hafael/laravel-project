<template>
    <modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <div class="px-6 py-4">
            

            <div class="flex justify-between items-center">
                <div class="text-lg">
                    <slot name="title">
                    </slot>
                </div>
                <div class="close p-2 cursor-pointer" v-if="closeable" @click="close">
                    <XIcon class="w-5 h-5 text-gray-600" />
                </div>
            </div>

            <div class="mt-4">
                <slot name="content">
                </slot>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-100 text-right">
            <slot name="footer">
            </slot>
        </div>
    </modal>
</template>

<script>
    import Modal from './Modal'
    import { XIcon} from '@heroicons/vue/outline'

    export default {
        emits: ['close'],

        components: {
            Modal,
            XIcon
        },

        props: {
            show: {
                default: false
            },
            maxWidth: {
                default: '2xl'
            },
            closeable: {
                default: true
            },
        },

        methods: {
            close() {
                this.$emit('close')
            },
        }
    }
</script>
