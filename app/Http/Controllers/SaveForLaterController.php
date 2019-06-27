<?php

namespace App\Http\Controllers;
use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Http\Request;

class SaveForLaterController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //return $request;
        $rowId = $request->rowId;

        $item = Cart::instance('savedForLater')->get($rowId);
        
        Cart::instance('savedForLater')->remove($rowId);

        Cart::instance('default')->add($item->id, $item->name, $item->qty, $item->price, ['image' => $item->options->image, 'max_qty' => $item->options->max_qty])
            ->associate('App\Product');

        return redirect('/cart')->with('success', 'Item has been moved to cart');
 
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

        Cart::instance('savedForLater')->remove($rowId);

        return redirect('/cart')->with('success', 'Item has been removed from save lor later');
    }
}
