<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Product;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recommend = Product::inRandomOrder()->take(6)->get();

        return view('userCart.carts', compact('recommend'));
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
       
       $duplicateInSavedForLater = Cart::instance('savedForLater')->search(function ($cartItem, $rowId) use ($request){
            return $cartItem->id === $request->id;
        });

        if($duplicateInSavedForLater->isEmpty())
        {
            if($this->checkMaxQuantityAndStore($request))
            {
                Cart::instance('default')->add($request->id, $request->item, 1, $request->price, ['image' => $request->image, 'max_qty' => $request->max_quantity])
                    ->associate('App\Product');

                return redirect('/cart')->with('success', 'Item added to cart');
            }else {
                return redirect('/cart')->with('info', 'Item has reached maximum quantity in stock');
            }
            
        }else {
            return redirect('/cart')->with('info', 'Item already saved to cart, Check items in Saved for later');
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
        $recommended = Product::where('id' !== $id)->inRandomOrder()->take(5)->get();

        return view('show', compact('recommended'));
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
      
        $rowId = $request->rowId;

        $item = Cart::instance('default')->get($rowId);

       // return $item;

        if($item->qty < $item->options->max_qty && $request->quanity < $item->options->max_qty)
        {
            Cart::instance('default')->update($rowId, $request->quantity);
        }else {
            Cart::instance('default')->update($rowId, $item->max_quantity);
        }
           
        return redirect('/cart');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rowId = $id;

        Cart::remove($rowId);

        return redirect('/cart')->with('success', 'Item was removed successfully');
    }

    public function saveForLater($id)
    {
        $rowId = $id;
        $item = Cart::get($rowId);

        //return $item;

        Cart::remove($id);

        Cart::instance('savedForLater')->add($item->id, $item->name, $item->qty, $item->price, ['image' => $item->options->image, 'max_qty' => $item->options->max_qty])
                ->associate('App\Product');

        //return Cart::instance('savedForLater')->content();

        return redirect('/cart')->with('success', 'Item has been saved for later');
    }

    public function checkMaxQuantityAndStore(Request $request)
    {
        $duplicateInCart = Cart::instance('default')->search(function ($cartItem, $rowId) use ($request){
            return $cartItem->id === $request->id;
        });

        if ($duplicateInCart->isNotEmpty()) {
            
            if ($duplicateInCart->qty < $duplicateInCart->options->max_qty) {
                
                return true;

            }else{
                return false;
            }
        }else {
            return true;
        }

    }
}
