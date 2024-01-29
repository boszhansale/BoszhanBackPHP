@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.label-product.update',$labelProduct->id)}}" method="post"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="form-group">
                <label for="">barcode</label>
                <input type="text" class="form-control" name="barcode" value="{{$labelProduct->barcode}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h1>kz</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_kz" value="{{$labelProduct->name_kz}}" required>
                </div>
                <div class="form-group">
                    <label for="name">Состав</label>
                    <textarea name="composition_kz" id="" cols="30" rows="10"
                              class="form-control">{{$labelProduct->composition_kz}}</textarea>
                </div>
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_kz" value="{{$labelProduct->cert_kz}}">
                </div>
                <div class="form-group">
                    <label for="">текст даты</label>
                    <input type="text" class="form-control" name="date_create_kz" value="{{$labelProduct->date_create_kz}}">
                </div>
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_kz" id="" cols="10" rows="10"
                              class="form-control">{{$labelProduct->address_kz}}</textarea>
                </div>

            </div>
            <div class="col-md-4">
                <h1>ru</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_ru" value="{{$labelProduct->name_ru}}" required>
                </div>
                <div class="form-group">
                    <label for="name">Состав</label>
                    <textarea name="composition_ru" id="" cols="30" rows="10"
                              class="form-control">{{$labelProduct->composition_ru}}</textarea>
                </div>
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_ru" value="{{$labelProduct->cert_ru}}">
                </div>
                <div class="form-group">
                    <label for="">текст даты</label>
                    <input type="text" class="form-control" name="date_create_ru" value="{{$labelProduct->date_create_ru}}">
                </div>
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_ru" id="" cols="10" rows="10"
                              class="form-control">{{$labelProduct->address_ru}}</textarea>
                </div>

            </div>
            <div class="col-md-4">
                <h1>en</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_en" value="{{$labelProduct->name_en}}" required>
                </div>
                <div class="form-group">
                    <label for="name">Состав</label>
                    <textarea name="composition_en" id="" cols="30" rows="10"
                              class="form-control">{{$labelProduct->composition_en}}</textarea>
                </div>
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_en" value="{{$labelProduct->cert_en}}">
                </div>
                <div class="form-group">
                    <label for="">текст даты</label>
                    <input type="text" class="form-control" name="date_create_en" value="{{$labelProduct->date_create_en}}">
                </div>
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_en" id="" cols="10" rows="10"
                              class="form-control">{{$labelProduct->address_en}}</textarea>
                </div>

            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>

@endsection
