@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="well">
            @include('inc.errors')
        </div>

        <div class="container">

            @if(Cart::instance('default')->count() > 0)

                <h2>{{ Cart::count() }} Item(s) in Cart</h2>

                <table class="table" style="margin-top:1rem">

                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price (USD)</th>
                            <th>Total (USD)</th>
                        </tr>
                    </thead>

            @endif

            {{-- @if(auth()->user() && auth())

            @else

            @endif
 --}}
            @forelse (Cart::instance('default')->content() as $product)

                <tr>
                    <tbody>

                        <td>
                            <a href="products/{{ $product->model->item }}">
                                <img style="max-height:120px; align:center; padding:0.5rem"
                                src="storage/images/{{ $product->model->item }}/{{ $product->options->image }}" alt="{{ $product->item }}">
                            </a></td>

                        <td style="margin-left:2rem;"><a href="products/{{ $product->model->item }}">{{ $product->model->item }}</a></td>

                        <td style="margin-left:2rem;">

                            <form action="/cart/{{ $product->id }}" method="post">
                                @csrf
                                @method("PATCH")
                                <input type="hidden" name="rowId" value="{{ $product->rowId }}">
                                <input type="number" name="quantity" max="{{ $product->options->max_qty }}" onchange="this.form.submit()" class="form-control-sm " style="max-width:4rem" type="number" value="{{ $product->qty }}">
                            </form><br>

                        </td>

                        <td style="margin-left:2rem ">{{ $product->model->price }}</td>

                        <td style="margin-left:2rem;">{{ $product->total }}</td>

                        <td>
                            <div style="padding:0.5rem">
                                <form action="/cart/{{ $product->rowId }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-default" type="submit">Remove</button>
                                </form>
                            </div>

                            <div style="padding:0.5rem">
                                <form action="/cart/saveForLater/{{ $product->rowId }}" method="post">
                                    @csrf
                                    <button class="btn btn-default" type="submit">Save for later</button>
                                </form>
                            </div>
                        </td>

                    </tbody>

                </tr>

                @empty
                    <h3>No item(s) in the cart</h3>
                    <a class="btn btn-primary" href="/products">Add items to Cart</a>
                @endforelse

            </table>

            @if(Cart::instance('default')->count() > 0)

                <div class="jumbotron">
                    <div class="row">
                        <div class="col">
                            <p>Shipping is free.</p>
                        </div>

                        <div class="col">
                            <table>
                                <tr>
                                    <th>Subtotal</th>
                                    <td style="padding-left:2rem">{{ Cart::subtotal() }}</td>
                                </tr>

                                <tr>
                                    <th>Tax</th>
                                    <td style="padding-left:2rem">{{ Cart::tax() }}</td>
                                </tr>

                                <tr>
                                    <th>Total</th>
                                    <td style="padding-left:2rem"><strong>{{ Cart::total() }}</strong></td>
                                </tr>

                            </table>

                        </div>
                </div><br>

                <div class="row">

                    <a class="btn btn-info" style="margin-bottom:1rem; margin-right:23rem " href="/products">Continue Shopping</a>

                    <a class="btn btn-primary" style="margin-bottom:1rem; " href="/checkout">Proceed to checkout</a>

                </div>

                </div>

            @endif

        </div>

        {{-- Saved for later --}}

        <div class="container" style="margin-top:2rem;">

                <div class="container">

                        @if(Cart::instance('savedForLater')->count() > 0)

                            <h2>{{ Cart::instance('savedForLater')->count() }} Item(s) saved for later</h2>

                            <table class="table" style="margin-top:1rem">
                                <thead>
                                    <tr>
                                        <th>Product Image</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>

                        @endif

                        @foreach(Cart::instance('savedForLater')->content() as $savedForLater)

                            <tr>
                                <tbody>

                                     <td>
                                        <a href="products/{{ $savedForLater->name }}">
                                            <img style="max-height:120px; align:center; padding:0.5rem"
                                            src="storage/images/{{ $savedForLater->name }}/{{ $savedForLater->options->image }}" alt="{{ $savedForLater->id }}">
                                        </a>
                                    </td>

                                    <td><a href="products/{{ $savedForLater->item }}">{{ $savedForLater->name }}</a></td>

                                    <td>{{ $savedForLater->qty }}</td>

                                    <td>{{ $savedForLater->price }}</td>

                                    <td>{{ $savedForLater->total }}</td>

                                    <td>
                                        <div style="padding:0.5rem">
                                            <form action="/saveForLater" method="post">
                                                @csrf
                                                <input type="hidden" name="rowId" value="{{ $savedForLater->rowId }}">
                                                <button class="btn btn-default" type="submit">Move to cart</button>
                                            </form>
                                        </div>

                                        <div style="padding:0.5rem">
                                            <form action="/saveForLater/{{ $savedForLater->rowId }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-default" type="submit">Remove</button>
                                            </form>
                                        </div>

                                    </td>

                                </tbody>

                            </tr>


                            @endforeach

                        </table>

        </div>

        <h3 style="margin-top:2rem">Recommended</h3>

        <div class="row">

            @foreach ($recommend as $recommended )

                <div class="card" style="width:18rem; margin:1rem;" >

                    <a href="/products/{{ $recommended->item }}">

                        <img class="card-img-top" style="max-height:150px; " src="storage/images/{{ $recommended->item }}/{{ $recommended->product_image }}" alt="{{ $recommended->id }}">

                    </a>

                    <div class="card-body">

                        <div class="card-title"> {{ $recommended->item }}  <div class="pull-left">  ${{ $recommended->price }}</div>  </div>

                    </div>

                    <form action="/cart" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $recommended->id }}">

                        <input type="hidden" name="item" value="{{ $recommended->item }}">

                        <input type="hidden" name="image" value="{{ $recommended->product_image }}">

                        <input type="hidden" name="max_quantity" value="{{ $recommended->quantity }}">

                        <input type="hidden" name="price" value="{{ $recommended->price }}">

                        <button style="margin-left:5rem" class="btn btn-primary" type="submit">Add to Cart</button>
                    </form>



                </div>

            @endforeach

        </div>

    </div>

@endsection
