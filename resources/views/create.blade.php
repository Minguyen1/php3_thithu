@extends('layout')

@section('title', 'Thêm sản phẩm')

@section('content')
    <div class="container my-5">
        <h2>Thêm sản phẩm mới</h2>
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="">Description</label>
                <textarea name="description" rows="5" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="">Price</label>
                <input type="number" name="price" class="form-control">
            </div>
            <div class="mb-3">
                <label for="">Quantity</label>
                <input type="number" name="quantity" class="form-control">
            </div>
            <div class="mb-3">
                <label for="">Active</label>
                <select name="is_active" required>
                    <option value="" disabled>Trạng thái</option>
                    <option value="1">Còn hàng</option>
                    <option value="0">Hết hàng</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="">Image</label>
                <input type="file" name="image" class="form-control">
            </div>
    
            <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
        </form>
    </div>
@endsection