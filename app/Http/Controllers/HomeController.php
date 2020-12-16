<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::latest()->get();
        $transactions = DB::table('transactions')->latest()->get();
        $wallets = DB::table('wallets')->get();
        $funds = DB::table('transactions')->where('type', '=', 'deposit')->sum('amount');

        $deposit = $funds / 100;
        $result = (int)$deposit;
        $funds = number_format(round($result, 2), 2);

        $withdraws = DB::table('transactions')->where('type', '=', 'withdraw')->sum('amount');

        $withdraw = $withdraws / 100;
        $result = (int)$withdraw;
        $withdraws = number_format(round($result, 2), 2);

        return view('admin.index', compact('users', 'transactions', 'wallets', 'funds', 'withdraws'));
    }
}
