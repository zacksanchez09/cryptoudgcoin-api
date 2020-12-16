<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

require('../vendor/autoload.php');

class ConektaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

    /**
     * Return a new Oxxo Payment Order.
     *
     * @return \Illuminate\Http\Response
     */
    public function oxxoPayment(Request $request)
    {
        \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
        \Conekta\Conekta::setLocale('es');

        $user = User::where('id', $request->user_id)->get()->first();
        $quantity = $request->quantity;
        $quantity = ($quantity * 100);

        try{
          $thirty_days_from_now = (new \DateTime())->add(new \DateInterval('P30D'))->getTimestamp();

          $order = \Conekta\Order::create(
            [
              "line_items" => [
                [
                  "name" => "Fondeo a Cartera MXN",
                  "unit_price" => $quantity,
                  "quantity" => 1
                ]
              ],
              "currency" => "MXN",
              "customer_info" => [
                "name" => $user->name,
                "email" => $user->email,
                "phone" => $user->phone
              ],
              "charges" => [
                [
                  "payment_method" => [
                    "type" => "oxxo_cash",
                    "expires_at" => $thirty_days_from_now
                  ]
                ]
              ]
            ]
          );

          $description = 'Fondeo a cartera con Pago en Oxxo.';
          $user_id = $user->id;
          $type = 'Oxxo';
          $quantity = $request->quantity;

          $user = User::where('id', $user_id)->first();

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
              ->update(['concept' => $description]);

          $data = json_encode($order);

          DB::table('conekta_payments')->insert(
              [
                'transaction_id' => $transaction->id,
                'data' => $data,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
              ]
          );

          // dd($order);
        } catch (\Conekta\ParameterValidationError $error){
          $bug = $error->getMessage();
          dd($bug);
        } catch (\Conekta\Handler $error){
          $bug = $error->getMessage();
          dd($bug);
        }

        return response()->json(['order' => $order], 200);
    }

    /**
     * Return a new Card Payment Order.
     *
     * @return \Illuminate\Http\Response
     */
    public function cardPayment(Request $request)
    {
        \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
        \Conekta\Conekta::setLocale('es');

        $user = User::where('id', $request->user_id)->get()->first();
        $quantity = $request->quantity;
        $quantity = ($quantity * 100);
        $conekta_token_id = $request->conekta_token_id;

        try{
          $thirty_days_from_now = (new \DateTime())->add(new \DateInterval('P30D'))->getTimestamp();

          $order = \Conekta\Order::create(
            [
              "line_items" => [
                [
                  "name" => "Deposito con Tarjeta",
                  "unit_price" => $quantity,
                  "quantity" => 1
                ]
              ],
              "currency" => "MXN",
              "customer_info" => [
                "name" => $user->name,
                "email" => $user->email,
                "phone" => $user->phone
              ],
              "charges" => [
                [
                  "payment_method" => [
                    "type" => "card",
                    "token_id" => $conekta_token_id
                  ]
                ]
              ]
            ]
          );

          $description = 'Fondeo a cartera con Tarjeta';
          $user_id = $user->id;
          $quantity = $request->quantity;

          $user = User::where('id', $user_id)->first();

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
              ->update(['concept' => $description]);

          $data = json_encode($order);

          DB::table('conekta_payments')->insert(
              [
                'transaction_id' => $transaction->id,
                'data' => $data,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
              ]
          );

          // dd($order);
        } catch (\Conekta\ParameterValidationError $error){
          $bug = $error->getMessage();
          dd($bug);
        } catch (\Conekta\Handler $error){
          $bug = $error->getMessage();
          dd($bug);
        }

        return response()->json(['order' => $order], 200);
    }

    public function addCustomer(Request $request)
    {
        // Test API Key
        \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
        \Conekta\Conekta::setLocale('es');

        // Prod API Key
        /*
        \Conekta\Conekta::setApiKey("");
        \Conekta\Conekta::setLocale('es');
        */
        $user = User::find($request->user_id);
        try{
            $customer = \Conekta\Customer::create(
                [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => $request->phone,
                ]
            );

        }catch (\Conekta\ParameterValidationError $error){
            $bug = $error->getMessage();
            return response()->json(['bug' => $bug], 200);

        } catch (\Conekta\Handler $error){
            $bug = $error->getMessage();
            return response()->json(['bug' => $bug], 200);
        }

        $user->conekta_customer_id = $customer->id;
        $user->save();

        return response()->json(['customer' => $customer], 200);
    }

    public function addCard(Request $request)
    {
        // Test API Key
        \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
        \Conekta\Conekta::setLocale('es');

        // Prod API Key
        //\Conekta\Conekta::setApiKey("");
        //\Conekta\Conekta::setLocale('es');

        $user = User::find($request->user_id);

        $customer = \Conekta\Customer::find($user->conekta_customer_id);

        $source = $customer->createPaymentSource([
          'token_id' => $request->conekta_token_id,
          'type'     => 'card'
        ]);

        DB::table('user_cards')->insert(
            [
              'user_id' => $request->user_id,
              'conekta_token_id' => $request->conekta_token_id,
              'parent_id' => $source->parent_id,
              'last4' => $source->last4,
              'brand' => $source->brand,
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now()
            ]
        );

        return response()->json(['source' => $source], 200);
    }

    public function destroyCard(Request $request)
    {
        \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
        \Conekta\Conekta::setLocale('es');

        // Prod API Key
        //\Conekta\Conekta::setApiKey("");
        //\Conekta\Conekta::setLocale('es');

        $user = User::find($request->user_id);

        $customer = \Conekta\Customer::find($user->conekta_customer_id);

        $source = $customer->payment_sources[$request->source_index]->delete();

        $message = 'Card successfully deleted.';

        return response()->json(['message' => $message], 200);
    }

    public function getCardById(Request $request)
    {
        \Conekta\Conekta::setApiKey("key_eYvWV7gSDkNYXsmr");
        \Conekta\Conekta::setLocale('es');

        // Prod API Key
        //\Conekta\Conekta::setApiKey("");
        //\Conekta\Conekta::setLocale('es');

        $user = User::find($request->user_id);

        $customer = \Conekta\Customer::find($user->conekta_customer_id);

        return response()->json(['cards' => $customer->payment_sources], 200);
    }

    public function getCardsByUser($id)
    {
        \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
        \Conekta\Conekta::setLocale('es');

        // Prod API Key
        //\Conekta\Conekta::setApiKey("");
        //\Conekta\Conekta::setLocale('es');

        $user = User::find($id);

        $customer = \Conekta\Customer::find($user->conekta_customer_id);

        $cards = array($customer->payment_sources);

        return $cards;
    }

    public function addPaymentMethod(Request $request)
    {
        // Test API Key
        \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
        \Conekta\Conekta::setLocale('es');

        // Prod API Key
        //\Conekta\Conekta::setApiKey("");
        //\Conekta\Conekta::setLocale('es');

        $user = User::find($request->user_id);

        $customer = \Conekta\Customer::find($user->conekta_customer_id);

        $source = $customer->createPaymentSource([
          'token_id' => $request->conekta_token_id,
          'type'     => 'card',
        ]);
        return response()->json(['source' => $source], 200);
    }
}
