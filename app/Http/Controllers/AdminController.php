<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function approve_withdrawal($creator_id)
    {
        $creator = User::findorfail($creator_id);
        $creator->c_payments()->where('payment_status', 'requested')->update(['payment_status' => 'withdrawn']);
        $creator->update(['balance' => 0]);
        return redirect()->back()->with(['alert' => 'Withdrawal approved.', 'alert-type' => 'success']);
    }
}
