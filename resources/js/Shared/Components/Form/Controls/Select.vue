<template>
  <div class="field column" >
    <form-label v-if="label" :class="lableClass"  v-bind="$attrs" >{{ label }}</form-label>

      <select
        v-bind="$attrs"
        :name="name"
        class="mt-2 block  w-full rounded-md border-gray-300 p-2 capitalize shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:cursor-not-allowed sm:text-sm"
        @change="selectChange($event.target.value)"
        :class="inputClass"
        :style="inputStyle"
      >
        <option v-if="placeholder" disabled>{{ placeholder }}</option>
        <option value="" >{{ defaultSelect }}</option>
        <template v-if="options == 'week'">
          <option 
            v-for="weekDay in weeks"
            v-bind:key="weekDay"
            v-text="weekDay"
            :value="weekDay"
            :selected="weekDay == modelValue"
          ></option>
        </template>
        <template v-else-if="options == 'month'">
          <option 
            v-for="month in months"
            v-bind:key="month"
            v-text="month"
            :value="month"
            :selected="month == modelValue"
          ></option>
        </template>
        <template v-else-if="options == 'gender'">
          <option  v-for="gender in genders"
          v-bind:key="gender"
          v-text="gender"
          :value="gender"
          :selected="gender == modelValue"
          ></option>
        </template>
        <template v-else-if="options == 'yn'">
          <option v-for="yesno in yn"
          v-bind:key="yesno"
          v-text="yesno"
          :value="yesno"
          :selected="yesno == modelValue"
          ></option>
        </template>
        <template v-else-if="queryData">
          <option  v-for="(option) in options"
          v-bind:key="option[dataKey]"
          :value="option[dataKey]"
          :selected="option[dataKey] == modelValue"
          >{{formatText(option)}}</option>
        </template>
        <template v-else-if="Array.isArray(options)">
          <option v-for="(optionText) in options"
          v-bind:key="snake_case(optionText)"
          v-text="optionText"
          :value="snake_case(optionText)"
          :selected="snake_case(optionText) == modelValue"
          ></option>
        </template>
        <template v-else>
          <option
          v-for="(optionText, optionValue) in options"
          v-bind:key="optionValue"
          v-text="optionText"
          :value="optionValue"
          :selected="optionValue == modelValue"
          ></option>
        </template>
      </select>
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
    name: { type: String, required: false, default: "" },
    value: { type: String, required: false, default: "" },
    modelValue: { type: [String, Number], required: false, default: "" },
    placeholder: { type: String, required: false, default: "" },
    inputClass: { type: String, required: false, default: "" },
    inputStyle: { type: String, required: false, default: "" },
    options: { type: [Array, Object, String], required: true },
    label: { type: String, required: false, default: "" },
    validation: { type: String, default: "" },
    defaultSelect: {type: String, default: "select" },
    lableClass: { type: String, required: false, default: "" },
    queryData: { type: Boolean, default: false },
    dataKey: { type: String, default: 'id' },
    dataText: { type: [Array, Object, String], default: 'name' },
    error: { type: Boolean, default: false },
    errmsg: { type: String, default: "" }
  },

  data() {
    return {
      show: false ,
      weeks: [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ],
      months: [ 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october','november','december' ],
      yn: [ 'yes', 'no' ],
      genders: [ 'male', 'female' ]
    };
  },
  methods: {
    selectChange(val) {
      this.$emit("update:modelValue", val);
    },
    formatText(option){

      if (typeof this.dataText == 'string') {
        let keys = this.dataText.split('.');
        if (keys.length == 1) {
          return option[this.dataText];
        }else if(keys.length == 2){
          return option[keys[0]][keys[1]];
        } else if(keys.length == 3){
          return option[keys[0]][keys[1]][keys[2]];
        }else if(keys.length == 4){
          return option[keys[0]][keys[1]][keys[2]][[keys[3]]];
        }
      }else{
         let text = [];
         for (var i = 1 ; i < this.dataText.length ; i++) {
            text.push(this.getValue(option, this.dataText[i]));
         }
         return text.join(this.dataText[0]);
      }
    },
    getValue(obj, path) {
        if (!path) return obj;
        const properties = path.split('.');
        return this.getValue(obj[properties.shift()], properties.join('.'))
    },
    snake_case(text){
      if (text.length == 1) {
        return text;
      }
          return text.trim()
                .toLowerCase()
                .replaceAll('.' , '_')
                .replaceAll('-' , '_')
                .replaceAll(',' , '')
                .replaceAll(')' , '_')
                .replaceAll('(' , '_')
                .replaceAll('/' , '_')
                .replaceAll(' ' , '_')
                .replaceAll('___' , '_')
                .replaceAll('__' , '_')
                ;
        }
    }

    /*
      examples
      for sql data
      queryData
      dataKey="id"
      :dataText="[' - ', 'code', 'name']" or dataText="name"
    */

};
</script>
