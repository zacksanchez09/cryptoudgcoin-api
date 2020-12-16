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
use App\Notifications\ContactFormNotification;
use Carbon\Carbon;

require('../vendor/autoload.php');

class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * Login
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Cryptoudgcoin')-> accessToken;
            $now = Carbon::now();

            DB::table('user_tokens')->insert(
                ['token' => $request->token, 'user_id' => $user->id, 'created_at' => $now, 'updated_at' => $now]
            );

            if ($user->hasRole('admin')) {
                $role = 1;
                $user->role_id = $role;
                $user->role = 'Admin';
            } else if ($user->hasRole('user')) {
                $role = 2;
                $user->role_id = $role;
                $user->role = 'User';
            }

            return response()->json(['successToken' => $success['token'], 'user' => $user], $this-> successStatus);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Register
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = new \stdClass();
        $data->email = $request->email;
        $data->cellphone = $request->phone;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['nip'] = '0000';
        $user = User::create($input);
        $success['token'] = $user->createToken('Cryptoudgcoin')-> accessToken;
        $success['user'] = $user;

        $user->roles()->attach(Role::where('name', 'user')->first());

        // Test API Key
        \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
        \Conekta\Conekta::setLocale('es');

        // Prod API Key
        /*
        \Conekta\Conekta::setApiKey("");
        \Conekta\Conekta::setLocale('es');
        */

        $user = User::find($user->id);

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

        DB::table('users')
            ->where('id', $user->id)
            ->update(['conekta_customer_id' => $customer->id]);

        $mxn = $user->createWallet([
            'name' => 'MXN',
            'slug' => 'mxn_wallet'
        ]);

        $udgc = $user->createWallet([
            'name' => 'UDGC',
            'slug' => 'udgc_wallet'
        ]);

        if ($user->hasRole('admin')) {
            $role = 1;
            $user->role = $role;
        } else if ($user->hasRole('user')) {
            $role = 2;
            $user->role = $role;
        }

        return response()->json(['success' => $success], $this-> successStatus);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();

        return $users;
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
        $user = User::where('id', $id)->get()->first();

        return response()->json(array('user' => $user), 200);
    }

    public function updateNip(Request $request)
    {
        $user = User::where('id', $request->user_id)->get()->first();

        if ($request->old_nip == $user->nip) {
             if ($request->nip == $request->new_nip) {
                $user->nip = $request->nip;
                $user->save();
            } else {
                $message = 'NIP are different.';

                return response()->json(array('message' => $message), 200);
            }
        } else {
            $message = 'Incorrect NIP';

            return response()->json(array('message' => $message), 200);
        }

        return response()->json($user, 200);
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
        User::find($id)->update($request->all());

        $user = User::where('id', $id)->first();

        return response()->json(array('user' => $user), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $user = User::where('id', $request->user_id)->get()->first();

        if ($request->password == $request->new_password) {
            $user->password = bcrypt($request->password);
            $user->save();

            $message = 'Password successfully updated.';

            return response()->json(array('message' => $message), 200);

        } else {
            $message = 'Passwords are different.';

            return response()->json(array('message' => $message), 200);
        }
    }

    public function contactForm(Request $request, User $user)
    {
        $user->email = 'iasociety.developers@gmail.com';
        $user->notify(new ContactFormNotification($user, $request));

        $message = 'Message sent successfully.';

        return response()->json(array('message' => $message), 200);
    }

    public function allFunds()
    {
        $funds = DB::table('conekta_payments')->latest()->get();
        $transactions = DB::table('transactions')->latest()->get();
        $users = User::latest()->get();

        foreach ($funds as $fund) {
            $fund->data = json_decode($fund->data);

            $amount = $fund->data->amount / 100;
            $result = (int)$amount;

            $fund->amount = number_format(round($result, 2), 2);

            foreach ($transactions as $transaction) {
                foreach ($users as $user) {
                    if ($transaction->payable_id == $user->id) {
                        $transaction->user = $user->name . ' ' . $user->last_name;
                        $fund->user = $transaction->user;
                    }
                }
            }

            $charge_data = $fund->data->charges->data;

            foreach ($charge_data as $data) {
                $type = $data->payment_method->type;
                $fund->type = $type;
            }
        }

        return view('admin.funds.index', compact('funds'));
    }

    public function userRechargues($id)
    {
        $user = User::where('id', $id)->get()->first();

        $rechargues = DB::table('transactions')->where('payable_id', $id)->latest()->get();

        return $rechargues;
    }

    public function oxxoPaymentDetail($id)
    {
        $transaction = DB::table('transactions')->where('id', $id)->get()->first();

        $payment = DB::table('conekta_payments')->where('transaction_id', $transaction->id)->get()->first();

        $order = json_decode($payment->data);

        return response()->json(array('order' => $order), 200);
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
