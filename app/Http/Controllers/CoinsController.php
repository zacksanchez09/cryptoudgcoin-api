<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\Psr6CacheStorage;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Carbon\Carbon;
use DB;

class CoinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coins_info = DB::table('coins_info')->latest()->get()->first();
        $coins = DB::table('coins')->latest()->get()->first();

        $coinsObject = new \stdClass();
        $coins_ids = array();

        $coins_info = json_decode($coins_info->data);
        $coins = json_decode($coins->data);

        $coinsObject->coins_info = $coins_info;
        $coinsObject->coins = $coins;

        foreach($coinsObject->coins_info as $coin_info)
        {
            foreach($coinsObject->coins as $coin)
            {
                if($coin_info->symbol == $coin->symbol)
                {
                    $coinObj = (object)$coin;
                    $coinObj->logo = $coin_info->logo;
                }
            }
        }

        return response()->json(['coins' => $coinsObject->coins]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function latestCoins(CoinMarketCap $coinMarketCap)
    {
        // $bitcoinInfo = $this->getCryptoCurrencyInformation("bitcoin", "MXN");
        // $ethereumInfo = $this->getCryptoCurrencyInformation("ethereum", "MXN");
        // $rippleInfo = $this->getCryptoCurrencyInformation("ripple", "MXN");
        // $litecoinInfo = $this->getCryptoCurrencyInformation("litecoin", "MXN");

        // return response()->json(['bitcoin' => $bitcoinInfo, 'ethereum' => $ethereumInfo, 'ripple' => $rippleInfo, 'litecoin' => $litecoinInfo]);
    }

    /**
     * Retrieves the complete information providen by the coinmarketcap API from a single currency.
     * By default returns only the value in USD.
     *
     * WARNING: do not use this code in production, it's just to explain how the API works and how
     * can the information be retrieved. See step 3 for final implementation.
     *
     * @param string $currencyId Identifier of the currency
     * @param string $convertCurrency
     * @see https://coinmarketcap.com/api/
     * @return mixed
     */
     private function getCryptoCurrencyInformation($currencyId, $convertCurrency = "MXN")
     {
        $bitsoKey = config('app.api_key_public');
        $bitsoSecret = config('app.api_key_private');
        $nonce = round(microtime(true) * 1000);
        $HTTPMethod = "POST";
        $RequestPath = "/v3/orders/";
        $JSONPayload = json_encode(['book'  => 'btc_mxn',
                              'side'  => 'buy',
                              'major' => '.01',
                              'price' => '1000',
                              'type'  => 'limit']);

        // Create signature
        $message = $nonce . $HTTPMethod . $RequestPath . $JSONPayload;
        $signature = hash_hmac('sha256', $message, $bitsoSecret);

        // Build the auth header
        $format = 'Bitso %s:%s:%s';
        $authHeader =  sprintf($format, $bitsoKey, $nonce, $signature);


        // Send request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('app.fees_url'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $JSONPayload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: ' .  $authHeader,
        'Content-Type: application/json'));
        $result = curl_exec($ch);

        echo $result;
    }

    /**
     * Returns a GuzzleClient that uses a cache manager, so you will use the API without any problem and
     * request many times as you want.
     *
     * The cache last 10 minutes as recommended in the API.
     */
    private function getGuzzleFileCachedClient(){
        // Create a HandlerStack
        $stack = HandlerStack::create();

        // 10 minutes to keep the cache
        $TTL = 600;

        // Retrieve the cache folder path of your Laravel Project
        $cacheFolderPath = base_path() . "/bootstrap";

        // Instantiate the cache storage: a PSR-6 file system cache with
        // a default lifetime of 10 minutes (60 seconds).
        $cache_storage = new Psr6CacheStorage(
            new FilesystemAdapter(
                // Create Folder GuzzleFileCache inside the providen cache folder path
                'GuzzleFileCache',
                $TTL,
                $cacheFolderPath
            )
        );

        // Add Cache Method
        $stack->push(
            new CacheMiddleware(
                new GreedyCacheStrategy(
                    $cache_storage,
                    600 // the TTL in seconds
                )
            ),
            'greedy-cache'
        );

        // Initialize the client with the handler option and return it
        return new Client(['handler' => $stack]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
