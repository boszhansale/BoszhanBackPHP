@extends('cashier.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('cashier.label-product.store')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">штрихкод</label>
                    <input type="text" class="form-control" name="barcode">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">вес</label>
                    <input type="number" name="weight" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">категория</label>
                    <select name="label_category_id" required class="form-control">
                        <option value="">Выберите категорию</option>
                        @foreach(\App\Models\LabelCategory::all() as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="align">align</label>
                    <select class="form-control" name="align" id="align">
                        <option value="left">с лево</option>
                        <option value="center">центр</option>
                        <option value="right">с право</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">единица измерения</label>
                    <select name="measure" class="form-control">
                        <option value="2">весовой</option>
                        <option value="1">шт</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h1>kz-ru</h1>
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
                    <input type="text" class="form-control" name="date_create_kz"
                           value="Дайындалған күні/Дата изготовления">
                </div>
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_kz" id="" cols="10" rows="10" class="form-control">Өндіруші:«Первомайские деликатесы» ЖШС, Қазақстан Республикасы, Алматы облысы, Іле ауданы, Қоянқұс ауылы, Абай көшесі, №200 </br>Изготовитель: ТОО«Первомайские Деликатесы», Республика Казахстан, Алматинская область, Илийский район, село Коянкус,улица Абай, №200. т:+7 775 256 22 55
                    </textarea>
                </div>

            </div>
            {{--            <div class="col-md-4">--}}
            {{--                <h1>ru</h1>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label for="">Название</label>--}}
            {{--                    <input type="text" class="form-control" name="name_ru" required>--}}
            {{--                </div>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label for="name">Состав</label>--}}
            {{--                    <textarea name="composition_ru" id="" cols="30" rows="10" class="form-control"></textarea>--}}
            {{--                </div>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label for="">сертификат</label>--}}
            {{--                    <input type="text" class="form-control" name="cert_ru">--}}
            {{--                </div>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label for="">текст даты</label>--}}
            {{--                    <input type="text" class="form-control" name="date_create_ru" value="Дата изготовления и упаковывания">--}}
            {{--                </div>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label for="name">адрес</label>--}}
            {{--                    <textarea name="address_ru" id="" cols="10" rows="10" class="form-control"></textarea>--}}
            {{--                </div>--}}

            {{--            </div>--}}
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
                    <input type="text" class="form-control" name="date_create_en"
                           value="Date of manufacture and packaging">
                </div>
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_en" id="" cols="10" rows="10" class="form-control">Manufacturer: Pervomayskie Delikatesy LLP,</br>Republic of Kazakhstan, Almaty region, Ili district,Koyankus village,Abay Street, No. 200</br>tel: +7(727)260-36-48</textarea>
                </div>


            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
