<template>
  <div class="control">
    <form-label v-if="label" :class="lableClass"  v-bind="$attrs" >{{ label }}</form-label>
    <textarea
      v-bind="$attrs"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      :name="name"
      :placeholder="placeholder"
      :class="iclass"
      :style="inputStyle"
      class="border-gray-300 read-only:cursor-not-allowed focus:border-indigo-300 disabled:cursor-not-allowed mt-1 w-full focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
    ></textarea>
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
    name: { type: String, required: false, default: "" },
    placeholder: { type: String, required: false, default: "" },
    label: { type: String, required: false, default: "" },
    hint: { type: String, required: false, default: "hint" },
    validation: { type: String, default: "" },
    error: { type: Boolean, default: false },
    errmsg: { type: String, default: "" },
    helpText: {type: String, default: ""},
    iclass: { type: String, required: false, default: "" },
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
      console.log(inputVal);
      this.$emit("update:modelValue", inputVal);
    }
    //
  }
};
</script>

