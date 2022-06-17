@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.product.update',$product->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
       <div class="row">
           <div class="col-md-6">
               <div class="form-group">
                   <label for="">Название</label>
                   <input type="text" class="form-control" name="name" value="{{$product->name}}">
               </div>
               <div class="form-group">
                   <label for="">ID 1C</label>
                   <input type="text" class="form-control" name="id_1c" value="{{$product->id_1c}}">
               </div>
               <div class="form-group">
                   <label for="">Артикул</label>
                   <input type="text" class="form-control" name="article" value="{{$product->article}}">
               </div>
               <div class="form-group ">
                   <label for="">Мерка</label>
                   <select name="measure"  class="form-control">
                       <option {{ $product->measure == 1 ? 'selected':'' }} value="1">штука(1)</option>
                       <option {{ $product->measure == 2 ? 'selected':'' }} value="2">кг(2)</option>
                   </select>
               </div>

               <div class="form-group ">
                   <label for="">Категория</label>
                   <select name="category_id"  class="form-control">
                       @foreach($categories as $category)
                           <option {{$product->category_id == $category->id ? 'selected':''}} value="{{$category->id}}">{{$category->brand->name}} - {{$category->name}}</option>
                       @endforeach
                   </select>
               </div>

               <div class="form-group">
                   <label for="">barcode</label>
                   <input type="text" class="form-control" name="barcode" value="{{$product->barcode}}">
               </div>
               <div class="form-group">
                   <label for="">остаток</label>
                   <input type="number" class="form-control" name="remainder" value="{{$product->remainder}}">
               </div>


               <div class="form-group">
                   <label for="">Скидка %</label>
                   <input type="number" class="form-control" name="discount" value="0">
               </div>
               <div class="form-check">
                   <input type="checkbox" class="form-check-input" name="hit" {{$product->hit ? "selected":''}}   id="product_hit">
                   <label class="form-check-label" for="product_hit">ярлык Хит</label>
               </div>
               <div class="form-check">
                   <input type="checkbox" class="form-check-input" name="new" {{$product->new ? "selected":''}}  id="product_new">
                   <label class="form-check-label" for="product_new">ярлык Новый</label>
               </div>

               <div class="form-check">
                   <input type="checkbox" class="form-check-input" name="action" {{$product->action ? "selected":''}}   value="1" id="product_action">
                   <label class="form-check-label" for="product_action">ярлык Акция</label>
               </div>
               <div class="form-check">
                   <input type="checkbox" class="form-check-input" name="discount_5" {{$product->discount_5 ? "selected":''}} value="1" id="product_discount_5">
                   <label class="form-check-label" for="product_discount_5"> ярлык Скидка 5%</label>
               </div>
               <div class="form-check">
                   <input type="checkbox" class="form-check-input" name="discount_10" {{$product->discount_10 ? "selected":''}} value="1" id="product_discount_10">
                   <label class="form-check-label" for="product_discount_10"> ярлык Скидка 10%</label>
               </div>

               <div class="form-check">
                   <input type="checkbox" class="form-check-input" name="discount_15" {{$product->discount_15 ? "selected":''}} value="1" id="product_discount_15">
                   <label class="form-check-label" for="product_discount_15"> ярлык Скидка 15%</label>
               </div>
               <div class="form-check">
                   <input type="checkbox" class="form-check-input" name="discount_20" {{$product->discount_20 ? "selected":''}} value="1" id="product_discount_20">
                   <label class="form-check-label" for="product_discount_20"> ярлык Скидка 20%</label>
               </div>


           </div>
           <div class="col-md-6">
               @foreach($priceTypes as $k => $priceType)
                   <div>
                       <label for="">
                           {{$priceType->name}}
                           <small>{{$priceType->description}}</small>
                       </label>
                       <input type="hidden" name="price_types[{{$k}}][price_type_id]" value="{{$priceType->id}}">
                       @if($product->prices()->where('price_type_id',$priceType->id)->exists())
                           <input class="form-control" type="number" name="price_types[{{$k}}][price]" value="{{$product->prices()->where('price_type_id',$priceType->id)->first()->price}}">
                       @else
                           <input class="form-control" type="number" name="price_types[{{$k}}][price]" value="0">
                       @endif
                   </div>
               @endforeach
           </div>
       </div>
       <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">фото</label>
                    <input type="file" multiple name="images[]" class="form-control" accept="image/*">
                </div>
                <div class="row align-items-center">
                    @foreach($product->images as $img)
                        <div class="col">
                            <a class="mb-4" target="_blank" href="{{$img->path}}">
                                <img src="{{$img->path}}" width="150">
                            </a>
                            <br>
                            <a class="btn btn-danger" href="{{route('admin.product.deleteImage',$img->id)}}">удалить</a>
                        </div>
                    @endforeach
                </div>
            </div>
       </div>
       <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
