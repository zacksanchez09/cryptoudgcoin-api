<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = DB::table('transactions')->latest()->get();

        foreach ($transactions as $transaction)
        {
            $amount = $transaction->amount / 100;
            $result = (int)$amount;

            $transaction->amount = number_format(round($result, 2), 2);
            // $transaction->amount = number_format(round($transaction->amount, 2), 2);
            $transaction->meta = 0;
        }

        return $transactions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTransactions()
    {
        $transactions = DB::table('transactions')->latest()->get();
        $users = User::latest()->get();
        $wallets = DB::table('wallets')->latest()->get();

        foreach ($transactions as $transaction)
        {
            $amount = $transaction->amount / 100;
            $result = (int)$amount;

            $transaction->amount = number_format(round($result, 2), 2);
            $transaction->meta = 0;

            foreach ($users as $user) {
                if ($transaction->payable_id == $user->id) {
                    $transaction->user = $user->name . ' ' . $user->last_name;
                }
            }

            foreach ($wallets as $wallet)
            {
                $amount = $wallet->balance / 100;
                $result = (int)$amount;

                $wallet->balance = number_format(round($result, 2), 2);

                if ($transaction->wallet_id == $wallet->id) {
                    $transaction->wallet = $wallet;
                }
            }
        }

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userTransactions($id)
    {
        $transactions = DB::table('transactions')->where('payable_id', $id)->latest()->get();
        $user = User::where('id', $id)->get()->first();
        $wallets = DB::table('wallets')->where('holder_id', $id)->latest()->get();

        foreach ($transactions as $transaction)
        {
            $amount = $transaction->amount / 100;
            $result = (int)$amount;

            $transaction->amount = number_format(round($result, 2), 2);
            $transaction->meta = 0;

            if ($transaction->payable_id == $user->id) {
                $transaction->user = $user->name . ' ' . $user->last_name;
            }

            foreach ($wallets as $wallet)
            {
                $amount = $wallet->balance / 100;
                $result = (int)$amount;

                $wallet->balance = number_format(round($result, 2), 2);

                if ($transaction->wallet_id == $wallet->id) {
                    $transaction->wallet = $wallet;
                }
            }
        }

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCharts()
    {
        return view('admin.charts.index');
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
        $transactions = DB::table('transactions')->where('payable_id', $id)->latest()->get();

        foreach ($transactions as $transaction)
        {
            $amount = $transaction->amount / 100;
            $result = (int)$amount;

            $transaction->amount = number_format(round($result, 2), 2);
            $transaction->meta = 0;
        }

        return $transactions;
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
