<template>
  <div class="control">
    <form-label v-if="label" :class="lableClass"  v-bind="$attrs" >{{ label }}</form-label>
    <div class="relative mt-1 rounded-md shadow-sm">
        <div class="pointer-events-none  absolute inset-y-0 left-0 flex items-center pl-3">
            <span class="text-gray-700  sm:text-sm">{{ prefix }}</span>
        </div>
        <input
          v-bind="$attrs"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          :type="type"
          :name="name"
          :placeholder="placeholder"
          :class="inputClass"
          :style="inputStyle"
          class="mt-1 w-full rounded-md border-gray-300 shadow-sm read-only:cursor-not-allowed focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:cursor-not-allowed"
        />
        <div v-if="postfix" class="absolute inset-y-0 right-0 flex items-center">
          <span class="text-gray-500 sm:text-sm">{{ postfix }}</span>
      </div>
    </div>

    <span class="text-gray-500" v-if="helpText" v-text="helpText"></span>
    <input-error v-if="error || errmsg" :message="errmsg" class="mt-2" />
  </div>
</template>

<script>
    import InputError from '@/Shared/Components/Form/Simple/InputError.vue'
    import FormLabel from '@/Shared/Components/Form/Simple/Label.vue'

export default {
    components: {
            InputError,
            FormLabel
        },
  props: {
    modelValue: { type: [Number, String], required: false, default: "" },
    prefix: { type: [Number, String], required: false, default: "" },
    postfix: { type: [Number, String], required: false, default: "" },
    type: { type: String, required: true, default: "text" },
    name: { type: String, required: false, default: "" },
    value: { type: [Number, String], required: false, default: "" },
    placeholder: { type: String, required: false, default: "" },
    label: { type: String, required: false, default: "" },
    hint: { type: String, required: false, default: "hint" },
    validation: { type: String, default: "" },
    error: { type: Boolean, default: false },
    errmsg: { type: String, default: "" },
    helpText: {type: String, default: ""},
    inputClass: { type: String, required: false, default: "" },
    lableClass: { type: String, required: false, default: "" },
    inputStyle: { type: String, required: false, default: "" }
  },

  data() {
    return {
      show: false
    };
  },
  methods: {
    inputChange(inputVal) {
      this.$emit("update:modelValue", inputVal);
    }
    //
  }
};
</script>

