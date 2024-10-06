@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Product List') }}</div>
                <div class="card-body d-flex flex-wrap">


                    {{--dánh sachs sản phẩm--}}
                    @foreach($products as $product)

                            <div class="card mb-3 mx-1" style="height: 180px; width: 265px">
                                <div class="card-body">
                                    <form action="{{route('stripe')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_name" id="" value="{{$product->name}}">
                                        <input type="hidden" name="quantity" id="" value="1">
                                        <input type="hidden" name="price" id="" value="{{$product->price}}">

                                    <h5 class="card-title">{{$product->name}}</h5>
                                    <p class="card-text">ID: {{$product->id}}</p>
                                    <p class="card-text">$ {{$product->price}}</p>
                                    <a href="products/payment/{{$product->id}}">
                                        <button class="btn btn-primary" type="submit">Buy Now</button>
                                    </a>
                                    </form>
                                </div>
                            </div>
                    @endforeach
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
