<template>
    <input 
        v-if="!mask"
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
        :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)" 
        :readonly="readonly" 
        :disabled="disabled"
        ref="input">
    <input 
        v-else
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
        :value="modelValue" 
        @maska="maskaEvent" 
        :readonly="readonly" 
        :disabled="disabled"
        v-maska="mask"
        ref="input">
</template>

<script>
    export default {
        props: {
            readonly: {
                type: Boolean,
                default: () => { return false }
            },
            disabled: {
                type: Boolean,
                default: () => { return false }
            },
            mask: {},
            modelValue: {}
        },

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            },
            maskaEvent(ev) {
                this.$emit('update:modelValue', ev.target.getAttribute('data-mask-raw-value'))
            }
        }
    }
</script>

