<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiConversiosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ApiConversionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            //
            // Validations here
            $validateData = Validator::make(
                $request->all(),
                [
                    'target_currency' => 'required|alpha|min: 3|max:3',
                    'source_currency' => 'required|alpha|min: 3|max:3',
                    'amount' => 'required|numeric'
                ]
            );

            if($validateData->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Not valid data'
                    ], 200
                );
            }

            $target_currency = $request->target_currency;
            $source_currency = $request->source_currency;
            $amount = $request->amount;

            $apiHeadersRequest = [
                'Content-Type' => 'text/plain', 
                'apikey' => env('FIXER_API_TOKEN')
            ];

            $response = Http::withoutVerifying()
                ->withHeaders($apiHeadersRequest)
                ->withOptions(['verify' => false])
                ->get("https://api.apilayer.com/fixer/latest?symbols=" . $target_currency . "&base=" . $source_currency);        
            //$response = '{ "success": true, "symbols": { "AED": "United Arab Emirates Dirham", "AFN": "Afghan Afghani", "ALL": "Albanian Lek", "AMD": "Armenian Dram", "ANG": "Netherlands Antillean Guilder", "AOA": "Angolan Kwanza", "ARS": "Argentine Peso", "AUD": "Australian Dollar", "AWG": "Aruban Florin", "AZN": "Azerbaijani Manat", "BAM": "Bosnia-Herzegovina Convertible Mark", "BBD": "Barbadian Dollar", "BDT": "Bangladeshi Taka", "BGN": "Bulgarian Lev", "BHD": "Bahraini Dinar", "BIF": "Burundian Franc", "BMD": "Bermudan Dollar", "BND": "Brunei Dollar", "BOB": "Bolivian Boliviano", "BRL": "Brazilian Real", "BSD": "Bahamian Dollar", "BTC": "Bitcoin", "BTN": "Bhutanese Ngultrum", "BWP": "Botswanan Pula", "BYN": "New Belarusian Ruble", "BYR": "Belarusian Ruble", "BZD": "Belize Dollar", "CAD": "Canadian Dollar", "CDF": "Congolese Franc", "CHF": "Swiss Franc", "CLF": "Chilean Unit of Account (UF)", "CLP": "Chilean Peso", "CNY": "Chinese Yuan", "COP": "Colombian Peso", "CRC": "Costa Rican Col\u00f3n", "CUC": "Cuban Convertible Peso", "CUP": "Cuban Peso", "CVE": "Cape Verdean Escudo", "CZK": "Czech Republic Koruna", "DJF": "Djiboutian Franc", "DKK": "Danish Krone", "DOP": "Dominican Peso", "DZD": "Algerian Dinar", "EGP": "Egyptian Pound", "ERN": "Eritrean Nakfa", "ETB": "Ethiopian Birr", "EUR": "Euro", "FJD": "Fijian Dollar", "FKP": "Falkland Islands Pound", "GBP": "British Pound Sterling", "GEL": "Georgian Lari", "GGP": "Guernsey Pound", "GHS": "Ghanaian Cedi", "GIP": "Gibraltar Pound", "GMD": "Gambian Dalasi", "GNF": "Guinean Franc", "GTQ": "Guatemalan Quetzal", "GYD": "Guyanaese Dollar", "HKD": "Hong Kong Dollar", "HNL": "Honduran Lempira", "HRK": "Croatian Kuna", "HTG": "Haitian Gourde", "HUF": "Hungarian Forint", "IDR": "Indonesian Rupiah", "ILS": "Israeli New Sheqel", "IMP": "Manx pound", "INR": "Indian Rupee", "IQD": "Iraqi Dinar", "IRR": "Iranian Rial", "ISK": "Icelandic Kr\u00f3na", "JEP": "Jersey Pound", "JMD": "Jamaican Dollar", "JOD": "Jordanian Dinar", "JPY": "Japanese Yen", "KES": "Kenyan Shilling", "KGS": "Kyrgystani Som", "KHR": "Cambodian Riel", "KMF": "Comorian Franc", "KPW": "North Korean Won", "KRW": "South Korean Won", "KWD": "Kuwaiti Dinar", "KYD": "Cayman Islands Dollar", "KZT": "Kazakhstani Tenge", "LAK": "Laotian Kip", "LBP": "Lebanese Pound", "LKR": "Sri Lankan Rupee", "LRD": "Liberian Dollar", "LSL": "Lesotho Loti", "LTL": "Lithuanian Litas", "LVL": "Latvian Lats", "LYD": "Libyan Dinar", "MAD": "Moroccan Dirham", "MDL": "Moldovan Leu", "MGA": "Malagasy Ariary", "MKD": "Macedonian Denar", "MMK": "Myanma Kyat", "MNT": "Mongolian Tugrik", "MOP": "Macanese Pataca", "MRO": "Mauritanian Ouguiya", "MUR": "Mauritian Rupee", "MVR": "Maldivian Rufiyaa", "MWK": "Malawian Kwacha", "MXN": "Mexican Peso", "MYR": "Malaysian Ringgit", "MZN": "Mozambican Metical", "NAD": "Namibian Dollar", "NGN": "Nigerian Naira", "NIO": "Nicaraguan C\u00f3rdoba", "NOK": "Norwegian Krone", "NPR": "Nepalese Rupee", "NZD": "New Zealand Dollar", "OMR": "Omani Rial", "PAB": "Panamanian Balboa", "PEN": "Peruvian Nuevo Sol", "PGK": "Papua New Guinean Kina", "PHP": "Philippine Peso", "PKR": "Pakistani Rupee", "PLN": "Polish Zloty", "PYG": "Paraguayan Guarani", "QAR": "Qatari Rial", "RON": "Romanian Leu", "RSD": "Serbian Dinar", "RUB": "Russian Ruble", "RWF": "Rwandan Franc", "SAR": "Saudi Riyal", "SBD": "Solomon Islands Dollar", "SCR": "Seychellois Rupee", "SDG": "Sudanese Pound", "SEK": "Swedish Krona", "SGD": "Singapore Dollar", "SHP": "Saint Helena Pound", "SLL": "Sierra Leonean Leone", "SOS": "Somali Shilling", "SRD": "Surinamese Dollar", "STD": "S\u00e3o Tom\u00e9 and Pr\u00edncipe Dobra", "SVC": "Salvadoran Col\u00f3n", "SYP": "Syrian Pound", "SZL": "Swazi Lilangeni", "THB": "Thai Baht", "TJS": "Tajikistani Somoni", "TMT": "Turkmenistani Manat", "TND": "Tunisian Dinar", "TOP": "Tongan Pa\u02bbanga", "TRY": "Turkish Lira", "TTD": "Trinidad and Tobago Dollar", "TWD": "New Taiwan Dollar", "TZS": "Tanzanian Shilling", "UAH": "Ukrainian Hryvnia", "UGX": "Ugandan Shilling", "USD": "United States Dollar", "UYU": "Uruguayan Peso", "UZS": "Uzbekistan Som", "VEF": "Venezuelan Bol\u00edvar Fuerte", "VND": "Vietnamese Dong", "VUV": "Vanuatu Vatu", "WST": "Samoan Tala", "XAF": "CFA Franc BEAC", "XAG": "Silver (troy ounce)", "XAU": "Gold (troy ounce)", "XCD": "East Caribbean Dollar", "XDR": "Special Drawing Rights", "XOF": "CFA Franc BCEAO", "XPF": "CFP Franc", "YER": "Yemeni Rial", "ZAR": "South African Rand", "ZMK": "Zambian Kwacha (pre-2013)", "ZMW": "Zambian Kwacha", "ZWL": "Zimbabwean Dollar" } }';
            // $response = '{ "success": true, "timestamp": 1666468024, "base": "USD", "date": "2022-10-22", "rates": { "EUR": 1.01405 } }';        
            $responseData = json_decode($response, true);

            //print_r($responseData);
            // $success_get_rate = true;
            // if($responseData['success'] == false) {
            //     $success_get_rate = false;
            // }
            $rate = $responseData['rates'][strtoupper($target_currency)];
            $converted_amount = $amount * $rate;
            
            // // Insert in database
            DB::insert('insert into conversions (currency_from, currency_to, amount_to_convert, converted_amount, rate, created_at) values (?, ?, ?, ?, ?, ?)', [strtoupper($source_currency), strtoupper($target_currency), $amount, $converted_amount, $rate, now()]);
            
            return response()->json(
                [
                    'status' => $responseData['success'],
                    'source_currency' => strtoupper($source_currency),
                    'target_currency' => strtoupper($target_currency),
                    'conversion_rate' => $rate,
                    'amount_to_convert' => $amount,
                    'converted_amount' => $converted_amount,
                    'rate_date' => $responseData['date']
                ]
            );
        }
        catch(\Throwable $t) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Error: ' . $t->getMessage()
                ], 500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApiConversiosModel  $apiConversiosModel
     * @return \Illuminate\Http\Response
     */
    public function show(ApiConversiosModel $apiConversiosModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApiConversiosModel  $apiConversiosModel
     * @return \Illuminate\Http\Response
     */
    public function edit(ApiConversiosModel $apiConversiosModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApiConversiosModel  $apiConversiosModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApiConversiosModel $apiConversiosModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApiConversiosModel  $apiConversiosModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApiConversiosModel $apiConversiosModel)
    {
        //
    }

    /**
     * Get rate 
     */
    public function getRate(Request $request) {
        try{
            //
            // Validations here
            $validateData = Validator::make(
                $request->all(),
                [
                    'target_currency' => 'required|alpha|min: 3|max:3',
                    'source_currency' => 'required|alpha|min: 3|max:3'
                ]
            );

            if($validateData->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Not valid data. ' . $validateData->errors()
                    ], 200
                );
            }

            $target_currency = $request->target_currency;
            $source_currency = $request->source_currency;

            $apiHeadersRequest = [
                'Content-Type' => 'text/plain', 
                'apikey' => env('FIXER_API_TOKEN')
            ];

            $response = Http::withoutVerifying()
                ->withHeaders($apiHeadersRequest)
                ->withOptions(['verify' => false])
                ->get("https://api.apilayer.com/fixer/latest?symbols=" . $target_currency . "&base=" . $source_currency);        
            //$response = '{ "success": true, "symbols": { "AED": "United Arab Emirates Dirham", "AFN": "Afghan Afghani", "ALL": "Albanian Lek", "AMD": "Armenian Dram", "ANG": "Netherlands Antillean Guilder", "AOA": "Angolan Kwanza", "ARS": "Argentine Peso", "AUD": "Australian Dollar", "AWG": "Aruban Florin", "AZN": "Azerbaijani Manat", "BAM": "Bosnia-Herzegovina Convertible Mark", "BBD": "Barbadian Dollar", "BDT": "Bangladeshi Taka", "BGN": "Bulgarian Lev", "BHD": "Bahraini Dinar", "BIF": "Burundian Franc", "BMD": "Bermudan Dollar", "BND": "Brunei Dollar", "BOB": "Bolivian Boliviano", "BRL": "Brazilian Real", "BSD": "Bahamian Dollar", "BTC": "Bitcoin", "BTN": "Bhutanese Ngultrum", "BWP": "Botswanan Pula", "BYN": "New Belarusian Ruble", "BYR": "Belarusian Ruble", "BZD": "Belize Dollar", "CAD": "Canadian Dollar", "CDF": "Congolese Franc", "CHF": "Swiss Franc", "CLF": "Chilean Unit of Account (UF)", "CLP": "Chilean Peso", "CNY": "Chinese Yuan", "COP": "Colombian Peso", "CRC": "Costa Rican Col\u00f3n", "CUC": "Cuban Convertible Peso", "CUP": "Cuban Peso", "CVE": "Cape Verdean Escudo", "CZK": "Czech Republic Koruna", "DJF": "Djiboutian Franc", "DKK": "Danish Krone", "DOP": "Dominican Peso", "DZD": "Algerian Dinar", "EGP": "Egyptian Pound", "ERN": "Eritrean Nakfa", "ETB": "Ethiopian Birr", "EUR": "Euro", "FJD": "Fijian Dollar", "FKP": "Falkland Islands Pound", "GBP": "British Pound Sterling", "GEL": "Georgian Lari", "GGP": "Guernsey Pound", "GHS": "Ghanaian Cedi", "GIP": "Gibraltar Pound", "GMD": "Gambian Dalasi", "GNF": "Guinean Franc", "GTQ": "Guatemalan Quetzal", "GYD": "Guyanaese Dollar", "HKD": "Hong Kong Dollar", "HNL": "Honduran Lempira", "HRK": "Croatian Kuna", "HTG": "Haitian Gourde", "HUF": "Hungarian Forint", "IDR": "Indonesian Rupiah", "ILS": "Israeli New Sheqel", "IMP": "Manx pound", "INR": "Indian Rupee", "IQD": "Iraqi Dinar", "IRR": "Iranian Rial", "ISK": "Icelandic Kr\u00f3na", "JEP": "Jersey Pound", "JMD": "Jamaican Dollar", "JOD": "Jordanian Dinar", "JPY": "Japanese Yen", "KES": "Kenyan Shilling", "KGS": "Kyrgystani Som", "KHR": "Cambodian Riel", "KMF": "Comorian Franc", "KPW": "North Korean Won", "KRW": "South Korean Won", "KWD": "Kuwaiti Dinar", "KYD": "Cayman Islands Dollar", "KZT": "Kazakhstani Tenge", "LAK": "Laotian Kip", "LBP": "Lebanese Pound", "LKR": "Sri Lankan Rupee", "LRD": "Liberian Dollar", "LSL": "Lesotho Loti", "LTL": "Lithuanian Litas", "LVL": "Latvian Lats", "LYD": "Libyan Dinar", "MAD": "Moroccan Dirham", "MDL": "Moldovan Leu", "MGA": "Malagasy Ariary", "MKD": "Macedonian Denar", "MMK": "Myanma Kyat", "MNT": "Mongolian Tugrik", "MOP": "Macanese Pataca", "MRO": "Mauritanian Ouguiya", "MUR": "Mauritian Rupee", "MVR": "Maldivian Rufiyaa", "MWK": "Malawian Kwacha", "MXN": "Mexican Peso", "MYR": "Malaysian Ringgit", "MZN": "Mozambican Metical", "NAD": "Namibian Dollar", "NGN": "Nigerian Naira", "NIO": "Nicaraguan C\u00f3rdoba", "NOK": "Norwegian Krone", "NPR": "Nepalese Rupee", "NZD": "New Zealand Dollar", "OMR": "Omani Rial", "PAB": "Panamanian Balboa", "PEN": "Peruvian Nuevo Sol", "PGK": "Papua New Guinean Kina", "PHP": "Philippine Peso", "PKR": "Pakistani Rupee", "PLN": "Polish Zloty", "PYG": "Paraguayan Guarani", "QAR": "Qatari Rial", "RON": "Romanian Leu", "RSD": "Serbian Dinar", "RUB": "Russian Ruble", "RWF": "Rwandan Franc", "SAR": "Saudi Riyal", "SBD": "Solomon Islands Dollar", "SCR": "Seychellois Rupee", "SDG": "Sudanese Pound", "SEK": "Swedish Krona", "SGD": "Singapore Dollar", "SHP": "Saint Helena Pound", "SLL": "Sierra Leonean Leone", "SOS": "Somali Shilling", "SRD": "Surinamese Dollar", "STD": "S\u00e3o Tom\u00e9 and Pr\u00edncipe Dobra", "SVC": "Salvadoran Col\u00f3n", "SYP": "Syrian Pound", "SZL": "Swazi Lilangeni", "THB": "Thai Baht", "TJS": "Tajikistani Somoni", "TMT": "Turkmenistani Manat", "TND": "Tunisian Dinar", "TOP": "Tongan Pa\u02bbanga", "TRY": "Turkish Lira", "TTD": "Trinidad and Tobago Dollar", "TWD": "New Taiwan Dollar", "TZS": "Tanzanian Shilling", "UAH": "Ukrainian Hryvnia", "UGX": "Ugandan Shilling", "USD": "United States Dollar", "UYU": "Uruguayan Peso", "UZS": "Uzbekistan Som", "VEF": "Venezuelan Bol\u00edvar Fuerte", "VND": "Vietnamese Dong", "VUV": "Vanuatu Vatu", "WST": "Samoan Tala", "XAF": "CFA Franc BEAC", "XAG": "Silver (troy ounce)", "XAU": "Gold (troy ounce)", "XCD": "East Caribbean Dollar", "XDR": "Special Drawing Rights", "XOF": "CFA Franc BCEAO", "XPF": "CFP Franc", "YER": "Yemeni Rial", "ZAR": "South African Rand", "ZMK": "Zambian Kwacha (pre-2013)", "ZMW": "Zambian Kwacha", "ZWL": "Zimbabwean Dollar" } }';
            // $response = '{ "success": true, "timestamp": 1666468024, "base": "USD", "date": "2022-10-22", "rates": { "EUR": 1.01405 } }';                    

            $responseData = json_decode($response, true);
            
            $success_get_rate = true;
            if($responseData['success'] == false) {
                $success_get_rate = false;
            }
            $rate = $responseData['rates'][strtoupper($target_currency)];            
            
            return response()->json(
                [
                    'status' => $success_get_rate,
                    'source_currency' => strtoupper($source_currency),
                    'target_currency' => strtoupper($target_currency),
                    'conversion_rate' => $rate,                    
                    'rate_date' => $responseData['date']
                ]
            );
        }
        catch(\Throwable $t) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Error: ' . $t->getMessage()
                ], 500
            );
        }
    }

    /**
     * Get currencies
     */
    public function getCurrencies() {
        
        try{            
            $apiHeadersRequest = [
                'Content-Type' => 'text/plain', 
                'apikey' => env('FIXER_API_TOKEN')
            ];

            $response = Http::withoutVerifying()
                ->withHeaders($apiHeadersRequest)
                ->withOptions(['verify' => false])
                ->get("https://api.apilayer.com/fixer/symbols");        
                        
            return response()->json(json_decode($response, true), 200);

        }
        catch(\Throwable $t) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Error: ' . $t->getMessage()
                ], 500
            );
        }

    }

}
