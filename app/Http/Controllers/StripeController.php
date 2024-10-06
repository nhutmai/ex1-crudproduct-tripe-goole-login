<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Stripe\Exception\ApiErrorException;
class StripeController extends Controller
{
    public function stripe(Request $request){
        $request->validate([
            'product_name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);
        $stripe= new \Stripe\StripeClient(config('stripe.stripe_secret'));

        try {
            $response= $stripe->checkout->sessions->create([
                'line_items'=>[
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name'=> $request->product_name,
                            ],
                            'unit_amount'=> $request->price*100
                        ],
                        'quantity'=>$request->quantity
                    ]
                ],
                'mode'=>'payment',
                'success_url'=>route('success'). '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'=>route('cancel'),
            ]);
            if(isset($response['id'])&&$response['id']!=='') {
                session()->put('product_name',request('product_name'));
                session()->put('quantity',request('quantity'));
                session()->put('price',request('price'));

                return redirect($response->url);
            }
        }catch (ApiErrorException $e){
            return redirect()->route('user.products.index')->with('error',$e->getMessage());
        }

        return redirect()->route('user.products.index')->with('error','Payment failed!');
    }
    public function success(Request $request){
        $stripe= new \Stripe\StripeClient(config('stripe.stripe_secret'));

        try {
            $response= $stripe->checkout->sessions->retrieve($request->session_id);
            //duùng model payment để lưu thanh toán
            $payment= new Payment();
            $payment->payment_id=$response->id;
            $payment->product_name=session('product_name');
            $payment->quantity=session('quantity');
            $payment->amount=session('price');
            $payment->currency=$response['currency'];
            $payment->payer_name=$response->customer_details->name;
            $payment->payer_email=$response->customer_details->email;
            $payment->status=$response['status'];
            $payment->method="Stripe";
            $payment->save();

            //xóa bỏ các session đang lưu
            session()->forget('product_name');
            session()->forget('quantity');
            session()->forget('price');

            return redirect()->route('user.products.index')->with('success','Payment success');
        }
        catch (ApiErrorException $e){
            return redirect()->route('user.products.index')->with('error',$e->getMessage());
        }
    }
    public function cancel(Request $request){
        return redirect()->route('user.products.index')->with('error','Payment failed!');
    }
}
