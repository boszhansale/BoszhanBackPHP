@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.label-product.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group">
                <label for="">barcode</label>
                <input type="text" class="form-control" name="barcode">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h1>kz</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_kz" required>
                </div>
                <div class="form-group">
                    <label for="name">Состав</label>
                    <textarea name="composition_kz" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_kz" value="ЖШС СТ 130740008859-03-2022">
                </div>
                <div class="form-group">
                    <label for="">текст даты</label>
                    <input type="text" class="form-control" name="date_create_kz">
                </div>
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_kz" id="" cols="10" rows="10" class="form-control"></textarea>
                </div>

            </div>
            <div class="col-md-4">
                <h1>ru</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_ru" required>
                </div>
                <div class="form-group">
                    <label for="name">Состав</label>
                    <textarea name="composition_ru" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_ru">
                </div>
                <div class="form-group">
                    <label for="">текст даты</label>
                    <input type="text" class="form-control" name="date_create_ru">
                </div>
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_ru" id="" cols="10" rows="10" class="form-control"></textarea>
                </div>

            </div>
            <div class="col-md-4">
                <h1>en</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_en" required>
                </div>
                <div class="form-group">
                    <label for="name">Состав</label>
                    <textarea name="composition_en" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_en">
                </div>
                <div class="form-group">
                    <label for="">текст даты</label>
                    <input type="text" class="form-control" name="date_create_en" value="Date of manufacture and packaging">
                </div>
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_en" id="" cols="10" rows="10" class="form-control">Manufacturer: Pervomayskie Delikatesy LLP,Republic of Kazakhstan, Almaty region, Ili district,Koyankus village,Abay Street, No. 200 tel: +7(727)260-36-48</textarea>
                </div>

            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
