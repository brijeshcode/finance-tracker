<template>
  <div class="control pt-4">
    <label class="">
        <input type="checkbox" v-bind="$attrs" :value="value" v-model="proxyChecked" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:cursor-not-allowed" />
        <span class="ml-2 font-medium text-sm font-semibold text-gray-700 " v-if="label" >{{ label }}</span>
    </label>
  </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    emits: ['update:checked'],

    props: {
        checked: {
            type: [Array, Boolean],
            default: false,
        },
        label: { type: String, required: false, default: "" },

        value: {
            default: null,
        },
    },

    computed: {
        proxyChecked: {
            get() {
                return this.checked;
            },

            set(val) {
                this.$emit("update:checked", val);
            },
        },
    },
})
</script>
