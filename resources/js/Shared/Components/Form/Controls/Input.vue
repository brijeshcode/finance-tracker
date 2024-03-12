<template>
  <div class="control">
    <form-label v-if="label" :class="lableClass"  v-bind="$attrs" >{{ label }}</form-label>
    <input
      v-bind="$attrs"
      :ref="ifocus"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      :type="type"
      :name="name"
      :placeholder="placeholder"
      :class="iclass"
      :style="inputStyle"
      class="mt-1 w-full rounded-md border-gray-300 shadow-sm read-only:cursor-not-allowed focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:cursor-not-allowed"
    />
    <span class="text-gray-500 text-sm" v-if="helpText" v-text="helpText"></span>
    <input-error v-if="error || errmsg" :message="errmsg" class="mt-2 text-sm" />
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
    type: { type: String, required: true, default: "text" },
    name: { type: String, required: false, default: "" },
    placeholder: { type: String, required: false, default: "" },
    label: { type: String, required: false, default: "" },
    hint: { type: String, required: false, default: "hint" },
    validation: { type: String, default: "" },
    error: { type: Boolean, default: false },
    errmsg: { type: String, default: "" },
    ifocus: { type: String, default: "" },
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
  mounted(){
    // input focus
    if (this.ifocus !== '') {
        this.$refs[this.ifocus].focus();
    }
        // this.$refs.currencyCode.$el.focus();

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

