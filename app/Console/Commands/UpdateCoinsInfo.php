<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class UpdateCoinsInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:coinsinfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update CoinMarketCap 10 latest coins information';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = config('app.coins_info_url');

        $coins = DB::table('coins')->latest()->get()->first();
        $coins_ids = array();
        $coins = json_decode($coins->data);

        foreach($coins as $coin)
        {
            array_push($coins_ids, $coin->id);
        }

        $array_values = array_values($coins_ids);
        $imploded_array = implode( ",", $coins_ids);

        $parameters = [
          'id' => ''.$imploded_array.''
        ];

        $headers = [
          'Accepts: application/json',
          'X-CMC_PRO_API_KEY: ' . config('app.api_key_two')
        ];

        $qs = http_build_query($parameters);

        $request = "{$url}?{$qs}";

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $request,
          CURLOPT_HTTPHEADER => $headers,
          CURLOPT_RETURNTRANSFER => 1
        ));

        $response = curl_exec($curl);
        $coins_response = json_decode($response);
        $coins = $coins_response->data;

        curl_close($curl);

        $data = json_encode($coins);
        $now = Carbon::now();

        DB::table('coins_info')->insert(
            ['data' => $data, 'created_at' => $now, 'updated_at' => $now]
        );
    }
}
