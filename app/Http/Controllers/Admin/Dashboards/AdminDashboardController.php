<?php

namespace App\Http\Controllers\Admin\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Admin\Accounts\Account;
use App\Models\Admin\Logs\DailyCaseBalance;
use App\Models\Admin\Logs\DailyCurrencyBalance;
use App\Models\Admin\Logs\DailyTellerBalance;
use App\Models\Admin\Logs\DailyTradeSummery;
use App\Models\Admin\Setups\Currency;
use App\Models\Admin\Setups\CurrencyCase;
use App\Models\Admin\Tellers\TellerAccount;
use App\Models\Admin\Trades\CurrencyTrade;
use App\Models\Admin\Transfers\TellerTransfer;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    private $currencies = [];

    private $filterDate = null;

    public function __construct()
    {
         

    }

    public function index(Request $request)
    {
 

        $time = date('d-M-Y h:i:s A'); 

        return Inertia::render('Admin/Dashboard', compact('time'));
    }

    public function getCase(Request $request)
    {
        if (! is_null($this->filterDate)) {
            $currCase = DailyCaseBalance::when($request->date, function ($query, $date) {
                $query->whereDate('date', $date);
            })->select(['balance'])->first();
        } else {
            $currCase = CurrencyCase::active()->get(['name', 'currency_id', 'balance'])->first();
        }

        if (is_null($currCase)) {
            $currCase['balance'] = 0;
        }

        return $currCase;
    }

    public function getDailyProfit()
    {
        $date = is_null($this->filterDate) ? now()->today() : $this->filterDate;

        return $profit = CurrencyTrade::whereDate('created_at', $date)->sum('profit');
    }

    public function getMonthlyProfit()
    {
        $month = is_null($this->filterDate) ? date('m') : date('m', strtotime($this->filterDate));
        $year = is_null($this->filterDate) ? date('Y') : date('Y', strtotime($this->filterDate));

        return $profit = CurrencyTrade::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('profit');
    }

    public function currencyData()
    {
        if (! is_null($this->filterDate)) {
            return $this->filterData($this->filterDate);
        }

        $currencies = $this->currencies;

        $accounts = Account::active()
            ->get(['id', 'account_holder_id', 'currency_id', 'balance'])->groupBy('currency_id');

        $usdId = config('app.usd_id');
        $usdTotal = 0;

        foreach ($currencies as $key => $currency) {
            if (isset($accounts[$currency->id])) {
                $currencies[$key]['account'] = $accounts[$currency->id]->sum('balance');
            } else {
                $currencies[$key]['account'] = 0;
            }

            if ($currency->id == $usdId) {
                $currencies[$key]['total'] = 0;
                $currencies[$key]['balance'] = 0;
                $currencies[$key]['current_average_rate'] = 0;
                $currencies[$key]['usd_amount'] = 0;

                continue;
            }
            $currencies[$key]['total'] = $currencies[$key]['account'] + $currency->balance;
            if ($currencies[$key]['is_special']) {
                $currencies[$key]['usd_amount'] = $currency->balance == 0 ? $currency->balance : $currency->balance / $currency->current_average_rate;
                $currencies[$key]['total_usd_amount'] = $currencies[$key]['total'] == 0 ? 0 : $currencies[$key]['total'] / $currency->current_average_rate;
            } else {
                if ($currencies[$key]['calculation_type'] == 'multiplication') {
                    $currencies[$key]['usd_amount'] = $currency->balance * $currency->current_average_rate;
                    $currencies[$key]['total_usd_amount'] = $currencies[$key]['total'] == 0 ? 0 : $currencies[$key]['total'] * $currency->current_average_rate;
                } else {
                    $currencies[$key]['usd_amount'] = $currency->balance == 0 ? $currency->balance : $currency->balance / $currency->current_average_rate;
                    $currencies[$key]['total_usd_amount'] = $currencies[$key]['total'] == 0 ? 0 : $currencies[$key]['total'] / $currency->current_average_rate;
                }
            }
            $usdTotal += $currencies[$key]['usd_amount'];
        }

        return ['usdTotal' => $usdTotal, 'currencies' => $currencies];
    }

    public function filterData($date)
    {
        $currencyBalances = DailyCurrencyBalance::with('currency:id,name,balance_decimals,rate_decimals')->whereDate('date', $date)->get()
            ->map(function ($balance) {
                return [
                    'id' => 1,
                    'name' => $balance->currency->name,
                    'balance' => $balance->balance,
                    'current_average_rate' => $balance->rate,
                    'is_special' => $balance->is_special,
                    'balance_decimals' => $balance->currency->balance_decimals,
                    'rate_decimals' => $balance->currency->rate_decimals,
                    'calculation_type' => $balance->calculation_type,
                    'account' => $balance->account_balance,
                    'total' => $balance->total,
                    'usd_amount' => $balance->usd_amount,
                ];
            });

        $usdTotal = $currencyBalances->sum('usd_amount');

        return ['usdTotal' => $usdTotal, 'currencies' => $currencyBalances];
    }

    public function getTodaysTradesByCurrency()
    {
        // active point : start from here:
        // next task: match the parameter of currecytrade result and daily trade summary and return it.
        if (! is_null($this->filterDate)) {
            return DailyTradeSummery::select('date', 'currency_id', 'buy_trades', 'sell_trades', 'buy_amount', 'sell_amount', 'profit')->with('currency:id,name,is_special,flag_image')->whereDate('date', $this->filterDate)->get()->map(function ($summery) {
                return [
                    'currency_id' => $summery['currency_id'],
                    'buy' => $summery['buy_amount'],
                    'sell' => $summery['sell_amount'],
                    'total_trades' => $summery['buy_trades'] + $summery['se ll_trades'],
                    'total_buy' => $summery['buy_trades'],
                    'total_sell' => $summery['sell_trades'],
                    'profit' => $summery['profit'],
                    'currency' => $summery['currency'],
                ];
            })->keyBy('currency_id');
        }

        $trades = CurrencyTrade::with('currency:id,name,is_special,flag_image')
            ->whereDate('created_at', now()->today())
        // ->whereDate('created_at', '2023-08-07')
            ->get(['currency_id', 'is_buy', 'total', 'amount', 'profit'])->groupBy('currency_id');
        $tradeReport = $trades->map(function ($trade, $currencyId) {
            $report['currency_id'] = $currencyId;
            $report['buy'] = $trade->where('is_buy', 1)->sum('amount');
            $report['sell'] = $trade->where('is_buy', 0)->sum('amount');
            $report['total_trades'] = $trade->count();
            $report['total_buy'] = $trade->where('is_buy', 1)->count();
            $report['total_sell'] = $trade->where('is_buy', 0)->count();
            $report['profit'] = $trade->sum('profit');
            $report['currency'] = $trade[0]->currency;

            return $report;
        });

        return $tradeReport;
    }

    public function getTellerBalance()
    {
        if (! is_null($this->filterDate)) {
            return $this->getTellerLeraBalance();
        }

        $accounts = TellerAccount::where('balance', '!=', 0)->get(['teller_id', 'currency_id', 'balance'])->groupBy('teller_id');

        $tellers = User::whereIn('id', $accounts->keys())->get(['id', 'name'])->groupBy('id');
        $currencyList = $this->currencies->map(function ($currency) {
            return $currency->only('id', 'name', 'balance_decimals', 'flag_image');
        });

        // check for missing trades

        return $accounts->map(function ($account) use ($tellers, $currencyList) {

            /* $tradeCount = CurrencyTrade::where("created_by_id", $account[0]->teller_id)->count();
            $transfersCount = TellerTransfer::isTeller($account[0]->teller_id)->trades()->count(); */
            $transfersCount = $tradeCount = 0;
            // this is to check in difference in every currency. But we don't want right now
            $currencyTransactions = $account->map(function ($currency) use ($currencyList) {
                $tradeCount = $transfersCount = 0;
                /* $transfersCount = TellerTransfer::isTeller($currency->teller_id)->isCurrency($currency->currency_id)->trades()
                ->count();

                if ($currency->currency_id !== 1) {
                    $tradeCount = CurrencyTrade::where("created_by_id", $currency->teller_id)->isCurrency($currency->currency_id)
                    ->count();
                }

                $tradeCount = $currency->currency_id == 1 ? $transfersCount : $tradeCount; */

                return $currencyList->firstWhere('id', $currency->currency_id) +
                [
                    'balance' => $currency->balance,
                    'trade_count' => $tradeCount,
                    'teller_transfers' => $transfersCount,
                    'issue' => $transfersCount !== $tradeCount,
                ];

            });

            return [
                'teller' => $tellers[$account[0]->teller_id][0]->only(['id', 'name']),
                'trade_count' => $tradeCount,
                'teller_transfers' => $transfersCount / 2,
                'currencies' => $currencyTransactions,
            ];
        });
    }

    public function getTellerLeraBalance()
    {
        return DailyTellerBalance::where('currency_id', config('app.lera_id'))
            ->with('teller:id,name')
            ->whereDate('date', $this->filterDate)
            ->get()->map(function ($balance) {
                return [
                    'id' => $balance->id,
                    'name' => $balance->teller->name,
                    'teller_id' => $balance->teller->id,
                    'currency' => [
                        'id' => config('app.lera_id'),
                        'name' => 'Lera',
                        'balance' => $balance->balance,

                    ],
                ];
            });

    }

    public function getAllTradesByCurrency()
    {
        $trades = CurrencyTrade::with('currency:id,name,is_special')->get(['currency_id', 'is_buy', 'total', 'amount', 'profit'])->groupBy('currency_id');
        $tradeReport = $trades->map(function ($trade, $currencyId) {
            // dd($trade);
            $report['currency_id'] = $currencyId;
            if ($trade[0]->currency->is_special) {
                $report['buy'] = $trade->where('is_buy', 0)->sum('total');
                $report['sell'] = $trade->where('is_buy', 1)->sum('total');
            } else {
                $report['buy'] = $trade->where('is_buy', 1)->sum('amount');
                $report['sell'] = $trade->where('is_buy', 0)->sum('amount');
            }
            $report['total_trades'] = $trade->count();
            $report['profit'] = $trade->sum('profit');
            $report['currency'] = $trade[0]->currency;

            return $report;
        });

        return $tradeReport;
    }
}
