<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use Validator;
use DB;
use OneSignal;

require('../vendor/autoload.php');

class WalletsController extends Controller
{
    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = DB::table('wallets')->get();

        foreach ($wallets as $wallet)
        {
            $amount = $wallet->balance / 100;
            $result = (int)$amount;

            $wallet->balance = number_format(round($result, 2), 2);
        }

        return response()->json($wallets, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllWallets()
    {
        $wallets = DB::table('wallets')->get();
        $users = User::latest()->get();

        foreach ($wallets as $wallet)
        {
            $amount = $wallet->balance / 100;
            $result = (int)$amount;

            $wallet->balance = number_format(round($result, 2), 2);

            foreach ($users as $user) {
                if ($wallet->holder_id == $user->id) {
                    $wallet->user = $user->name . ' ' . $user->last_name;
                }
            }
        }

        return view('admin.wallets.index', compact('wallets'));
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wallets = DB::table('wallets')->where('holder_id', $id)->get();
        $user = User::where('id', $id)->get()->first();

        if (!empty($wallets)) {
            foreach ($wallets as $wallet)
            {
                if ($wallet->name == 'MXN') {
                    $mxn = $user->getWallet('mxn_wallet');
                    $balance_mxn = $mxn->balanceFloat;
                    $balance_mxn = number_format(round($balance_mxn, 2), 2);
                    $wallet->balance = $balance_mxn;
                } else if ($wallet->name == 'UDGC') {
                    $udgc = $user->getWallet('udgc_wallet');
                    $balance_udgc = $udgc->balanceFloat;
                    $balance_udgc = number_format(round($balance_udgc, 2), 2);
                    $wallet->balance = $balance_udgc;
                }
            }

            return response()->json($wallets, 200);

        } else {

            $message = "You don't have wallets yet.";

            return response()->json(array('message' => $message), 200);
        }
    }

    public function getWallets(Request $request)
    {
        $id = $request->user_id;
        $coin = $request->coin;

        $wallets = DB::table('wallets')->where('holder_id', $id)->where('description', $coin)->get();
        $user = User::where('id', $id)->get()->first();

        return response()->json($wallets, 200);
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function balances($id)
    {
        $user = User::where('id', $id)->first();

        if ($user->hasWallet('mxn_wallet') == true) {
            $mxn = $user->getWallet('mxn_wallet');
        } else {
            $mxn = $user->createWallet([
                'name' => 'MXN Wallet',
                'slug' => 'mxn_wallet',
                'description' => 'MXN',
            ]);
        }

        $balance_mxn = $mxn->balanceFloat;
        $balance_mxn = number_format(round($balance_mxn, 2), 2);
        $user->wallet = $mxn;

        if ($user->hasWallet('udgc_wallet') == true) {
            $udgc = $user->getWallet('udgc_wallet');
        } else {
            $udgc = $user->createWallet([
                'name' => 'UDGC Wallet',
                'slug' => 'udgc_wallet',
                'description' => 'UDGC',
            ]);
        }

        $balance_udgc = $udgc->balanceFloat;
        $balance_udgc = number_format(round($balance_udgc, 2), 2);
        $user->wallet = $udgc;

        $balances = new \stdClass();
        $balances->mxn = $balance_mxn;
        $balances->udgc = $balance_udgc;

        return response()->json($balances, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fund(Request $request)
    {
        $quantity = $request->quantity;

        $id = $request->user_id;
        $user = User::where('id', $id)->first();

        if ($user->hasWallet('mxn_wallet') == true) {
            $mxn = $user->getWallet('mxn_wallet');
        } else {
            $mxn = $user->createWallet([
                'name' => 'MXN Wallet',
                'slug' => 'mxn_wallet',
                'description' => 'MXN',
            ]);
        }

        $mxn->depositFloat($quantity);

        $balance = $mxn->balanceFloat;
        $balance = number_format(round($balance, 2), 2);

        $transaction = DB::table('transactions')
                ->latest()
                ->first();

        DB::table('transactions')
            ->where('id', $transaction->id)
            ->update(['concept' => 'Deposito fondos']);

        $message = 'Funds successfully added to your account.';

        return response()->json(array('message' => $message, 'mxn' => $balance), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdraw(Request $request)
    {
        $quantity = $request->quantity;
        $id = $request->user_id;
        $user = User::where('id', $id)->first();

        if ($user->hasWallet('mxn_wallet') == true) {
            $mxn = $user->getWallet('mxn_wallet');
            $balance = $mxn->balanceFloat;
        } else {
            $mxn = $user->createWallet([
                'name' => 'MXN Wallet',
                'slug' => 'mxn_wallet',
                'description' => 'MXN',
            ]);
            $balance = $mxn->balanceFloat;
        }

        if ($quantity > $balance) {

            $balance = $mxn->balanceFloat;
            $balance = number_format(round($balance, 2), 2);
            $message = 'Insufficient funds.';

            return response()->json(array('message' => $message, 'balance' => $balance), 200);

        } else {

            $quantity = $quantity * 1;
            $convert = $quantity * 100;
            $result = (int)$convert;

            $mxn->withdraw($result);
            $balance = $mxn->balanceFloat;
            $balance = number_format(round($balance, 2), 2);
            $message = 'Successfully withdrawal.';

            return response()->json(array('message' => $message, 'mxn' => $balance), 200);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function trade(Request $request)
    {
        $user = User::where('id', $request->user_id)->get()->first();

        if ($request->nip == $user->nip) {

            $id = $request->user_id;
            $user = User::where('id', $id)->first();
            $quantity = $request->quantity;
            $quantity = $quantity / 1;
            $coin = $request->coin;

            if ($user->hasWallet('udgc_wallet') == true) {
                $udgc = $user->getWallet('udgc_wallet');
            } else {
                $udgc = $user->createWallet([
                    'name' => 'UDGC Wallet',
                    'slug' => 'udgc_wallet',
                    'description' => 'UDGC',
                ]);
            }

            if ($coin == 'MXN') {

                if ($user->hasWallet('mxn_wallet') == true) {
                    $mxn = $user->getWallet('mxn_wallet');
                } else {
                    $mxn = $user->createWallet([
                        'name' => 'MXN Wallet',
                        'slug' => 'mxn_wallet',
                        'description' => 'MXN',
                    ]);
                }

                $balance_mxn = $mxn->balanceFloat;

                if ($balance_mxn < $quantity) {
                    $message = 'Insufficient funds.';

                    return response()->json(array('message' => $message, 'mxn' => $balance_mxn), 200);
                } else {
                    $quantity = (int)$quantity;
                    $result = $quantity * 100;
                }

                if ($user->hasWallet('udgc_wallet') == true) {
                    $udgc = $user->getWallet('udgc_wallet');
                } else {
                    $udgc = $user->createWallet([
                        'name' => 'UDGC Wallet',
                        'slug' => 'udgc_wallet',
                        'description' => 'UDGC',
                    ]);
                }

                $balance_mxn = $mxn->balanceFloat;

                $transfer = $mxn->transfer($udgc, $result);

                $balance_mxn = $mxn->balanceFloat;
                $balance_mxn = number_format(round($balance_mxn, 2), 2);

                $transactions = DB::table('transactions')
                    ->latest()
                    ->take(2)
                    ->get();

                DB::table('transactions')
                    ->where('id', $transactions[0]->id)
                    ->update(['concept' => 'Intercambio MXNUDGC']);

                DB::table('transactions')
                    ->where('id', $transactions[1]->id)
                    ->update(['concept' => 'Intercambio MXNUDGC']);

                $message = 'Successfully exchanged.';

                return response()->json(array('message' => $message, 'mxn' => $balance_mxn), 200);

            } elseif  ($coin == 'UDGC') {
                if ($user->hasWallet('udgc_wallet') == true) {
                    $udgc = $user->getWallet('udgc_wallet');
                } else {
                    $udgc = $user->createWallet([
                        'name' => 'UDGC Wallet',
                        'slug' => 'udgc_wallet',
                        'description' => 'UDGC',
                    ]);
                }

                $balance_udgc = $udgc->balanceFloat;

                if ($balance_udgc < $quantity) {
                    $message = 'Insufficient funds.';

                    return response()->json(array('message' => $message, 'udgc' => $balance_udgc), 200);
                } else {
                    $quantity = (int)$quantity;
                    $result = $quantity * 100;
                }

                if ($user->hasWallet('mxn_wallet') == true) {
                    $mxn = $user->getWallet('mxn_wallet');
                } else {
                    $mxn = $user->createWallet([
                        'name' => 'MXN Wallet',
                        'slug' => 'mxn_wallet',
                        'description' => 'MXN',
                    ]);
                }

                $balance_udgc = $udgc->balanceFloat;

                $transfer = $udgc->transfer($mxn, $result);

                $balance_udgc = $udgc->balanceFloat;
                $balance_udgc = number_format(round($balance_udgc, 2), 2);

                $transactions = DB::table('transactions')
                    ->latest()
                    ->take(2)
                    ->get();

                DB::table('transactions')
                    ->where('id', $transactions[0]->id)
                    ->update(['concept' => 'Intercambio UDGCMXN']);

                DB::table('transactions')
                    ->where('id', $transactions[1]->id)
                    ->update(['concept' => 'Intercambio UDGCMXN']);

                $message = 'Successfully exchanged.';

                return response()->json(array('message' => $message, 'udgc' => $balance_udgc), 200);
            }

        } else {
            $message = 'Incorrect NIP';

            return response()->json(array('message' => $message), 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request)
    {
        $user = User::where('id', $request->from)->get()->first();

        if ($request->nip == $user->nip) {

            $from = User::where('id', $request->from)->first();
            $to = User::where('id', $request->to)->first();

            $amount = $request->amount;
            $coin = $request->coin;
            $concept = $request->concept;
            $amount = $amount / 1;

            if ($coin == 'MXN') {

                if ($from->hasWallet('mxn_wallet') == true) {
                    $firstWallet = $from->getWallet('mxn_wallet');
                    $balance = $firstWallet->balanceFloat;
                } else {
                    $firstWallet = $from->createWallet([
                        'name' => 'MXN Wallet',
                        'slug' => 'mxn_wallet',
                        'description' => 'MXN',
                    ]);
                    $balance = $firstWallet->balanceFloat;
                }

                $balance = $firstWallet->balanceFloat;

                if ($balance < $amount) {
                    $message = 'Insufficient funds.';

                    return response()->json(array('message' => $message, 'mxn' => $balance), 200);
                } else {
                    $amount = (int)$amount;
                    $result = $amount * 100;
                }

                if ($to->hasWallet('mxn_wallet') == true) {
                    $lastWallet = $to->getWallet('mxn_wallet');
                    $balance = $lastWallet->balanceFloat;
                } else {
                    $lastWallet = $to->createWallet([
                        'name' => 'MXN Wallet',
                        'slug' => 'mxn_wallet',
                        'description' => 'MXN',
                    ]);
                    $balance = $lastWallet->balanceFloat;
                }

                $firstWallet->transfer($lastWallet, $result);

                $firstWalletBalance = $firstWallet->balanceFloat;

                $data = new \stdClass();
                $data->from_balance = $firstWalletBalance;
                $amount = (float)$request->amount;
                $data->amount_transfered = number_format(round($amount, 2), 2);

                $transactions = DB::table('transactions')
                    ->latest()
                    ->take(2)
                    ->get();

                DB::table('transactions')
                  ->where('id', $transactions[0]->id)
                  ->update(['concept' => $request->concept]);

                DB::table('transactions')
                  ->where('id', $transactions[1]->id)
                  ->update(['concept' => $request->concept]);

                $user_token = DB::table('user_tokens')->where('user_id', '=', $to->id)->get()->first();

                // $userId = '1b8f8120-7133-4ccd-aef6-1748d4ebacca';
                $userId = $user_token->token;

                OneSignal::sendNotificationToUser(
                    "Recibiste un pago a través de CryptoUDGCoin Transfer. 📲\nFondos añadidos a tu cartera. 💰",
                    $userId
                );

                $message = 'Successfully transfered.';

                return response()->json(array('message' => $message, 'data' => $data), 200);

            } else if ($coin == 'UDGC') {
                if ($from->hasWallet('udgc_wallet') == true) {
                    $firstWallet = $from->getWallet('udgc_wallet');
                    $balance = $firstWallet->balanceFloat;
                } else {
                    $firstWallet = $from->createWallet([
                        'name' => 'UDGC Wallet',
                        'slug' => 'udgc_wallet',
                        'description' => 'UDGC',
                    ]);
                    $balance = $firstWallet->balanceFloat;
                }

                $balance = $firstWallet->balanceFloat;

                if ($balance < $amount) {
                    $message = 'Insufficient funds.';

                    return response()->json(array('message' => $message, 'mxn' => $balance), 200);
                } else {
                    $amount = (int)$amount;
                    $result = $amount * 100;
                }

                if ($to->hasWallet('udgc_wallet') == true) {
                    $lastWallet = $to->getWallet('udgc_wallet');
                    $balance = $lastWallet->balanceFloat;
                } else {
                    $lastWallet = $to->createWallet([
                        'name' => 'UDGC Wallet',
                        'slug' => 'udgc_wallet',
                        'description' => 'UDGC',
                    ]);
                    $balance = $lastWallet->balanceFloat;
                }

                $firstWallet->transfer($lastWallet, $result);

                $firstWalletBalance = $firstWallet->balanceFloat;

                $data = new \stdClass();
                $data->from_balance = $firstWalletBalance;
                $amount = (float)$request->amount;
                $data->amount_transfered = number_format(round($amount, 2), 2);

                $transactions = DB::table('transactions')
                    ->latest()
                    ->take(2)
                    ->get();

                DB::table('transactions')
                  ->where('id', $transactions[0]->id)
                  ->update(['concept' => $request->concept]);

                DB::table('transactions')
                  ->where('id', $transactions[1]->id)
                  ->update(['concept' => $request->concept]);

                $user_token = DB::table('user_tokens')->where('user_id', '=', $to->id)->get()->first();

                // $userId = '1b8f8120-7133-4ccd-aef6-1748d4ebacca';
                $userId = $user_token->token;

                OneSignal::sendNotificationToUser(
                    "Recibiste un pago a través de CryptoUDGCoin Transfer. 📲\nFondos añadidos a tu cartera. 💰",
                    $userId
                );

                $message = 'Successfully transfered.';

                return response()->json(array('message' => $message, 'data' => $data), 200);
            }

        } else {
            $message = 'Incorrect NIP';

            return response()->json(array('message' => $message), 200);
        }
    }
}
