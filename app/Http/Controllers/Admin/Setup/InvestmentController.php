<?php

namespace App\Http\Controllers\Admin\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\InvestmentItem;
use App\Models\Admin\InvestmentType;

class InvestmentController extends Controller
{ 
    
    public function store(string $investmentType){
        
        $investmentList = $this->investmentItemsList($investmentType);

        if(! count($investmentList)){
            return ;
        }

        $investmentTypeID = InvestmentType::select('id')->whereName($investmentType)->first()->id;
        

        foreach ($investmentList as $key => $investment) {

            $investment['investment_type_id'] = $investmentTypeID;

            if(isset($investment['meta'])){
                $metas = $investment['meta'];
                unset($investment['meta']);
            }

            $investment = InvestmentItem::firstOrCreate($investment);
            
           /*  array_push($metas , 
                [ 'key' => 'ltcg_months', 'value' => '12' ],
                [ 'key' => 'ltcg_tax', 'value' => '10' ],
                [ 'key' => 'ltcg_discount', 'value' => '100000' ],
                [ 'key' => 'stcg_tax', 'value' => '15' ]
            ); */
            
            if(isset($investment['meta'])){

                foreach($metas as $meta){
                    $investment->metas()->firstOrCreate($meta); 
                }
            }

        }
    }

    function investmentItemsList(string $type = 'Stocks'): array{
        $list['Stocks'] = [
            ['name' => 'Indian Oil Corporation', 'symbol' => 'IOC', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'IOC' ],
                    [ 'key' => 'bse_code', 'value' => '530965' ],
                ]
            ],
            ['name' => 'Vedanta Ltd', 'symbol' => 'VEDL', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'VEDL' ],
                    [ 'key' => 'bse_code', 'value' => '500295' ],
                ]
            ],
            ['name' => 'Life insurance corporation of india', 'symbol' => 'LIC', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'LICI' ],
                    [ 'key' => 'bse_code', 'value' => '543526' ], 
                ]
            ], 
            ['name' => 'Trident Ltd', 'symbol' => 'TRIDENT', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'TRIDENT' ],
                    [ 'key' => 'bse_code', 'value' => '521064' ], 
                ]
            ], 
            ['name' => 'Central Depository Services (India) Ltd', 'symbol' => 'CDSL', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'CDSL' ],
                ]
            ],
            ['name' => 'Infosys Ltd', 'symbol' => 'INFY', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'INFY' ],
                    [ 'key' => 'bse_code', 'value' => '500209' ], 
                ]
            ],
            ['name' => 'Godawari Power & Ispat Ltd', 'symbol' => 'TRIDENT', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'GPIL' ],
                    [ 'key' => 'bse_code', 'value' => '532734' ], 
                    [ 'key' => 'web_link', 'value' => 'http://godawaripowerispat.com/' ], 
                ]
            ],
            ['name' => 'Wipro Ltd', 'symbol' => 'WIPRO', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'WIPRO' ],
                    [ 'key' => 'bse_code', 'value' => '507685' ], 
                    [ 'key' => 'web_link', 'value' => 'http://www.wipro.com/' ], 
                ]
            ],
            ['name' => 'Delta Corp Ltd', 'symbol' => 'DELTACORP', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'DELTACORP' ],
                    [ 'key' => 'bse_code', 'value' => '532848' ], 
                    [ 'key' => 'web_link', 'value' => 'http://www.deltacorp.in/' ],
                ]
            ],
            ['name' => 'Punjab National Bank', 'symbol' => 'PNB', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'PNB' ],
                    [ 'key' => 'bse_code', 'value' => '532461' ], 
                    [ 'key' => 'web_link', 'value' => 'http://www.pnbindia.in/' ],
                ]
            ],
        ];

        $list['Mutual fund'] = [ ];
        $list['SGB'] = [ ];
        $list['REIT'] = [
            ['name' => 'Embassy Office Parks REIT', 'symbol' => 'EMBASSY', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'EMBASSY' ],
                    [ 'key' => 'bse_code', 'value' => '542602' ],
                    [ 'key' => 'web_link', 'value' => 'https://www.embassyofficeparks.com/' ],
                ]
            ],
            ['name' => 'Brookfield India Real Estate Trust', 'symbol' => 'BIRET', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'BIRET' ],
                    [ 'key' => 'bse_code', 'value' => '543601' ],
                    [ 'key' => 'web_link', 'value' => 'https://www.brookfieldindiareit.in/' ],
                ]
            ],
            ['name' => 'Mindspace Business Parks REIT', 'symbol' => 'MINDSPACE', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'MINDSPACE' ],
                    [ 'key' => 'bse_code', 'value' => '543617' ],
                    [ 'key' => 'web_link', 'value' => 'https://www.mindspacereit.com/' ],
                ]
            ],
         ];
        $list['FD'] = [ 
            ['name' => 'Fixed Diposit', 'symbol' => 'FD' ],
        ];
        $list['ETF'] = [ 
            ['name' => 'Nippon India ETF Nifty IT', 'symbol' => 'ITBEES', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'ITBEES' ], 
                ]
            ],
            ['name' => 'Nippon India ETF Nifty 50 BeES', 'symbol' => 'NIFTYBEES', 
                'meta'=> [
                    [ 'key' => 'nse_code', 'value' => 'MINDSPACE' ],
                    [ 'key' => 'bse_code', 'value' => '590103' ], 
                ]
            ],
        ];
        $list['PF'] = [ 
            ['name' => 'Provident Fund', 'symbol' => 'PF' ],
        ];
        $list['T-Bills'] = [ ];
        return $list[$type];
    }
}
