<template>
    <label class="block font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }} <span v-if="required" class="text-xs text-red-600">*</span></span>
        <span v-else><slot></slot> <span v-if="required" class="text-xs text-red-600">*</span></span>
    </label>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            value: String,
            required : {type: Boolean , default: false}
        }
    })
</script>
