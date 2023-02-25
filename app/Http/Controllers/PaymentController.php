<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PremiumStars;
use App\Models\User;
use Illuminate\Http\Request;
use Omnipay\Omnipay;

class PaymentController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT'));
        $this->gateway->setSecret(env('PAYPAL_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function pay(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'creator_id' => 'required|integer|exists:users,id'
        ]);
        try {
            session()->put('creator_id', $request->creator_id);
            $response = $this->gateway->purchase([
                'amount' => $request->amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('payment.success'),
                'cancelUrl' => route('payment.cancel')
            ])->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function success(Request $request)
    {
        $creator_id = session('creator_id');
        $creator = User::findorfail($creator_id);
        session()->remove('creator_id');
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $arr = $response->getData();
                $payment = new Payment();
                $payment->creator_id = $creator_id;
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = 'settled';
                auth()->user()->payments()->save($payment);
                $payment->save();
                $creator->balance += $payment->amount;
                $creator->save();
                if (PremiumStars::where(['user_id' => auth()->id(), 'creator_id' => $creator_id])->count() > 0) {
                    $ps = PremiumStars::where(['user_id' => auth()->id(), 'creator_id' => $creator_id])->first();
                    $ps->stars = $ps->stars + $payment->amount * ($creator->star_rate ?? 10);
                    $ps->save();
                } else {
                    $ps = PremiumStars::create(['user_id' => auth()->id(), 'creator_id' => $creator_id, 'stars' => $payment->amount * 10]);
                }
                return redirect()->route('profile', $payment->creator_id)->with(['alert-type' => 'success', 'alert' => 'Payment successful.']);
            } else {
                return redirect()->route('profile', $creator_id)->with(['alert-type' => 'danger', 'alert' => 'Payment failed.']);
            }
        } else {
            return redirect()->route('profile', $creator_id)->with(['alert-type' => 'danger', 'alert' => 'Payment failed.']);
        }
    }

    public function cancel()
    {
        $creator_id = session('creator_id');
        session()->remove('creator_id');
        return redirect()->route('profile', $creator_id)->with(['alert-type' => 'danger', 'alert' => 'Payment failed.']);
    }
}
