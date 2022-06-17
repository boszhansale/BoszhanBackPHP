@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.basket.update',$basket->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Продукт</label>
                    <select name="product_id" class="form-control">
                        @foreach($products as $product)
                            <option {{$basket->product_id == $product->id ? 'selected':''}} value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Цена </label>
                    <input type="text" class="form-control" name="price" value="{{$basket->price}}" required>
                </div>
                <div class="form-group">
                    <label for="">кол.</label>
                    <input type="text" class="form-control" name="count" value="{{$basket->count}}" required>
                </div>


            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
