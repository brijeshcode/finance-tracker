<template>
  <div class="control">
    <label v-if="label" :class="lableClass" class="ml-2 text-sm font-medium text-gray-700">{{ label }}</label>
    <div class="control">
      <label v-for="(radioText, radioValue ,index) in radios" v-bind:key="radioValue">
        <input
          type="radio"
          :value="radioValue"
          :id="radioValue"
          :name="name"
          :checked="modelValue == radioValue"
          :class="inputClass"
          :style="inputStyle"
          @change="radioChange($event.target.value)"
          class="mx-2 h-4 w-4 border-gray-300 text-indigo-600 read-only:cursor-not-allowed focus:ring-indigo-500 disabled:cursor-not-allowed"
        />
        <span v-if="radioText != ''" class="text-sm font-medium text-gray-700">{{ radioText }}</span> &nbsp;
      </label>
    </div>
    <span class="text-red-500" v-if="error" v-text="errmsg"></span>
  </div>
</template>

<script>
    import FormLabel from '@/Shared/Components/Form/Simple/Label.vue'
export default {
  components: {
      FormLabel
  },
  props: {
    name: { type: String, required: false, default: "" },
    value: { type: String, required: false, default: "" },
    modelValue: { type: String, required: false, default: "" },
    inputClass: { type: String, required: false, default: "" },
    inputStyle: { type: String, required: false, default: "" },
    label: { type: String, required: false, default: "" },
    radios: { type: [Array, Object], required: true },
    validation: { type: String, default: "" },
    error: { type: Boolean, default: false },
    lableClass: { type: String, required: false, default: "" },
    errmsg: { type: String, default: "" }
  },

  data() {
    return {
      checked: this.value && this.value == this.radio.value ? true : false
    };
  },
  methods: {
    radioChange(val) {
      this.$emit("update:modelValue", val);
    }
  }
};
</script>
