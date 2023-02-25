<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->role == 'admin') {
            $creators_awaiting_approval = Payment::where('payment_status', 'requested')->groupBy('creator_id')->orderBy('created_at', 'desc')->get();
            return view('admin.withdrawals', compact('creators_awaiting_approval'));
        } else {
            $polls = Poll::query()->whereNull('archived_at')->when('q', function ($query) use ($request) {
                return $query->where('question', 'LIKE', "%$request->q%")->orWhereHas('user', function ($query) use ($request) {
                    return $query->where('name', 'LIKE', "%{$request->q}%");
                });
            })->latest()->paginate(10);
            return view('home', compact('polls'));
        }
    }
}
