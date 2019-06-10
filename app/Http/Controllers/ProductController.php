<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::orderBy('created_at', 'desc')->paginate(8);

        return view('home', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd('hello');

        $attributes = $this->formValidator();

        if ($request->hasFile('product_image'))
        {
            //Get filename with extension
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();

            //get only file name without extention
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //get only extention
            $extention = $request->file('product_image')->getClientOriginalExtension();

            //generate name for storage
            $fileNameToStore = $fileName.'_'.time().'.'.$extention;

            //
            $path = $request->file('product_image')->storeAs('public/images/'.$request->item.'/', $fileNameToStore);

            //add filename to attributes
            $attributes['product_image'] = $fileNameToStore;

        }

        Product::create($attributes);

      return redirect('/products');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product/show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }


    public function formValidator()
    {
        return request()->validate([

               'item' => ['required', 'string'],
               'quantity' => ['required', 'integer'],
               'description' => ['required', 'string'],
               'price' => ['required', 'string'],
               'product_image' => ['required', 'image', 'max:1999']
        ]);
    }
}

