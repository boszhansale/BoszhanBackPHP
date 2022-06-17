@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.basket.store',$order->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{$type}}" name="type">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Продукт</label>
                    <select name="product_id" class="form-control">
                        @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Цена </label>
                    <input type="text" class="form-control" name="price" required>
                </div>
                <div class="form-group">
                    <label for="">кол.</label>
                    <input type="text" class="form-control" name="count" required>
                </div>


            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
