@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Product Update') }}</div>
                    <div class="card-body d-flex flex-wrap">

                        <form action="/admin/products/{{$product->id}}" method="POST" class="col-12">
                            @csrf
                            @method('patch')
                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="name" value="{{$product->name}}">
                            </div>
                            @error('name')
                                <div class="alert-danger alert">{{$message}}</div>
                            @enderror
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price</label>
                                <input type="text" class="form-control" id="productPrice" name="price" value="{{$product->price}}">
                            </div>
                            @error('price')
                            <div class="alert-danger alert">{{$message}}</div>
                            @enderror
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Product Describe</label>
                                <textarea class="form-control" id="productDescription" name="description" rows="3">{{$product->description}}</textarea>
                            </div>
                            @error('description')
                            <div class="alert-danger alert">{{$message}}</div>
                            @enderror
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="/admin/products" class="btn btn-secondary">Back</a>
                        </form>

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
