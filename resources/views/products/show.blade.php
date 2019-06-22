@extends('layouts.app')

@section('title', 'Products')

@section('content')

    <div class="container">

        <div class="jumbotron">

                <h1>{{ $product->item }}</h1>

                <div style="width:70%">
                    <img style="width:100%" src="/storage/images/{{ $product->item }}/{{$product->product_image}}" alt="{{$product->id}}">
                </div>

                <p>In Stock:    {{ $product->quantity }}</p>
                <h4>{{ $product->description }}</h4>

        </div>

    </div>


@endsection
