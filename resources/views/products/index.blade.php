@extends('layouts.app')

@section('title', 'Our Products')

@section('content')

<div class="container">

    <div class="row">

        @forelse($products as $product )

            <div class="card" style="width:18rem; margin:1rem" >

                <a href="products/{{ $product->item }}">

                    <img class="card-img-top" style="max-height:150px; " src="storage/images/{{ $product->item }}/{{ $product->product_image }}" alt="{{ $product->id }}">

                </a>

                <div class="card-body">

                    <div class="card-title "> {{ $product->item }}  <div class="pull-right" ><strong>${{ $product->price }}</strong></div>  </div>

                        <p class="card-text"> {{ $product->description }}</p>

                    </div>

                    <form action="/cart" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">

                        <input type="hidden" name="item" value="{{ $product->item }}">

                        <input type="hidden" name="image" value="{{ $product->product_image }}">

                        <input type="hidden" name="price" value="{{ $product->price }}">

                        <input type="hidden" name="max_quantity" value="{{ $product->quantity }}">

                        <button style="margin-left:5rem" class="btn btn-primary" type="submit">Add to Cart</button>
                    </form>
            </div>

        @empty

            <h2>There are no products in the shop</h2>

        @endforelse

    </div>

</div>

{{ $products->links() }}

@endsection




