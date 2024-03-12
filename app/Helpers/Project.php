<?php

use App\Models\Admin\Settings\Setting;

if (! function_exists('uploadImage')) {

    function uploadImage($image, $folder = 'others', $fileName = '')
    {
        $namePrefix = date('Y-m-d').'_'.time().'_';
        $fileName = $namePrefix.$fileName.'.'.$image->extension();
        $requestData = $image->storeAs('images/'.$folder, $fileName, 'public');

        return $requestData;

    }
}

if (! function_exists('updateCurrency')) {
    function updateCurrency($currencyId)
    {
        $currency = App\Models\Admin\Setups\Currency::find(1);
    }
}

if (! function_exists('settings')) {
    function settings($key) // key = group.key
    {
        $parameter = explode('.', $key);
        if (count($parameter) == 1) {
            return Setting::where('group', $parameter[0])->get()->pluck('value', 'key');
        } else {
            $setting = Setting::where('group', $parameter[0])->where('key', $parameter[1])->first('value');
            if (is_null($setting)) {
                return $setting;
            } else {
                return $setting->value;

            }
        }
    }
}

if (! function_exists('settingByKey')) {
    function settingByKey($key)
    {
        $value = Setting::key($key)->first('value');

        return is_null($value) ? is_null(config('app.'.$key)) ? $value : config('app.'.$key) : $value->value;
    }
}

if (! function_exists('pageSize')) {
    function pageSize()
    {
        return request()->has('size') && request()->size != '' ? request()->size : config('app.page_size');
    }
}

if (! function_exists('userCan')) {
    function userCan($permission)
    {
        return auth()->user()->can($permission) ? true : abort(403, 'Unauthorized action.');
    }
}

if (! function_exists('isRole')) {
    function isRole($role)
    {
        return auth()->user()->hasRole($role);
    }
}

if (! function_exists('numFor')) {
    function numFor($number)
    {
        return number_format($number, 2, '.', ',');
        // return number_format($number);
    }
}

