<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckOutRequest;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use http\Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('checkout')->with([
            'newTax' => $this->getNumbers()->get('newTax'),
            'discount' => $this->getNumbers()->get('discount'),
            'newSubTotal' => $this->getNumbers()->get('newSubTotal'),
            'newTotal' => $this->getNumbers()->get('newTotal')
        ]);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CheckOutRequest $request)
    {
        $contents = Cart::content()->map(function($item){
            return $item->model->slug .', '. $item->qty;
        })->values()->toJson();

        try {
            $charge = Stripe::make('sk_test_51GrCQQK0R9dJVTxPRwFom1FuftLM4K8axseiqpThZR3syoLxXR7A7ieRg16k13Dk07t2zYdXdG7lmdbFP29gA5il00sB7ybbze');
            $charge->charges()->create([
                'amount' => $this->getNumbers()->get('newTotal') / 100,
                'currency' => 'AZN',
                'source'   => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson()
                ]
            ]);

            //SUCCESSFUL
            Cart::instance('default')->destroy();
            session()->forget('coupon');

            return redirect()->route('confirmation.index')->with('success_message', 'Thank you! You payment has been successfully accepted');
        }
        catch(CardErrorException $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }
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

    protected function getNumbers()
    {
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newSubTotal = (Cart::subtotal() - $discount);
        $newTax = $newSubTotal * $tax;
        $newTotal = $newSubTotal * (1 + $tax);

        return collect([
            'tax' => $tax,
            'newTax' => $newTax,
            'discount' => $discount,
            'newSubTotal' => $newSubTotal,
            'newTotal' => $newTotal
        ]);
    }
}
