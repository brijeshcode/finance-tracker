import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
const decimalSize = computed(() => usePage().props.decimal_place);

let NumberFormator = {
  install(app, options) {

    app.config.globalProperties.$num = {
      numStr(num, options = []) {
        // setting default
        if (! options.type) {
            options.type = 'string'; // [string, number, currency, percent, str, num, cur, per]
        }

        if (! options.precision) {
            options.precision = decimalSize.value; // decimal places
        }

        if (! options.num_color) {
            options.num_color = 'text-gray-500';
        }

        if (! options.decimal_color) {
            options.decimal_color = 'text-red-500';
            options.colored = false;
        }else{
          options.colored = true;
        }

        let isNumber = num;
        if (['string', 'str'].includes(options.type)) {
            isNumber = this.decimalStr(num, options.precision)
        }

        if (['number', 'num'].includes(options.type)) {
            isNumber = this.decimal(num, options.precision)
        }

        if (['currency', 'cur'].includes(options.type)) {
            isNumber = this.currency(num, options.precision)
        }

        if (['percent', 'per'].includes(options.type)) {
            isNumber = this.percent(num, options.precision)
        }

        if (options.colored) {
           isNumber = this.colored(isNumber, options);
        }
        return isNumber;

      },

      colored(num, option) {
        var numArray = num.split('.');
        if (numArray.length == 1) {
          return num;
        }
        let temp = '<span class="'+option.num_color+' text-lg">' + numArray[0] + '</span>';
        temp += '.<span class="'+option.decimal_color+' ">' + numArray[1] + '</span>';
        return temp;
      },

      decimalStr(num, places = decimalSize.value) {
        return this.decimal(num, places).toLocaleString("en-US", {
          maximumFractionDigits: places,
          useGrouping: true
        });

      },
      currency(amount, currency = 'USD', places = decimalSize.value) {
        return this.decimal(num, places = decimalSize.value).toLocaleString("en-US", {
          style:"currency",
          currency:currency,
          maximumFractionDigits: places
        });
      },
      percent(amount, places = decimalSize.value) {
        return this.decimal(num, places = decimalSize.value).toLocaleString("en-US", {
          style:"percent",
          maximumFractionDigits: places
        });
      },
      decimal(num, places = decimalSize.value) {
        return parseFloat(num).toFixed(places) * 1 ;
      }
    };
    /*app.config.globalProperties.$num = {
    }*/
  }
};

export default NumberFormator