@extends('layout')

@section('title', 'Trang chủ')

@section('content')
    <div class="container my-5">
        <a class="btn btn-primary float-end my-3" href="{{ route('product.create') }}">Thêm sản phẩm</a>
        <h2>Danh sách sản phẩm</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Active</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ number_format($product->price, 2) }} VNĐ</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->is_active ? 'Còn hàng' : 'Hết hàng' }}</td>
                        <td><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100px"></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
@endsection