if (! function_exists('currencySampleData')) {
    function currencySampleData()
    {

        return [
            [
                'name' => 'USD',
                'buy_code' => '99',
                'sell_code' => '999',
                'calculation_type' => 'multiplication',
                'is_special' => true,

                'starting_balance' => 50000,
                'starting_average' => 1.1,
                'current_average_rate' => 1.1,

                'admin_buy_rate_range_from' => 1,
                'admin_buy_rate_range_to' => 1.5,
                'admin_sell_rate_range_from' => 1,
                'admin_sell_rate_range_to' => 1.9,
                'admin_default_buy_rate' => 1.2,
                'admin_default_sell_rate' => 1.3,

                'user_buy_rate_range_from' => 1,
                'user_buy_rate_range_to' => 1.4,
                'user_sell_rate_range_from' => 1.1,
                'user_sell_rate_range_to' => 1.9,
                'user_default_buy_rate' => 1.2,
                'user_default_sell_rate' => 1.2,

                'balance_decimals' => 0,
                'rate_decimals' => 0,
            ],
            [
                'name' => 'Lera',
                'buy_code' => '11',
                'sell_code' => '111',
                'calculation_type' => 'multiplication',
                'is_special' => true,

                'starting_balance' => 1000,
                'starting_average' => 93000,
                'current_average_rate' => 93000,

                'admin_buy_rate_range_from' => 85000,
                'admin_buy_rate_range_to' => 94000,
                'admin_sell_rate_range_from' => 85000,
                'admin_sell_rate_range_to' => 94000,
                'admin_default_buy_rate' => 89000,
                'admin_default_sell_rate' => 89500,

                'user_buy_rate_range_from' => 85000,
                'user_buy_rate_range_to' => 94000,
                'user_sell_rate_range_from' => 85000,
                'user_sell_rate_range_to' => 94000,
                'user_default_buy_rate' => 89000,
                'user_default_sell_rate' => 89500,

                'balance_decimals' => 0,
                'rate_decimals' => 0,
            ],
            [
                'name' => 'Euro',
                'buy_code' => '33',
                'sell_code' => '333',
                'calculation_type' => 'multiplication',

                'starting_balance' => 0,
                'starting_average' => 0,
                'current_average_rate' => 0,

                'admin_buy_rate_range_from' => 1.07,
                'admin_buy_rate_range_to' => 1.12,
                'admin_sell_rate_range_from' => 1.07,
                'admin_sell_rate_range_to' => 1.13,
                'admin_default_buy_rate' => 1.09,
                'admin_default_sell_rate' => 1.10,

                'user_buy_rate_range_from' => 1.08,
                'user_buy_rate_range_to' => 1.10,
                'user_sell_rate_range_from' => 1.09,
                'user_sell_rate_range_to' => 1.11,
                'user_default_buy_rate' => 1.09,
                'user_default_sell_rate' => 1.10,

                'balance_decimals' => 0,
                'rate_decimals' => 4,
            ],
            [
                'name' => 'Sterling Pound',
                'buy_code' => '44',
                'sell_code' => '444',
                'calculation_type' => 'multiplication',

                'starting_balance' => 0,
                'starting_average' => 0,
                'current_average_rate' => 0,

                'admin_buy_rate_range_from' => 1.24,
                'admin_buy_rate_range_to' => 1.32,
                'admin_sell_rate_range_from' => 1.24,
                'admin_sell_rate_range_to' => 1.35,
                'admin_default_buy_rate' => 1.25,
                'admin_default_sell_rate' => 1.28,

                'user_buy_rate_range_from' => 1.24,
                'user_buy_rate_range_to' => 1.32,
                'user_sell_rate_range_from' => 1.25,
                'user_sell_rate_range_to' => 1.35,
                'user_default_buy_rate' => 1.25,
                'user_default_sell_rate' => 1.28,

                'balance_decimals' => 0,
                'rate_decimals' => 4,
            ],
            [
                'name' => 'Australian Dollar',
                'buy_code' => '61',
                'sell_code' => '611',
                'calculation_type' => 'multiplication',

                'starting_balance' => 0,
                'starting_average' => 0,
                'current_average_rate' => 0,

                'admin_buy_rate_range_from' => 0.64,
                'admin_buy_rate_range_to' => 0.69,
                'admin_sell_rate_range_from' => 0.65,
                'admin_sell_rate_range_to' => 0.71,
                'admin_default_buy_rate' => 0.64,
                'admin_default_sell_rate' => 0.66,

                'user_buy_rate_range_from' => 0.64,
                'user_buy_rate_range_to' => 0.69,
                'user_sell_rate_range_from' => 0.65,
                'user_sell_rate_range_to' => 0.71,
                'user_default_buy_rate' => 0.64,
                'user_default_sell_rate' => 0.66,

                'balance_decimals' => 0,
                'rate_decimals' => 4,
            ],
            [
                'name' => 'Canadian Dollar',
                'buy_code' => '514',
                'sell_code' => '5144',
                'calculation_type' => 'multiplication',

                'starting_balance' => 0,
                'starting_average' => 0,
                'current_average_rate' => 0,

                'admin_buy_rate_range_from' => 0.72,
                'admin_buy_rate_range_to' => 0.78,
                'admin_sell_rate_range_from' => 0.74,
                'admin_sell_rate_range_to' => 0.80,
                'admin_default_buy_rate' => 0.73,
                'admin_default_sell_rate' => 0.76,

                'user_buy_rate_range_from' => 0.72,
                'user_buy_rate_range_to' => 0.78,
                'user_sell_rate_range_from' => 0.75,
                'user_sell_rate_range_to' => 0.80,
                'user_default_buy_rate' => 0.73,
                'user_default_sell_rate' => 0.76,

                'balance_decimals' => 0,
                'rate_decimals' => 4,
            ],
            [
                'name' => 'Dirham Emirates',
                'buy_code' => '971',
                'sell_code' => '9711',
                'calculation_type' => 'multiplication',

                'starting_balance' => 0,
                'starting_average' => 0,
                'current_average_rate' => 0,

                'admin_buy_rate_range_from' => 0.268,
                'admin_buy_rate_range_to' => 0.273,
                'admin_sell_rate_range_from' => 0.271,
                'admin_sell_rate_range_to' => 0.276,
                'admin_default_buy_rate' => 0.270,
                'admin_default_sell_rate' => 0.274,

                'user_buy_rate_range_from' => 0.268,
                'user_buy_rate_range_to' => 0.273,
                'user_sell_rate_range_from' => 0.271,
                'user_sell_rate_range_to' => 0.276,
                'user_default_buy_rate' => 0.270,
                'user_default_sell_rate' => 0.274,

                'balance_decimals' => 0,
                'rate_decimals' => 7,
            ],
            [
                'name' => 'Saudi Riyal',
                'buy_code' => '966',
                'sell_code' => '9666',
                'calculation_type' => 'division',

                'starting_balance' => 10,
                'starting_average' => 3.8,
                'current_average_rate' => 10,

                'admin_buy_rate_range_from' => 3.75,
                'admin_buy_rate_range_to' => 3.81,
                'admin_sell_rate_range_from' => 3.74,
                'admin_sell_rate_range_to' => 3.81,
                'admin_default_buy_rate' => 3.80,
                'admin_default_sell_rate' => 3.75,

                'user_buy_rate_range_from' => 3.75,
                'user_buy_rate_range_to' => 3.81,
                'user_sell_rate_range_from' => 3.74,
                'user_sell_rate_range_to' => 3.81,
                'user_default_buy_rate' => 3.80,
                'user_default_sell_rate' => 3.75,

                'balance_decimals' => 0,
                'rate_decimals' => 4,
            ],
            [
                'name' => 'Qatari Riyal',
                'buy_code' => '974',
                'sell_code' => '9744',
                'calculation_type' => 'multiplication',

                'starting_balance' => 0,
                'starting_average' => 0.26,
                'current_average_rate' => 0,

                'admin_buy_rate_range_from' => 0.250,
                'admin_buy_rate_range_to' => 0.270,
                'admin_sell_rate_range_from' => 0.270,
                'admin_sell_rate_range_to' => 0.280,
                'admin_default_buy_rate' => 0.265,
                'admin_default_sell_rate' => 0.274,

                'user_buy_rate_range_from' => 0.250,
                'user_buy_rate_range_to' => 0.270,
                'user_sell_rate_range_from' => 0.270,
                'user_sell_rate_range_to' => 0.280,
                'user_default_buy_rate' => 0.265,
                'user_default_sell_rate' => 0.274,

                'balance_decimals' => 0,
                'rate_decimals' => 5,
            ],
            [
                'name' => 'Swiss Franc',
                'buy_code' => '41',
                'sell_code' => '411',
                'calculation_type' => 'multiplication',

                'starting_balance' => 0,
                'starting_average' => 0.90,
                'current_average_rate' => 0,

                'admin_buy_rate_range_from' => 0.83,
                'admin_buy_rate_range_to' => 0.90,
                'admin_sell_rate_range_from' => 0.83,
                'admin_sell_rate_range_to' => 0.90,
                'admin_default_buy_rate' => 0.89,
                'admin_default_sell_rate' => 0.85,

                'user_buy_rate_range_from' => 0.83,
                'user_buy_rate_range_to' => 0.90,
                'user_sell_rate_range_from' => 0.83,
                'user_sell_rate_range_to' => 0.90,
                'user_default_buy_rate' => 0.89,
                'user_default_sell_rate' => 0.85,

                'balance_decimals' => 0,
                'rate_decimals' => 4,
            ],
        ];
    }
}
