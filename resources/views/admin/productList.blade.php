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
                    <a href="/admin/products/create" class="m-2"><button class="btn btn-primary">Create New Product</button></a>
                    <div class="card-header">{{ __('Product List') }}</div>
                    <div class="card-body d-flex flex-wrap">

                        {{--dánh sachs sản phẩm--}}
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- Duyệt danh sách sản phẩm --}}
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>$ {{ $product->price }}</td>
                                    <td>
                                        <a href="/admin/products/{{$product->id}}/edit" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="/admin/products/{{$product->id}}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

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
