@extends('layouts.app')

@section('title', 'Our Products')

@@section('content')
<div class="row">

    @foreach ($products as $product )

        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="" alt="">

                <div class="caption">
                    <h3>
                        thumbnail label
                    </h3>
                </div>

                <div >
                    <a style="width:30px" class="btn btn-primary" href="">

                    </a>

                </div>
            </div>
        </div>

    @endforeach

    </div>
@endsection




