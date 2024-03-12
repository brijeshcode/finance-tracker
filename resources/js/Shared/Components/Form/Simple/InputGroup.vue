<template>
    <div class="mt-1 relative rounded-md  shadow-sm border-gray-300 p-0">
        <div v-show="prefix" class="absolute inset-y-0 left-0 p-2 border-r  flex items-center bg-gray-100 border pointer-events-none">
          <span class="text-gray-500 sm:text-xs" v-show="prefixlabel">{{ prefixlabel }}</span>
          <span class="text-gray-500 sm:text-xs" v-show="prefix" v-text="prefix"></span>
        </div>
        <input class="focus:ring focus:ring-indigo-200 focus:ring-opacity-50  block w-full pl-20 text-gray-500
         focus:border-indigo-300 shadow-sm rounded-md p-2 " :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: ['modelValue', 'prefix', 'prefixlabel'],

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    })
</script>

