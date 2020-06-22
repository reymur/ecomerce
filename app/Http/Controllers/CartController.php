<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $mightAlsoLike = Product::mightAlsoLike()->get();

        return view('cart')->with('mightAlsoLike', $mightAlsoLike);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if($validator->fails()){
            session()->flash('errors', collect(['quantity must be between 1 and 5!']));
            return response()->json(['success',false], 400);
        }

        Cart::update($id, $request->quantity);

        session()->flash('success_message','Quantity was successfully updated!');

        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $duplikates = Cart::search(function($cartItem,$rowId) use ($request){
            return $cartItem->id === $request->id;
        });

        if($duplikates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success_message','Item is already in your cart');
        }

        Cart::add($request->id, $request->name, 1, $request->price)->associate('App\Product');

        return redirect()->route('cart.index')->with('success_message','Item added to your cart');
    }

    public function destroy($id)
    {
        Cart::remove($id);

        return redirect()->route('cart.index')->with('success_message', 'Item has been removed!');
    }

    public function switchToSaveForLater($id)
    {
        $item = Cart::get($id);

        Cart::remove($id);

        $dublikates = Cart::instance('saveForLater')->search(function($cartItem, $rowId) use ($id) {
            return $rowId === $id;
        });

       if($dublikates->isNotEmpty()){
           return redirect()->route('cart.index')
                            ->with('success_message','Item is already saved for later!');
       }

        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Product');

        return redirect()->route('cart.index')->with('success_message','Item has been save for later!');
    }

}
