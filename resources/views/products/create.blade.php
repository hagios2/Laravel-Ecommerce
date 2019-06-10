@extends('layouts.app')

@section('title', 'New Products')

@section('content')

    <div class="container">

        <form method="POST" action="/products" enctype="multipart/form-data">
            @csrf

                <div class="form-group">
                    <label for="InputItem">Product Name</label>

                    <input type="text" class="form-control {{ $errors->has('item') ? 'alert alert-danger' : ""}}" name="item" placeholder="Enter Item" value="{{ old('item') }}">
                </div>

                <div class="form-group">
                    <label for="InputPrice">Product Price</label>

                    <input type="text" class="form-control {{ $errors->has('price') ? 'alert alert-danger' : ""}}" name="price" placeholder="Enter Price" value="{{ old('price') }}">
                </div>

                <div class="form-group">
                    <label for="InputQuantity">Product Quantity</label>

                    <input type="number" class="form-control {{ $errors->has('quantity') ? 'alert alert-danger' : ""}}" name="quantity" placeholder="Enter quantity available" value="{{ old('quantity') }}" >
                </div>

                <div class="form-group">
                    <label for="formGroupDescriptionInput">Description</label>
                    <textarea class="form-control {{$errors->has('description') ? 'alert alert-danger' : ""}}" name="description" cols="30" rows="10" placeholder="description">{{old('description')}}</textarea>
                </div>

                <div class="form-group">
                    <label for="formGroupFile">Product Image</label>

                    <input type="file" class="form-control-file" name="product_image" value="{{ old('file') }}">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Add Project</button>
                </div>
    </form>

    </div>

@endsection
