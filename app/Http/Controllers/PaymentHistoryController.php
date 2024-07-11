<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentHistory;

class PaymentHistoryController extends Controller
{
    public function index()
    {
        $paymentHistories = PaymentHistory::all();
        return view('admin.paymenthistory', compact('paymentHistories'));
    }
}
