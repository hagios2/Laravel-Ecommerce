@extends('layouts.app')

@section('title', 'Thank you')

@section('content')

    <div class="container">
        <h2>Thank you</h2>
        @include('inc.errors')

        <a href="/products">Go to Shop</a>
    </div>
@endsection

